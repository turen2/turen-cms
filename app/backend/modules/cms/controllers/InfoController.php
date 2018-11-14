<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\cms\controllers;

use Yii;
use app\models\cms\Info;
use app\models\cms\InfoSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\cms\Column;
use common\components\AliyunOss;
use app\widgets\fileupload\FileUploadAction;
use app\widgets\ueditor\UEditorAction;
use app\models\cms\DiyField;

/**
 * InfoController implements the CRUD actions for Info model.
 */
class InfoController extends Controller
{
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_DEFAULT.'/info',
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/info',
                'config' => [],
            ],
            'diyfield-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/info',
            ],
            'diyfield-multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => DiyField::FIELD_MULTI_UPLOAD_NAME,
                'folder' => AliyunOss::OSS_DEFAULT.'/info',
            ],
            'diyfield-ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/info',
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
     * Lists all Info models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Info model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Finds the Info model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Info the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Info::find()->alias('i')->select(['i.*', 'c.cname as cname', 'c.id as cid', 'c.lang as lang'])->leftJoin(Column::tableName().' as c', ' i.columnid = c.id')->current()->andWhere(['c.id' => $id])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在。');
        }
    }
}
