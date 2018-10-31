<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

namespace app\widgets;

use Yii;

/**
 * @author jorry
 */
class LangSelector extends \yii\base\Widget
{   
    private $selection = '';
    
    private $items = [];
    
    public function init()
    {
        parent::init();
        
        $this->selection = Yii::$app->params['config_init_default_lang_key'];
        $this->items = Yii::$app->params['config_init_langs'];//此项可以从后台配置
    }
    
    public function run() {
        return $this->render('lang-selector', [
            'selection' => $this->selection,
            'items' => $this->items,
            'baseUrl' => Yii::$app->request->hostInfo.Yii::$app->request->baseUrl,
        ]);
    }
}
