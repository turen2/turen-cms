<?php

namespace app\modules\shop\controllers;

use Yii;
use app\models\shop\Product;
use app\models\shop\ProductSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;
use app\actions\BatchAction;
use app\actions\RecycleAction;
use app\widgets\select2\Select2Action;
use app\models\cms\Tag;
use app\widgets\fileupload\FileUploadAction;
use common\components\aliyunoss\AliyunOss;
use app\widgets\ueditor\UEditorAction;
use app\models\shop\ProductCate;
use app\widgets\edititem\EditItemAction;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
            'edit-item' => [
                'class' => EditItemAction::class,
                'className' => Product::class,
                'id' => $request->post('id'),
                'field' => 'orderid',
                'value' => $request->post('value'),
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => Product::class,
                'id' => $request->get('id'),
                'openName' => '上架',
                'closeName' => '禁售',
            ],
            'batch' => [
                'class' => BatchAction::class,
                'className' => Product::class,
                'type' => $request->get('type'),
                'stateFeild' => 'delstate',
                'timeFeild' => 'deltime',
            ],
            //垃圾管理
            'recycle' => [
                'class' => RecycleAction::class,
                'className' => Product::class,
                'type' => $request->get('type'),
                'feild' => 'delstate',
            ],
            //获取标签
            'get-tags' => [
                'class' => Select2Action::class,
                'className' => Tag::class,
                'limit' => 20,//每次请求返回限制数量
                'page' => Yii::$app->getRequest()->get('page'),//默认请求第一页
                'searchFields' => ['name'],//搜索的字段
                'valField' => 'name',//返回作为值的字段
                'showField' => 'name',//返回显示的字段
                'keyword' => Yii::$app->getRequest()->get('keyword'),//要搜索的内容
            ],
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_DEFAULT,
            ],
            'multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picarr',
                'folder' => AliyunOss::OSS_DEFAULT,
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT,
                'config' => [],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->dealAttribute(Yii::$app->request->post());
        	Yii::$app->getSession()->setFlash('success', $model->title.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->dealAttribute(Yii::$app->request->post());
        	Yii::$app->getSession()->setFlash('success', $model->title.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        $model->delete();
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => true,
                'msg' => $model->title.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->title.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }
    
    /**
     * get attribute form
     * @param string $id
     * @return mixed
     */
    public function actionAttrForm()
    {
        $pcateid = Yii::$app->getRequest()->post('pcateid', null);
        
        if(!is_null($pcateid)) {
            $productCateModel = ProductCate::findOne(['id' => $pcateid]);
            if($productCateModel) {
                return $this->asJson([
                    'state' => true,
                    'msg' => ProductCate::AttributeForm($productCateModel->id),
                ]);
            } else {
                return $this->asJson([
                    'state' => false,
                    'msg' => '分类不存在',
                ]);
            }
        } else {
            return $this->asJson([
                'state' => false,
                'msg' => '属性数据不存在',
            ]);
        }
    }
    
    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}