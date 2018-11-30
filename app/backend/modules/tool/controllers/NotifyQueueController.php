<?php

namespace app\modules\tool\controllers;

use Yii;
use app\models\tool\NotifyQueue;
use app\models\tool\NotifyQueueSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;

/**
 * NotifyQueueController implements the CRUD actions for NotifyQueue model.
 */
class NotifyQueueController extends Controller
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
                'openName' => '启用',
                'closeName' => '禁用',
                'field' => 'nq_status',
                'className' => NotifyQueue::class,
                'id' => $request->get('id'),
            ],
        ];
    }

    /**
     * Lists all NotifyQueue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotifyQueueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new NotifyQueue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NotifyQueue();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->nq_id.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NotifyQueue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->nq_id.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing NotifyQueue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionCheck($id)
    {
        $model = $this->findModel($id);
        $model->status = !$model->status;
        $model->save(false);//效果在界面上有显示

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing NotifyQueue model.
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
                'msg' => $model->nq_id.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->nq_id.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the NotifyQueue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return NotifyQueue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NotifyQueue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
