<?php

namespace app\modules\account\controllers;

use Yii;
use yii\helpers\ArrayHelper;
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
     * Displays a single Ticket model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 创建工单测试
     */
    public function actionCreate()
    {
        $model = new Ticket();
        $model->t_ticket_num = '19082548457';
        $model->t_title = '测试工单';
        $model->t_relate_id = '25';
        $model->t_phone = '13725514524';
        $model->t_email = '980522557@qq.com';
        $model->t_user_id = '5';
        $model->t_status = '1';
        $model->created_at = time();
        $model->udpated_at = time();

        if(empty($model->save(true))) {
            var_dump($model->getErrors());
        }
        exit('创建工单完成');
    }

    /**
     * 首次交互测试
     */
    public function actionCreate1($id)
    {
        $model = $this->findModel($id);

        $arr = [
            'name' => '提交者名称2',
            'content' => 'xxxxxxxx交互内容',
            'files' => '上传的文件路径，以逗号分隔',
            'time' => time(),
            'type' => 'user',
        ];

        $content = [];
        if(empty($model->t_content)) {
            $content[] = $arr;
        } else {
            $content = unserialize($model->t_content);
            $content[] = $arr;
        }

        $model->t_content = serialize($content);
        $model->t_status = '2';

        if(empty($model->save(true))) {
            var_dump($model->getErrors());
        }
        exit('首次交互完成');
    }

    /**
     * 首次回复测试
     */
    public function actionCreate2($id)
    {
        $model = $this->findModel($id);

        $arr = [
            'name' => '回复者名称2',
            'content' => 'xxxxxxxx交互内容',
            'files' => '上传的文件路径，以逗号分隔',
            'time' => time(),
            'admin_id' => 5,
            'type' => 'admin',
        ];

        $content = [];
        if(empty($model->t_content)) {
            $content[] = $arr;
        } else {
            $content = unserialize($model->t_content);
            $content[] = $arr;
        }

        $model->t_content = serialize($content);
        $model->t_status = '3';

        if(empty($model->save(true))) {
            var_dump($model->getErrors());
        }
        exit('首次回复完成');
    }

    /**
     * 结单测试
     */
    public function actionCreate3($id)
    {
        $model = $this->findModel($id);
        $model->t_status = '4';

        if(empty($model->save(true))) {
            var_dump($model->getErrors());
        }
        exit('结单完成');
    }

    /**
     * 评论测试
     */
    public function actionCreate4($id)
    {
        $model = $this->findModel($id);
        $model->t_status = '5';
        //评论
        $model->t_star = '5';
        $model->t_is_finish = '1';
        $model->t_finish_comment = '非常好啊';
        $model->finished_at = time();

        if(empty($model->save(true))) {
            var_dump($model->getErrors());
        }
        exit('评论完成');
    }

    /**
     * 查看
     */
    public function actionDetail($id)
    {
        $model = $this->findModel($id);

        echo '<pre>';
        var_dump($model->attributes);

        var_dump(unserialize($model->t_content));

        exit('查看完成');
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
