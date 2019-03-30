<?php

namespace app\modules\cms\controllers;

use Yii;
use app\models\cms\MasterModel;
use app\models\cms\MasterModelSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;
use app\widgets\fileupload\FileUploadAction;
use app\models\cms\DiyField;
use common\components\AliyunOss;
use app\widgets\ueditor\UEditorAction;
use yii\base\InvalidArgumentException;
use app\models\cms\DiyModel;
use app\widgets\edititem\EditItemAction;
use app\models\cms\Column;

/**
 * MasterModelController implements the CRUD actions for MasterModel model.
 */
class MasterModelController extends Controller
{
    public static $DiyModel;
    
    public function init()
    {
        parent::init();
        
        $params = Yii::$app->request->queryParams;
        if(!isset($params['mid'])) {
            throw new InvalidArgumentException('访问MasterModelController必须要mid的get/post参数');
        }
        MasterModel::$DiyModelId = $params['mid'];//切换模型与表的对应关系
        
        if(empty(self::$DiyModel)) {
            self::$DiyModel = DiyModel::find()->active()->andWhere(['dm_id' => MasterModel::$DiyModelId])->one();
        }
        
        if(empty(self::$DiyModel)) {
            throw new InvalidArgumentException('访问MasterModelController使用了非法mid值');
        }
    }
    
    /**
     * @inheritdoc
      * 强制使用post进行删除操作，post受csrf保护
     */
    public function behaviors()
    {
        $request = Yii::$app->getRequest();
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
                'className' => MasterModel::class,
                'kid' => $request->post('kid'),
                'field' => 'orderid',
                'value' => $request->post('value'),
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => MasterModel::class,
                'kid' => $request->get('kid'),
            ],
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_DEFAULT.'/'.self::$DiyModel->dm_name,
            ],
            'diyfield-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/'.self::$DiyModel->dm_name,
            ],
            'diyfield-multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_MULTI_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/'.self::$DiyModel->dm_name,
            ],
            'diyfield-ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/'.self::$DiyModel->dm_name,
                'config' => [],
            ],
        ];
    }

    /**
     * Lists all MasterModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $className = MasterModel::class.'_'.MasterModel::$DiyModelId;
        $modelid = Column::ColumnConvert('class2id', $className);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'diyModel' => self::$DiyModel,
            'modelid' => $modelid,
        ]);
    }

    /**
     * Creates a new MasterModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterModel();
        $model->loadDefaultValues();
        $model->columnid = Yii::$app->getRequest()->get('columnid', null);
        
        $className = MasterModel::class.'_'.MasterModel::$DiyModelId;
        $modelid = Column::ColumnConvert('class2id', $className);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->title.' 添加成功，结果将展示在列表。');
        	return $this->redirect(['index', 'mid' => MasterModel::$DiyModelId]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'diyModel' => self::$DiyModel,
                'modelid' => $modelid,
            ]);
        }
    }

    /**
     * Updates an existing MasterModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $className = MasterModel::class.'_'.MasterModel::$DiyModelId;
        $modelid = Column::ColumnConvert('class2id', $className);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->title.' 已经修改成功！');
        	return $this->redirect(['index', 'mid' => MasterModel::$DiyModelId]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'diyModel' => self::$DiyModel,
                'modelid' => $modelid,
            ]);
        }
    }
    
    /**
     * Deletes an existing MasterModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
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
        return $this->redirect(['index', 'mid' => MasterModel::$DiyModelId]);
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
            foreach (MasterModel::find()->current()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->title.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        }
        
        return $this->redirect(['index', 'mid' => MasterModel::$DiyModelId]);
    }

    /**
     * Finds the MasterModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MasterModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
