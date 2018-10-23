<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets;

use Yii;

/**
 * @author jorry
 */
class LangSelectorWidget extends \yii\base\Widget
{   
    private $selection = '';
    
    private $items = [];
    
    public function init()
    {
        parent::init();
        
        $this->selection = Yii::$app->session->get('lang');
        $this->items = Yii::$app->params['config.languages'];//此项可以从后台配置
    }
    
    public function run() {
        return $this->render('lang-selector', [
            'selection' => $this->selection,
            'items' => $this->items,
        ]);
    }
}
