<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\modules\sys\controllers;

use Yii;
use app\models\sys\Template;
use app\models\sys\TemplateSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\widgets\fileupload\FileUploadAction;
use common\components\aliyunoss\AliyunOss;
use app\widgets\ueditor\UEditorAction;
use app\models\sys\Admin;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Controller
{
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_CMS,
            ],
            'multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picarr',
                'folder' => AliyunOss::OSS_CMS,
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_CMS,
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
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Template();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->temp_name.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->temp_name.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Template model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        
        $state = true;
        $msg = $model->temp_name.' 已经成功删除！';
        
        if($state && ($id == Yii::$app->params['template_id'])) {
            $state = false;
            $msg = $model->temp_name.' 已经被系统占用。';
        }
        
        if($state) {
            $model->delete();
        }
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => $state,
                'msg' => $msg,
            ]);
        }
        
        Yii::$app->getSession()->setFlash(($state?'success':'warning'), $msg);
        return $this->redirect($returnUrl);
    }
    
    /**
     * Select2Widget的数组源
     * @param integer $type 1表示获取创始人，2表示获取管理者
     * @param number $page
     * @param string $keyword
     * @return Json String
     */
    public function actionSelect2Admins($type = 1, $page = 1, $keyword = '')
    {
        $limit = 10;
        $query = Admin::find();
        if($type == 1) {
            $query = $query->where(['id' => Yii::$app->params['config.founderList']]);
        } elseif($type == 2) {
            $query = $query->where(['not', ['id' => Yii::$app->params['config.founderList']]]);
        } else {
            // $query = $query; //nothing
        }
        
        if(!empty($keyword)) {
            $query = $query->andFilterWhere(['like', 'username', $keyword]);
        }
        
        //echo $query->limit($limit)->offset($limit*($page-1))->createCommand()->getRawSql();exit;
        
        $count = $query->count();//总数
        $models = $query->limit($limit)->offset($limit*($page-1))->all();//分页
        
        $results = [];
        foreach ($models as $model) {
            $results[] = [
                'id' => $model->id,
                'text' => $model->username,
            ];
        }
        
        return $this->asJson([
            'status' => true,
            'msg' => $results,
            'total_count' => $count,
            //'incomplete_results' => true,
        ]);
    }

    /**
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
