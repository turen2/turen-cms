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
 
class SimpleMoveAction extends Action
{
    public $className;//要切换的模型
    public $id;//主键id值
    public $type;//up上移 | down下移
    
    public $nameFeild = 'name';
    public $feild = 'orderid';//指定要修改的字段名
    public $orderid;//指定一个值
    
    public $isCurrent = true;
    
    public function run()
    {
        //校验参数
        if(is_null($this->className) || is_null($this->id) || is_null($this->type) || is_null($this->orderid)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        $className = $this->className;
        $primayKey = $className::primaryKey()[0];
        
        $query = $className::find();
        if($this->isCurrent) {
            $query = $query->current();
        }
        
        if($this->type == 'down') {//最外层
            $row = $query->andWhere(['<', 'orderid', $this->orderid])->orderBy(['orderid' => SORT_DESC])->asArray()->one();
        }
        
        if($this->type == 'up') {
            $row = $query->andWhere(['>', 'orderid', $this->orderid])->orderBy(['orderid' => SORT_ASC])->asArray()->one();
        }
        
        if(!empty($row['orderid']) && !empty($row[$primayKey])) {
            $newid = $row[$primayKey];
            $neworderid = $row['orderid'];
            
            $command = Yii::$app->getDb()->createCommand();
            $command->update($className::tableName(), ['orderid' => $neworderid], $primayKey.' = :id', [':id' => $this->id])->execute();
            $command->update($className::tableName(), ['orderid' => $this->orderid], $primayKey.' = :id', [':id' => $newid])->execute();
            
            $row = $className::find()->where([$primayKey => $this->id])->asArray()->one();
            
            Yii::$app->getSession()->setFlash('success', $row[$this->nameFeild].' 移动成功。');
        }
        
        $this->controller->redirect(['index']);
    }
}