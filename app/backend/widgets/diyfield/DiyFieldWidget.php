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
        //考虑到有自定义模型的情况
        $className = str_replace('MasterModel_'.$this->model->fd_column_type, 'MasterModel', get_class($this->model));
        //组织数据
        $id = Column::ColumnConvert('class2id', $className);//所属模型
        $fieldModels = DiyField::find()->active()->andWhere(['fd_column_type' => $id])->orderBy(['orderid' => SORT_DESC])->all();
        
        //所属栏目
        foreach ($fieldModels as $fileKey => $fieldModel) {
            if(!in_array($this->model->columnid, explode(',', $fieldModel->columnid_list))) {
                unset($fieldModels[$fileKey]);
            }
        }
        
        //渲染模板
        return $this->render('diyfield', ['fieldModels' => $fieldModels, 'model' => $this->model]);
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript($model)
    {
        $script = <<<EOF
            //解决虚线问题
            $('.no-prev-line').prev().find('td').css('borderBottom', 'none');
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}