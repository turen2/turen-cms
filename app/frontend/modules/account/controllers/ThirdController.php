<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use common\models\user\User;
use Yii;
use yii\helpers\Json;
use yii\web\NotAcceptableHttpException;

/**
 * 第三方登录
 * Class ThirdController
 * @package app\modules\account\controllers
 */
class ThirdController extends \app\components\Controller
{
    /**
     * 第三方登录列表
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 第三方绑定
     * @param $authclientid
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionBind($token)
    {
        $userModel = Yii::$app->getUser()->getIdentity();
        $data = Yii::$app->security->validateData(urldecode($token), Yii::$app->params['config.thirdBindRemark']);
        
        if(Yii::$app->getUser()->isGuest || empty($data) || !Yii::$app->getSession()->get('_oauth_bind', false)) {
            throw new NotAcceptableHttpException('非法操作请求将不会处理！');
        }

        $data = Json::decode($data);
        $id = $data['id'];
        $openid = $data['openid'];
        $attribute = $id.'_id';
        if(isset($userModel->{$attribute})) {
            Yii::$app->getDb()->createCommand()->update(User::tableName(), [
                $attribute => $openid,
            ], [
                'user_id' => $userModel->getId(),
            ])->execute();

            Yii::$app->getSession()->setFlash('success', '第三方登录绑定成功');
        }

        return $this->redirect(['/account/third/list', '#'=>'auth']);
    }

    /**
     * 第三方解绑
     * @param $authclientid
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionUnbind($authclientid)
    {
        $attribute = $authclientid.'_id';
        $userModel = Yii::$app->getUser()->getIdentity();
        if(isset($userModel->{$attribute}) && !empty($userModel->{$attribute})) {
            Yii::$app->getDb()->createCommand()->update(User::tableName(), [
                $attribute => '',
            ], [
                'user_id' => $userModel->getId(),
            ])->execute();

            Yii::$app->getSession()->setFlash('success', '第三方登录解绑定成功');
        }

        return $this->redirect(['/account/third/list', '#'=>'auth']);
    }
}