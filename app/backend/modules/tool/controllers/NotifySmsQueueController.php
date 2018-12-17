<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\tool\controllers;

use Yii;
use app\models\tool\NotifySmsQueue;
use app\models\tool\NotifySmsQueueSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\tool\NotifyGroup;

/**
 * NotifySmsQueueController implements the CRUD actions for NotifySmsQueue model.
 */
class NotifySmsQueueController extends Controller
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
            //
        ];
    }

    /**
     * Lists all NotifySmsQueue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotifySmsQueueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing NotifySmsQueue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        //更新列队总量
        NotifyGroup::updateAllCounters(['ng_count' => '-1'], ['ng_id' => $model->nq_ng_id]);
        //删除
        $model->delete();
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => true,
                'msg' => $model->nq_sms_id.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->nq_sms_id.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the NotifySmsQueue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return NotifySmsQueue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NotifySmsQueue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
