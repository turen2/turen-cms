<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

use app\widgets\phonecode\PhoneCodePopAction;
use common\models\diy\FaqsForm;
use Yii;
use common\models\diy\Faqs;
use common\models\diy\FaqsSearch;
use app\components\Controller;
use yii\filters\VerbFilter;

/**
 * FaqsController implements the CRUD actions for Faqs model.
 */
class FaqsController extends Controller
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
     * Lists all Faqs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FaqsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->getRequest()->isAjax) {
            $pageSize = $dataProvider->pagination->pageSize;
            if($dataProvider->count < $pageSize) {
                $complete = true;
            } else {
                $complete = false;
            }

            return $this->asJson([
                'state' => true,
                'code' => 200,
                'complete' => $complete,//是否已经加载完了
                'msg' => $this->renderAjax('ajax-index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]),
            ]);
        } else {
            return $this->render('index', [
                'model' => new FaqsForm(),
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Creates a new Faqs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if($post = Yii::$app->getRequest()->post()) {
            $session = Yii::$app->getSession();
            //验证码
            $sessionCode = $session->get(PhoneCodePopAction::PHONE_CODE_PARAM);
            if($post['phone'] != $sessionCode['phone']) {
                return $this->asJson([
                    'state' => false,
                    'code' => 200,
                    'msg' => '手机号码不匹配',
                ]);
            }
            if((time() - $sessionCode['t']) > PhoneCodePopAction::PHONE_CODE_VALID_TIME) {
                return $this->asJson([
                    'state' => false,
                    'code' => 200,
                    'msg' => '验证码已过期',
                ]);
            }
            if($post['code'] != $sessionCode['code']) {
                return $this->asJson([
                    'state' => false,
                    'code' => 200,
                    'msg' => '验证码错误',
                ]);
            }

            //清理老验证码
            $session->remove(PhoneCodePopAction::PHONE_CODE_PARAM);

            //入库
            $model = new Faqs();
            $model->title = $post['content'];//提问标题
            $model->status = Faqs::IS_OFF;//不显示，等待后台回复
            $model->diyfield_ask_content = '提问用户：'.$post['name'].' <br />用户电话：'.$post['phone'].' <br />提问内容：'.$post['content'];
            $time = time();
            $model->posttime = $time;
            $model->updated_at = $time;
            $model->created_at = $time;
            $model->lang = GLOBAL_LANG;
            $model->orderid = 10;
            $model->save(false);

            return $this->asJson([
                'state' => true,
                'code' => 200,
                'msg' => '提交问题成功',
            ]);
        }
    }
}
