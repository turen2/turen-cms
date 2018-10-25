<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
 
class CheckAction extends Action
{
    public $className;//要切换的模型
    public $id;//主键id值
    
    public $openName = '显示';
    public $closeName = '隐藏';
    
    public $isCurrent = false;
    public $feild = 'status';//指定要修改的字段名
    
    public function run()
    {
        //校验参数
        if(is_null($this->className) || is_null($this->id) || is_null($this->feild)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        //状态切换
        $className = $this->className;
        $primayKey = $className::primaryKey()[0];
        
        $query = $className::find();
        if($this->isCurrent) {
            $query = $query->current();
        }
        
        $model = $query->where([$primayKey => $this->id])->one();
        $model->{$this->feild} = !$model->{$this->feild};
        $model->save(false);//效果在界面上有显示
        
        $status = $model->{$this->feild};
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->controller->asJson([
                'state' => true,
                'msg' => $status?$this->openName:$this->closeName,
            ]);
        }
        
        $this->controller->redirect(['index']);
    }
}