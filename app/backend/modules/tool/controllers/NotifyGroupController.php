<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\tool\controllers;

use Yii;
use app\models\tool\NotifyGroup;
use app\models\tool\NotifyGroupSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;
use app\models\tool\NotifySmsQueue;
use app\models\tool\NotifyContent;

/**
 * NotifyGroupController implements the CRUD actions for NotifyGroup model.
 */
class NotifyGroupController extends Controller
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
                'field' => 'ng_status',
                'className' => NotifyGroup::class,
                'id' => $request->get('id'),
            ],
        ];
    }

    /**
     * Lists all NotifyGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotifyGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new NotifyGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NotifyGroup();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->ng_title.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NotifyGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->ng_title.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing NotifyGroup model.
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
     * Deletes an existing NotifyGroup model.
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
                'msg' => $model->ng_title.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->ng_title.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }
    
    /**
     * 定时任务（稳定后移到console控制台）
     */
    public function actionSendSms()
    {
        //每次最多取20条队列
        $total = 0;
        foreach (NotifyGroup::find()->where(['ng_status' => 1])->andWhere(['or', ['ng_clock_time' => 0], ['and', ['>', 'ng_clock_time', 0], ['<', 'ng_clock_time', time()]]])->batch(20) as $notifyGroupModels) {
            foreach ($notifyGroupModels as $notifyGroupModel) {
                //短信内容组装
                $contentModel = NotifyContent::findOne(['nc_id' => $notifyGroupModel->ng_nc_id]);
                if($contentModel) {
                    //每次发送20条短信
                    foreach (NotifySmsQueue::find()->where(['nq_ng_id' => $notifyGroupModel->ng_id])->batch(20) as $notifySmsQueueModels) {
                        foreach ($notifySmsQueueModels as $notifySmsQueueModel) {
                            if(empty($notifySmsQueueModel->nq_sms_send_time)) {
                                //发送
                                Yii::$app->sms->sendSms($notifySmsQueueModel->nq_phone, $contentModel->nc_sms_sign, $contentModel->nc_sms_tcode, []);
                                $total++;
                                //更新相关内容
                                NotifySmsQueue::updateAll(['nq_sms_send_time' => time()], ['nq_sms_id' => $notifySmsQueueModel->nq_sms_id]);
                                NotifyGroup::updateAllCounters(['ng_send_count' => 1], ['ng_id' => $notifyGroupModel->ng_id]);
                            }
                        }
                    }
                }
            }
        }
        
        echo '本次发送总量为：'.$total;
        exit;
    }

    /**
     * Finds the NotifyGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return NotifyGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NotifyGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
