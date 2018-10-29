<?php

namespace app\modules\shop\controllers;

use Yii;
use app\models\shop\ProductCate;
use app\models\shop\ProductCateSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;
use app\actions\MoveAction;
use common\helpers\BuildHelper;
use app\widgets\fileupload\FileUploadAction;
use common\components\aliyunoss\AliyunOss;

/**
 * ProductCateController implements the CRUD actions for ProductCate model.
 */
class ProductCateController extends Controller
{
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
                ],
            ],
        ];
    }
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'move' => [
                'class' => MoveAction::class,
                'className' => ProductCate::class,
                'id' => $request->get('id'),
                'pid' => $request->get('pid'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameField' => 'cname',
            ],
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_DEFAULT,
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => ProductCate::class,
                'id' => $request->get('id'),
            ],
        ];
    }

    /**
     * Lists all ProductCate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = BuildHelper::rebuildDataProvider($dataProvider, ProductCate::class, 'id', 'parentid');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ProductCate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid = null)
    {
        $model = new ProductCate();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->cname.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            $maxRow = ProductCate::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
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
     * Updates an existing ProductCate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->cname.' 已经修改成功！');
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
            foreach (ProductCate::find()->current()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                if(ProductCate::find()->current()->andWhere(['parentid' => $model->id])->exists()) {
                    $tips .= '<li style="color: red;">'.$model->cname.' 中的子分类不为空，请先删除子分类！</li>';
                } else {
                    $model->delete();
                    $tips .= '<li>'.$model->cname.' 删除成功！</li>';
                }
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = ProductCate::find()->current()->andWhere(['id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }
    
    /**
     * Deletes an existing ProductCate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        //不能存在分类属性
        //分类下面不能存在产品
        
        $model = $this->findModel($id);
        
        if(ProductCate::find()->current()->andWhere(['parentid' => $model->id])->exists()) {
            if(Yii::$app->getRequest()->isAjax) {
                return $this->asJson([
                    'state' => false,
                    'msg' => $model->cname.' 中的子分类不为空，请先删除子分类！',
                ]);
            }
            
            Yii::$app->getSession()->setFlash('warning', $model->cname.' 中的子分类不为空，请先删除子分类！');
        } else {
            $model->delete();
            
            if(Yii::$app->getRequest()->isAjax) {
                return $this->asJson([
                    'state' => true,
                    'msg' => $model->cname.' 已经成功删除！',
                ]);
            }
            
            Yii::$app->getSession()->setFlash('success', $model->cname.' 已经成功删除！');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductCate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductCate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
