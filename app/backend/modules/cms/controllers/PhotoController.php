<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\cms\controllers;

use Yii;
use app\models\cms\Photo;
use app\models\cms\PhotoSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\widgets\select2\Select2Action;
use app\models\cms\Tag;
use common\components\AliyunOss;
use app\widgets\fileupload\FileUploadAction;
use app\actions\RecycleAction;
use app\actions\BatchAction;
use app\actions\CheckAction;
use app\widgets\ueditor\UEditorAction;
use app\widgets\edititem\EditItemAction;

/**
 * PhotoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller
{
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'edit-item' => [
                'class' => EditItemAction::class,
                'className' => Photo::class,
                'id' => $request->post('id'),
                'field' => 'orderid',
                'value' => $request->post('value'),
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => Photo::class,
                'id' => $request->get('id'),
            ],
            'batch' => [
                'class' => BatchAction::class,
                'className' => Photo::class,
                'type' => $request->get('type'),
                'stateField' => 'delstate',
                'timeField' => 'deltime',
            ],
            //垃圾管理
            'recycle' => [
                'class' => RecycleAction::class,
                'className' => Photo::class,
                'type' => $request->get('type'),
                'field' => 'delstate',
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
                'folder' => AliyunOss::OSS_DEFAULT.'/photo',
            ],
            'multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picarr',
                'folder' => AliyunOss::OSS_DEFAULT.'/photo',
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/photo',
                'config' => [],
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
                ],
            ],
        ];
    }

    /**
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Photo();

        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->title.' 添加成功，结果将展示在列表中。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->title.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            //var_dump($model->getErrors());
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Photo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        $model->touch('deltime');
        $model->updateAttributes(['delstate' => Photo::IS_DEL]);//标记为垃圾
        
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
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Photo::find()->current()->delstate(Photo::IS_NOT_DEL)->andWhere(['id' => $id])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
