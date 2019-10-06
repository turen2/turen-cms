<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\sys\Multilang;

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
        $this->items = ArrayHelper::map(Multilang::find()->active()->all(), 'lang_sign', 'lang_name');
    }
    
    public function run() {
        return $this->render('lang-selector', [
            'selection' => $this->selection,
            'items' => $this->items,
        ]);
    }
}
