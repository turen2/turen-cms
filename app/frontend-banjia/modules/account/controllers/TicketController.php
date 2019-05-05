<?php

namespace app\modules\account\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Controller;
use common\models\account\Ticket;
use common\models\account\TicketSearch;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 创建新工单
     * @return string
     */
    public function actionCreate()
    {
        $model = new Ticket();
        $model->loadDefaultValues();

        if($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            $this->redirect(['ticket/detail', 'id' => $model->t_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDetail($id)
    {
        $model = $this->findModel($id);

        return $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 工单回复
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionReview($id)
    {
        //接受的数据
        $post = Yii::$app->getRequest()->post();
        $data = [
            'name' => '提交者名称2',
            'content' => 'xxxxxxxx交互内容',
            'files' => '上传的文件路径，以逗号分隔',
            'time' => time(),
            'type' => Ticket::TICKET_TYPE_USER,
        ];

        $model = $this->findModel($id);

        $content = [];
        if(empty($model->t_content)) {
            $content[] = $data;
        } else {
            $content = unserialize($model->t_content);
            $content[] = $data;
        }

        Yii::$app->getDb()->createCommand()->update(Ticket::tableName(), [
            't_content' => serialize($content),
            't_status' => Ticket::TICKET_STATUS_NEWREVIEW,
        ], [
            't_user_id' => Yii::$app->getUser()->getId(),
            't_id' => $id,
        ])->execute();

        return $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 工单评价
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionComment($id)
    {
        //接受的数据
        $post = Yii::$app->getRequest()->post();

        $model = $this->findModel($id);

        Yii::$app->getDb()->createCommand()->update(Ticket::tableName(), [
            't_star' => 5,
            't_is_finish' => Ticket::TICKET_YES,
            't_finish_comment' => '评论内容测试',
            'finished_at' => time(),
            't_status' => Ticket::TICKET_STATUS_CLOSE,
        ], [
            't_user_id' => Yii::$app->getUser()->getId(),
            't_id' => $id,
        ])->execute();

        return $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
