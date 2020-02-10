<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\modules\account\controllers;

use common\models\account\InfoForm;
use common\models\user\User;
use Yii;

/**
 * Center controller
 */
class CenterController extends \frontend\components\Controller
{
    /**
     * 用户中心首页
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionInfo()
    {
        $userMmodel = Yii::$app->getUser()->getIdentity();
        $model = new InfoForm();

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                //上传图像，整理avatar数据

                //写入数据库
                Yii::$app->getDb()->createCommand()->update(User::tableName(), [
                    'username' => $model->username,
                    'sex' => (int)$model->sex,
                    'avatar' => $model->avatar,
                    'intro' => $model->intro,
                ], ['user_id' => $userMmodel->getId()])->execute();

                Yii::$app->session->setFlash('success', '基本资料提交成功');
                return $this->redirect(['info']);
            }

            $errors = $model->getFirstErrors();
            $error = current($errors);//只取第一个值
            $error && Yii::$app->session->setFlash('danger', $error);
        } else {
            //初始化给定默认值
            $model = new InfoForm([
                'username' => $userMmodel->username,
                'sex' => (int)$userMmodel->sex,
                'avatar' => $userMmodel->avatar,
                'intro' => $userMmodel->intro,
            ]);
        }

        //组，等级
        $groupModel = $userMmodel->group;
        $levelModel = $userMmodel->level;
        return $this->render('info', [
            'model' => $model,
            'groupModel' => $groupModel,
            'levelModel' => $levelModel,
        ]);
    }
}