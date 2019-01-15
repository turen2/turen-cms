<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\phonecode;

use Yii;
use yii\base\InvalidConfigException;

class PhoneCodePopWidget extends \yii\base\Widget
{
    public $templateId = '';

    public function init()
    {
        parent::init();

        //检测参数
        if(empty($this->templateId)) {
            throw new InvalidConfigException(self::class.'参数配置有误。');
        }
    }

    public function run() {
        return $this->render('phone-code-pop', [
            'templateId' => $this->templateId,
        ]);
    }
}
