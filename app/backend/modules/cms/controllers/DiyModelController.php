<?php

namespace app\modules\cms\controllers;

use Yii;
use app\models\cms\DiyModel;
use app\models\cms\DiyModelSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;
use app\actions\ValidateAction;

/**
 * DiyModelController implements the CRUD actions for DiyModel model.
 */
class DiyModelController extends Controller
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
            'check' => [
                'class' => CheckAction::class,
                'className' => DiyModel::class,
                'openName' => '启用',
                'closeName' => '禁用',
                'kid' => $request->get('kid'),
            ],
            'validate-title' => [
                'class' => ValidateAction::class,
                'className' => DiyModel::class,
                'fieldname' => 'dm_title',
                'fieldvalue' => $request->get('MasterModel'),
                'primaryId' => $request->get('id'),
            ],
            'validate-name' => [
                'class' => ValidateAction::class,
                'className' => DiyModel::class,
                'fieldname' => 'dm_name',
                'fieldvalue' => $request->get('MasterModel'),
                'primaryId' => $request->get('id'),
            ],
            'validate-tbname' => [
                'class' => ValidateAction::class,
                'className' => DiyModel::class,
                'fieldname' => 'dm_tbname',
                'fieldvalue' => $request->get('MasterModel'),
                'primaryId' => $request->get('id'),
            ],
        ];
    }

    /**
     * Lists all DiyModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiyModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new DiyModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DiyModel();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->dm_title.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DiyModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->dm_title.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing DiyModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        $model->delete();
        //清空输出
        ob_clean();
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => true,
                'msg' => $model->dm_title.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->dm_title.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the DiyModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DiyModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DiyModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
