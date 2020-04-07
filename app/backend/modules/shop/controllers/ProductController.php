<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\shop\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AliyunOss;
use common\helpers\Util;
use backend\models\shop\Product;
use backend\models\shop\ProductSearch;
use backend\components\Controller;
use backend\actions\CheckAction;
use backend\actions\BatchAction;
use backend\actions\RecycleAction;
use backend\widgets\fileupload\FileUploadAction;
use backend\widgets\ueditor\UEditorAction;
use backend\models\shop\ProductCate;
use backend\widgets\edititem\EditItemAction;
use backend\widgets\select2\Select2TagAction;
use backend\models\cms\Tag;
use backend\models\cms\TagAssign;
use backend\models\cms\DiyField;
use backend\models\cms\Column;

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
                'kid' => $request->post('kid'),
                'field' => 'orderid',
                'value' => $request->post('value'),
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => Product::class,
                'kid' => $request->get('kid'),
                'openName' => '上架',
                'closeName' => '禁售',
            ],
            'batch' => [
                'class' => BatchAction::class,
                'className' => Product::class,
                'type' => $request->get('type'),
                'stateField' => 'delstate',
                'timeField' => 'deltime',
            ],
            //垃圾管理
            'recycle' => [
                'class' => RecycleAction::class,
                'className' => Product::class,
                'type' => $request->get('type'),
                'field' => 'delstate',
            ],
            //获取标签
            'get-tags' => [
                'class' => Select2TagAction::class,
                'modelClass' => Product::class,
                'tagClass' => Tag::class,
                'tagAssignClass' => TagAssign::class,
                'keyword' => Yii::$app->getRequest()->get('keyword'),//要搜索的内容
                'limit' => 20,//每次请求返回限制数量
                'page' => Yii::$app->getRequest()->get('page'),//默认请求第一页
            ],
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_DEFAULT.'/product',
            ],
            'multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picarr',
                'folder' => AliyunOss::OSS_DEFAULT.'/product',
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/product',
                'config' => [],
            ],
            'diyfield-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/product',
            ],
            'diyfield-multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_MULTI_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/product',
            ],
            'diyfield-ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/product',
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
            'columnModel' => Column::findOne($searchModel->columnid),
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
        $model->slug = Util::Shorturl(microtime().Util::GenerateRandomString());
        $model->columnid = Yii::$app->getRequest()->post("Product")['columnid'];

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
        $model->touch('deltime');
        $model->updateAttributes(['delstate' => Product::IS_DEL]);//标记为垃圾
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => true,
                'msg' => $model->title.' 已经移到垃圾桶！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->title.' 已经移到垃圾桶！');
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
