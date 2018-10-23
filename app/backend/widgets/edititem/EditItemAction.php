<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\edititem;

use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\helpers\Json;

/**
 * 批量操作
 * @author jorry
 *
 */
class EditItemAction extends Action
{
    public $className;//要切换的模型
    public $id;//对象id值
    public $field;//修改的字段
    public $value;//修改的结果
    
    public function run()
    {
        //校验参数
        if(is_null($this->className) || is_null($this->id) || is_null($this->field) || is_null($this->value)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        //状态切换
        $className = $this->className;
        $primayKey = $className::primaryKey()[0];
        
        $model = $className::find()->current()->andWhere([$primayKey => $this->id])->one();
        if($model) {
            $model->{$this->field} = $this->value;
            $model->save(false);
            
            return Json::encode([
                'state' => true,
                'msg' => '修改成功',
            ]);
        } else {
            return Json::encode([
                'state' => false,
                'msg' => '修改失败',
            ]);
        }
    }
}