<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\behaviors;

use Yii;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

/**
 * ```php
 * use yii\behaviors\DefaultBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         DefaultBehavior::class,
 *     ];
 * }
 * ```
 * ```php
 * use yii\db\Expression;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
'class' => DefaultBehavior::class,
'defaultAttribute' => 'default',
 *         ],
 *     ];
 * }
 * ```
 */
class DefaultBehavior extends AttributeBehavior
{
    const DEFAULT_YES = 1;
    const DEFAULT_NO = 0;
    
    public $defaultAttribute = 'default';
    
    public function init()
    {
        parent::init();
        
        if (empty($this->attributes)) {
            //更新和插入都触发
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->defaultAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->defaultAttribute,
            ];
        }
    }
    
    /*
     *  取值要解决两个问题：
     *  1.当把当前唯一的那个默认值取消时，不允许操作，且恢复原有值
     *  2.只要新值被设置为yes时，那么就清理一次默认值，虽然有可能未命中，但策略比较稳妥
     */
    public function getValue($event)
    {
        $owner = $this->owner;
        //检测属性是否设置正确
        if(!in_array($this->defaultAttribute, array_keys($owner->getAttributes()))) {
            throw new UnknownPropertyException('没有这个属性，defaultAttribute：'.$this->defaultAttribute);
        }
        
        //如果值发生了变化【这返回值，无敌了】
        $newValue = ArrayHelper::getValue($owner->getAttributes(), $this->defaultAttribute);//未选择，新值为"0",选中为"1"
        $oldValue = ArrayHelper::getValue($owner->getOldAttributes(), $this->defaultAttribute);//新建，旧值为null,旧值选中为1，未选中为0

        if(!$owner->getIsNewRecord()) {//更新操作
            if($oldValue === static::DEFAULT_YES && $newValue === (string)static::DEFAULT_NO) {//不允许取消了唯一的默认值
                Yii::$app->getSession()->setFlash('warning', '至少保留一个记录为默认值！');
                return static::DEFAULT_YES;//恢复旧值
            }
        }
        
        if($newValue === (string)static::DEFAULT_YES && $oldValue === static::DEFAULT_NO) {
            //开始处理其它默认为0，避免使用AR
            $className = get_class($owner);
            $command = Yii::$app->getDb()->createCommand();
            $command->update($className::tableName(), [$this->defaultAttribute => static::DEFAULT_NO]);
            $command->execute();
            return static::DEFAULT_YES;//取消时不让取消并且警告。设置成功时，选择清空其它值为no
        }
        
        //不发生变化
        return $newValue;//直接返回这个值
    }
}
