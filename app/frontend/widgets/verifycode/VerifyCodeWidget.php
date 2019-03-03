<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\verifycode;

use Yii;
use yii\base\InvalidConfigException;

class VerifyCodeWidget extends \yii\base\Widget
{
    public $templateId = '';
    public $verifyUrl = '';

    public function init()
    {
        parent::init();

        //检测参数
        if(empty($this->templateId) || empty($this->verifyUrl)) {
            throw new InvalidConfigException(self::class.'参数配置有误。');
        }
    }

    public function run() {
        return $this->render('verify-code', [
            'templateId' => $this->templateId,
            'url' => $this->verifyUrl,
        ]);
    }
}
