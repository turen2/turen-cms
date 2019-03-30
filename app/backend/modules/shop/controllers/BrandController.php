<?php

namespace app\modules\shop\controllers;

use Yii;
use app\models\shop\Brand;
use app\models\shop\BrandSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AliyunOss;
use app\widgets\ueditor\UEditorAction;
use app\widgets\fileupload\FileUploadAction;
use app\actions\CheckAction;
use app\widgets\edititem\EditItemAction;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
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
                'className' => Brand::class,
                'kid' => $request->post('kid'),
                'field' => 'orderid',
                'value' => $request->post('value'),
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => Brand::class,
                'kid' => $request->get('kid'),
            ],
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'picurl',
                'folder' => AliyunOss::OSS_DEFAULT.'/brand',
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/brand',
                'config' => [],
            ],
        ];
    }

    /**
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->bname.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->bname.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing Brand model.
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
                'msg' => $model->bname.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->bname.' 已经成功删除！');
        return $this->redirect($returnUrl);
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
            foreach (Brand::find()->current()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->bname.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
