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
 
class SimpleMoveAction extends Action
{
    public $className;//要切换的模型
    public $kid;//主键id值
    public $type;//up上移 | down下移
    public $orderid;//指定一个值
    
    public $nameField = 'name';
    public $orderidField = 'orderid';//指定要修改的字段名
    
    public function run()
    {
        //校验参数
        if(is_null($this->className)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        $className = $this->className;
        $primayKey = $className::primaryKey()[0];
        
        //校验参数
        if(is_null($this->kid) || is_null($this->orderid) || is_null($this->type)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        $query = $className::find();
        if(BackCommonHelper::CheckFieldExist($className, 'lang')) {
            $query = $query->current();
        }
        
        if($this->type == 'down') {//最外层
            $query->andWhere(['<', $this->orderidField, $this->{$this->orderidField}])->orderBy([$this->orderidField => SORT_DESC]);
        } else if($this->type == 'up') {
            $query->andWhere(['>', $this->orderidField, $this->{$this->orderidField}])->orderBy([$this->orderidField => SORT_ASC]);
        } else {
            $query->andWhere('1!=1');//不存在的类型
        }
        
        $row = $query->asArray()->one();
        $currentModel = $className::findOne([$primayKey => $this->kid]);
        
        if($row) {
            $newid = $row[$primayKey];
            $neworderid = $row[$this->orderidField];
            
            $command = Yii::$app->getDb()->createCommand();
            $command->update($className::tableName(), [$this->orderidField => $neworderid], $primayKey.' = :id', [':id' => $this->kid])->execute();
            $command->update($className::tableName(), [$this->orderidField => $this->{$this->orderidField}], $primayKey.' = :id', [':id' => $newid])->execute();
            
            Yii::$app->getSession()->setFlash('success', $currentModel->{$this->nameField}.' 移动成功。');
        } else {
            Yii::$app->getSession()->setFlash('error', $currentModel->{$this->nameField}.' 移动失败。');
        }
        
        $this->controller->redirect(['index']);
    }
}