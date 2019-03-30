<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\cms\controllers;

use Yii;
use app\models\cms\Article;
use app\models\cms\ArticleSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AliyunOss;
use app\widgets\fileupload\FileUploadAction;
use app\actions\RecycleAction;
use app\actions\BatchAction;
use app\actions\CheckAction;
use app\widgets\ueditor\UEditorAction;
use app\widgets\edititem\EditItemAction;
use app\widgets\select2\Select2TagAction;
use app\models\cms\Tag;
use app\models\cms\TagAssign;
use app\models\cms\DiyField;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
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
                'className' => Article::class,
                'kid' => $request->post('kid'),
                'field' => 'orderid',
                'value' => $request->post('value'),
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => Article::class,
                'kid' => $request->get('kid'),
            ],
            'batch' => [
                'class' => BatchAction::class,
                'className' => Article::class,
                'type' => $request->get('type'),
                'stateField' => 'delstate',
                'timeField' => 'deltime',
            ],
            //垃圾管理
            'recycle' => [
                'class' => RecycleAction::class,
                'className' => Article::class,
                'type' => $request->get('type'),
                'field' => 'delstate',
            ],
            //获取标签
            'get-tags' => [
                'class' => Select2TagAction::class,
                'modelClass' => Article::class,
                'tagClass' => Tag::class,
                'tagAssignClass' => TagAssign::class,
                'keyword' => Yii::$app->getRequest()->get('keyword'),//要搜索的内容
                'limit' => 20,//每次请求返回限制数量
                'page' => Yii::$app->getRequest()->get('page'),//默认请求第一页
            ],
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_DEFAULT.'/article',
            ],
            'multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picarr',
                'folder' => AliyunOss::OSS_DEFAULT.'/article',
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/article',
                'config' => [],
            ],
            'diyfield-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/article',
            ],
            'diyfield-multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_MULTI_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/article',
            ],
            'diyfield-ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/article',
                'config' => [],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $model->loadDefaultValues();
        $model->columnid = Yii::$app->getRequest()->get('columnid', null);

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
     * Updates an existing Article model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        $model->touch('deltime');
        $model->updateAttributes(['delstate' => Article::IS_DEL]);//标记为垃圾
        
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
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Article::find()->current()->delstate(Article::IS_NOT_DEL)->andWhere(['id' => $id])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
