<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use backend\components\ActiveRecord;
use backend\helpers\BackCommonHelper;

/**
 * 批量操作
 * @author jorry
 *
 */
class BatchAction extends Action
{
    public $className;//要切换的模型
    public $type;//操作类型
    public $stateField = 'delstate';//指定标记字段名
    public $timeField = 'deltime';//指定时间字段名
    
    public function run()
    {
        //校验参数
        if(is_null($this->className) || is_null($this->type)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        //状态切换
        $className = $this->className;
        $primayKey = $className::primaryKey()[0];
        
        $query = $className::find();
        if(BackCommonHelper::CheckFieldExist($className, 'lang')) {
            $query = $query->current();
        }
        
        if($this->type == 'delete') {
            foreach ($query->andWhere([$primayKey => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->touch($this->timeField);
                $model->updateAttributes([$this->stateField => ActiveRecord::IS_DEL]);//标记为垃圾
            }
            Yii::$app->getSession()->setFlash('success', '已批量移到垃圾桶！');
        }
        
        $this->controller->redirect(['index']);
    }
}