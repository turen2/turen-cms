<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\site\controllers;

use Yii;
use app\models\site\Help;
use app\models\site\HelpSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\widgets\select2\Select2Action;
use app\models\cms\Tag;
use common\components\AliyunOss;
use app\widgets\fileupload\FileUploadAction;
use app\actions\CheckAction;
use app\widgets\ueditor\UEditorAction;

/**
 * HelpController implements the CRUD actions for Help model.
 */
class HelpController extends Controller
{
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'check' => [
                'class' => CheckAction::class,
                'className' => Help::class,
                'id' => $request->get('id'),
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
                'folder' => AliyunOss::OSS_DEFAULT.'/help',
            ],
            'multiple-fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picarr',
                'folder' => AliyunOss::OSS_DEFAULT.'/help',
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/help',
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
     * Lists all Help models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HelpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Help model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Help();

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
     * Updates an existing Help model.
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
     * 批量提交并处理
     * @param string $type delete | order
     * @return \yii\web\Response
     */
    public function actionBatch($type)
    {
        if($type == 'delete') {
            $tips = '';
            foreach (Help::find()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->title.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Help model.
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
                'msg' => $model->title.' 已经移到垃圾桶！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->title.' 已经移到垃圾桶！');
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the Help model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Help the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Help::find()->andWhere(['id' => $id])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
