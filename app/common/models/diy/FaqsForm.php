<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\diy;

use Yii;
use yii\base\Model;

class FaqsForm extends Model
{
    public $question;//问题
    public $nickname;//称呼
    public $phone;//手机号
    public $phoneCode;//手机号验证码
    public $verifyCode;//验证码

    public function rules()
    {
        return [
            [['question', 'nickname', 'phone', 'phoneCode', 'verifyCode'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question' => Yii::t('app', '问题'),
            'nickname' => Yii::t('app', '称呼'),
            'phone' => Yii::t('app', '手机号'),
            'phoneCode' => Yii::t('app', '手机验证码'),
            'verifyCode' => Yii::t('app', '验证码'),
        ];
    }
}
