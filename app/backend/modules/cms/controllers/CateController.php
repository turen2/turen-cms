<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\modules\cms\controllers;

use Yii;
use app\models\cms\Cate;
use app\models\cms\CateSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\BuildHelper;
use app\actions\MoveAction;
use app\actions\CheckAction;

/**
 * CateController implements the CRUD actions for Cate model.
 */
class CateController extends Controller
{
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'move' => [
                'class' => MoveAction::class,
                'className' => Cate::class,
                'id' => $request->get('id'),
                'pid' => $request->get('pid'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameFeild' => 'catename',
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => Cate::class,
                'id' => $request->get('id'),
            ],
        ];
    }
    
    /**
     * @inheritdoc
      * 强制使用post进行删除操作，post受csrf保护
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'batch' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $dataProvider = BuildHelper::rebuildDataProvider($dataProvider, Cate::class, 'id', 'parentid');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Cate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid = null)
    {
        $model = new Cate();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->catename.' 添加成功，结果将展示在列表中。');
            return $this->redirect(['index']);
        } else {
            
            $maxRow = Cate::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
            if($maxRow) {
                $model->orderid = $maxRow['orderid'] + 1;
            }
            if(!is_null($pid)) {
                $model->parentid = $pid;
            }
            
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->catename.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing Cate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionCheck($id)
    {
        $model = $this->findModel($id);
        $model->status = !$model->status;
        $model->save(false);//效果在界面上有显示

        return $this->redirect(['index']);
    }
    
    /**
     * 批量提交并处理
     * @param string $type delete | order
     * @return \yii\web\Response
     */
    public function actionBatch($type)
    {
        if($type == 'delete') {
            $tips = '';
            foreach (Cate::find()->current()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                if(Cate::find()->current()->andWhere(['parentid' => $model->id])->exists()) {
                    $tips .= '<li style="color: red;">'.$model->catename.' 中的子类别不为空，请先删除子类别！</li>';
                } else {
                    $model->delete();
                    $tips .= '<li>'.$model->catename.' 删除成功！</li>';
                }
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('id', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = Cate::find()->current()->andWhere(['id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Cate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        
        if(Cate::find()->current()->andWhere(['parentid' => $model->id])->exists()) {
            if(Yii::$app->getRequest()->isAjax) {
                return $this->asJson([
                    'state' => false,
                    'msg' => $model->catename.' 中的子类别不为空，请先删除子类别！',
                ]);
            }
            
            Yii::$app->getSession()->setFlash('warning', $model->catename.' 中的子类别不为空，请先删除子类别！');
        } else {
            
            //分类中有文章、图片、文件、视频等，要么不允许删除，要么统一重置为0
            
            $model->delete();
            
            if(Yii::$app->getRequest()->isAjax) {
                return $this->asJson([
                    'state' => true,
                    'msg' => $model->catename.' 已经成功删除！',
                ]);
            }
            
            Yii::$app->getSession()->setFlash('success', $model->catename.' 已经成功删除！');
        }
        
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the Cate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Cate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cate::find()->current()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
