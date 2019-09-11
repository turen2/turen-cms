<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\cascade;

use Yii;
use yii\base\InvalidConfigException;
use common\helpers\Util;

class CascadeWidget extends \yii\base\Widget
{
    public $province = '';
    public $cities = [];
    public $formId = '';

    public function init()
    {
        parent::init();

        //检测参数
        if(empty($this->province) || empty($this->formId)) {
            throw new InvalidConfigException(self::class.'参数配置有误。');
        }
    }

    public function run() {
        $province = Util::CreateProvinceSelector($this->province);
        return $this->render('cascade', [
            'province' => $province,
            'cities' => $this->cities,
            'formId' => $this->formId,
        ]);
    }
}
