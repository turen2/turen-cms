<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\ext\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\BuildHelper;
use backend\models\ext\AdType;
use backend\models\ext\AdTypeSearch;
use backend\components\Controller;
use backend\actions\MoveAction;
use backend\actions\CheckAction;

/**
 * AdTypeController implements the CRUD actions for AdType model.
 */
class AdTypeController extends Controller
{
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'quick-move' => [
                'class' => MoveAction::class,
                'className' => AdType::class,
                'kid' => $request->get('kid'),
                'pid' => $request->get('pid'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameField' => 'typename',
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => AdType::class,
                'kid' => $request->get('kid'),
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
     * Lists all AdType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = BuildHelper::rebuildDataProvider($dataProvider, AdType::class, 'id', 'parentid');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AdType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid = null)
    {
        $model = new AdType();
        $model->loadDefaultValues();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', $model->typename.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            
            $maxRow = AdType::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
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
     * Updates an existing AdType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->typename.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
            foreach (AdType::find()->current()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                if(AdType::find()->current()->andWhere(['parentid' => $model->id])->exists()) {
                    $tips .= '<li style="color: red;">'.$model->typename.' 中的子广告位不为空，请先删除子广告位！</li>';
                } else {
                    $model->delete();
                    $tips .= '<li>'.$model->typename.' 删除成功！</li>';
                }
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = AdType::find()->current()->andWhere(['id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }
    
    /**
     * Deletes an existing AdType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        
        if(AdType::find()->current()->andWhere(['parentid' => $model->id])->exists()) {
            if(Yii::$app->getRequest()->isAjax) {
                return $this->asJson([
                    'state' => false,
                    'msg' => $model->typename.' 中的子广告位不为空，请先删除子广告位！',
                ]);
            }
            
            Yii::$app->getSession()->setFlash('warning', $model->typename.' 中的子广告位不为空，请先删除子广告位！');
        } else {
            $model->delete();
            
            if(Yii::$app->getRequest()->isAjax) {
                return $this->asJson([
                    'state' => true,
                    'msg' => $model->typename.' 已经成功删除！',
                ]);
            }
            
            Yii::$app->getSession()->setFlash('success', $model->typename.' 已经成功删除！');
        }
        
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the AdType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AdType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdType::find()->current()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
