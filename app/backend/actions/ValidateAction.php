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
use app\helpers\BackCommonHelper;
 
class ValidateAction extends Action
{
    public $className;//要切换的模型
    public $fieldname;//指定要修改的字段名
    public $fieldvalue = '';
    public $primaryId;
    
    public function run()
    {
        //校验参数
        if(is_null($this->className) || is_null($this->fieldname)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        //状态切换
        $className = $this->className;
        $primayKey = $className::primaryKey()[0];
        $query = $className::find();
        if(BackCommonHelper::CheckFieldExist($className, 'lang')) {
            $query = $query->current();
        }
        
        if(!is_null($this->primaryId) && $this->primaryId != 'undefined') {
            $query->andWhere(['not', [$primayKey => $this->primaryId]]);
        }
        
        //var_dump($query->andWhere([$this->fieldname => $this->fieldvalue[$this->fieldname]])->createCommand()->getRawSql());exit;
        if($query->andWhere([$this->fieldname => $this->fieldvalue[$this->fieldname]])->exists()) {
            return 'false';
        } else {
            return 'true';
        }
    }
}