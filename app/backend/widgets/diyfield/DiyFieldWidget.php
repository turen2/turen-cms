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
use app\assets\ValidationAsset;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * @author jorry
 */
class DiyFieldWidget extends \yii\base\Widget
{
    public $model;//关联模型
    
    /**
     * Initializes the widget.
     */
    public function init() {
        
        parent::init();
        
        //初始化
        if(empty($this->model)) {
            throw new InvalidArgumentException('DiyFieldWidget::$model 参数不能为空');
        }
    }
    
    public function beforeRun()
    {
        if (!parent::beforeRun()) {
            return false;
        }
        
        //your custom code here
        $this->registerClientScript($this->model);
        
        return true;
    }

    /**
     * Renders the widget.
     */
    public function run() {
        //组织数据
        $id = Column::ColumnConvert('class2id', get_class($this->model));
        $fieldModels = DiyField::find()->where(['fd_column_type' => $id])->orderBy(['orderid' => SORT_DESC])->all();
        
        //渲染模板
        return $this->render('diyfield', ['fieldModels' => $fieldModels, 'model' => $this->model]);
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
    protected function registerClientScript($model)
    {
        ValidationAsset::register($this->view);
        
        $id = Column::ColumnConvert('class2id', get_class($model));
        $fieldModels = DiyField::find()->where(['fd_column_type' => $id])->orderBy(['orderid' => SORT_DESC])->all();
        
        $rules = [];
        $messages = [];
        foreach ($fieldModels as $fieldModel) {
            if(in_array($model->columnid, explode(',', $fieldModel->columnid_list))) {
                $attribute = DiyField::FIELD_PRE.$fieldModel->fd_name;
                //$check = $fieldModel->fd_check;
                
                $rules[Html::getInputName($model, $attribute)] = ['required' => true];
                $messages[Html::getInputName($model, $attribute)] = $fieldModel->fd_tips;
            }
        }
        
        $rules = Json::encode($rules);
        $messages = Json::encode($messages);
        
        $script = <<<EOF
            //解决虚线问题
            $('.no-prev-line').prev().find('td').css('borderBottom', 'none');

            var validatorDiyField = $("#submitform").validate({
            	rules: {$rules},
                messages: {$messages},
                errorElement: "p",
            	errorPlacement: function(error, element) {
            		error.appendTo(element.parent());
            	}
            });
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}