<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\com;

use common\models\user\User;
use Yii;
use yii\base\Model;
use common\models\account\Feedback as FeedbackModel;

/**
 * Feedback form
 */
class FeedbackForm extends Model
{
    //修改密码
    public $type;
    public $content;//内容
    public $nickname;//称呼
    public $contact;//联系方式
    public $verifyCode;//验证码

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //顺序，决定提交响应的错误顺序
        $rules = [
            [['verifyCode'], 'required'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'home/captcha',
            ],
            [['type', 'content', 'nickname', 'contact'], 'required'],
            [['content'], 'string', 'min' => 10],
            ['type', 'default', 'value' => 1],//此默认值，只是在提交为null时候，才自动填充
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'type' => '问题类型',
            'content' => '内容',
            'nickname' => '昵称',
            'contact' => '联系方式',
            'verifyCode' => '验证码',
        ];

        return $labels;
    }

    /**
     * 问题反馈数据收集表单模型
     * @param FeedbackForm $model
     * @return bool
     */
    public static function SubmitFeedback(FeedbackForm $model)
    {
        //判断是否内容重复，如果重复就提交已经提交过了。
        //$md5 = md5($model->attributes);
        //@TODO

        //尝试关联用户账户
        $userId = null;
        if(Yii::$app->getUser()->isGuest) {
            $userModel = User::find()->where(['or', 'phone='.$model->contact, 'email='.$model->contact])->one();
            if($userModel) {
                $userId = $userModel->user_id;
            }
        } else {
            $userId = Yii::$app->getUser()->getId();
        }

        Yii::$app->getDb()->createCommand()->insert(FeedbackModel::tableName(), [
            'fk_user_id' => $userId,
            'fk_nickname' => $model->nickname,
            'fk_contact' => $model->contact,
            'fk_content' => $model->content,
            'fk_type_id' => $model->type,
            'fk_ip' => Yii::$app->getRequest()->getUserIP(),
            'lang' => GLOBAL_LANG,
            'created_at' => time(),
        ])->execute();

        return true;
    }
}