<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\diyfield;

use Yii;
use yii\base\InvalidArgumentException;
use app\models\cms\DiyField;
use app\models\cms\Column;
use yii\helpers\ArrayHelper;

/**
 * @author jorry
 */
class DiyFieldWidget extends \yii\base\Widget
{
    public $columnClass;//关联模型类
    
    /**
     * Initializes the widget.
     */
    public function init() {
        
        parent::init();
        
        //初始化
        if(empty($this->columnClass)) {
            throw new InvalidArgumentException('DiyFieldWidget::$columnClass 参数不能为空');
        }
    }
    
    public function beforeRun()
    {
        if (!parent::beforeRun()) {
            return false;
        }
        
        //your custom code here
        $this->registerClientScript();
        
        return true;
    }

    /**
     * Renders the widget.
     */
    public function run() {
        //组织数据
        $id = Column::ColumnConvert('class2id', $this->columnClass);
        $models = DiyField::find()->where(['fd_column_type' => $id])->orderBy(['orderid' => SORT_DESC])->all();
        
        //渲染模板
        return $this->render('diyfield', ['models' => $models]);
    }
    
    public function afterRun($result)
    {
        $result = parent::afterRun($result);
        // your custom code here
        
        
        return $result;
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        $script = <<<EOF
            //
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}