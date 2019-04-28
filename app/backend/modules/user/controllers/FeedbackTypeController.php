<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\user\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Controller;
use app\actions\CheckAction;
use app\actions\SimpleMoveAction;
use app\models\user\FeedbackType;
use app\models\user\FeedbackTypeSearch;

/**
 * FeedbackTypeController implements the CRUD actions for FeedbackType model.
 */
class FeedbackTypeController extends Controller
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
            //显示隐藏
            'check' => [
                'class' => CheckAction::class,
                'className' => FeedbackType::class,
                'kid' => $request->get('kid'),
            ],
            //简单排序
            'quick-move' => [
                'class' => SimpleMoveAction::class,
                'className' => FeedbackType::class,
                'kid' => $request->get('kid'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameField' => ['fkt_form_name', 'fkt_list_name'],
            ],
        ];
    }

    /**
     * Lists all FeedbackType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new FeedbackType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FeedbackType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->fkt_form_name.' '.$model->fkt_list_name.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FeedbackType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->fkt_form_name.' '.$model->fkt_list_name.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 设置为默认
     * @param integer $id
     * @param array $returnUrl
     * @return \yii\web\Response
     */
    public function actionSetDefault($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);

        FeedbackType::updateAll(['is_default' => FeedbackType::STATUS_OFF], ['lang' => GLOBAL_LANG]);

        $model->is_default = FeedbackType::STATUS_ON;
        $model->save(false);//只更新一个字段，不需要影响到行为和事件

        Yii::$app->getSession()->setFlash('success', $model->fkt_form_name.'|'.$model->fkt_list_name.' 已经设为默认！');
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
            foreach (FeedbackType::find()->current()->andWhere(['fkt_id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->fkt_form_name.' '.$model->fkt_list_name.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = FeedbackType::find()->current()->andWhere(['fkt_id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing FeedbackType model.
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
                'msg' => $model->fkt_form_name.' '.$model->fkt_list_name.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->fkt_form_name.' '.$model->fkt_list_name.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the FeedbackType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FeedbackType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeedbackType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
