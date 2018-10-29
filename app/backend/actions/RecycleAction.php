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
use app\components\ActiveRecord;
use yii\web\MethodNotAllowedHttpException;
use yii\helpers\Url;
use app\helpers\BackCommonHelper;

/**
 * 垃圾回收机制
 * @author jorry
 *
 */
class RecycleAction extends Action
{
    const RECYCLE_TYPE_LIST = 'list';//'list'垃圾列表
    const RECYCLE_TYPE_RESET = 'reset';//'reset'恢复指定id垃圾
    const RECYCLE_TYPE_RESETALL = 'resetall';//'resetall'恢复批量id垃圾
    const RECYCLE_TYPE_DEL = 'del';//'del'删除指定id垃圾
    const RECYCLE_TYPE_DELALL = 'delall';//'delall'删除批量id垃圾
    const RECYCLE_TYPE_EMPTY = 'empty';//删除所有当前的垃圾
    
    public $className;//要切换的模型
    public $type;//操作类型 'list'垃圾列表、'reset'恢复指定id垃圾、'del'删除指定id垃圾、'resetall'恢复批量id垃圾、'delall'删除批量id垃圾、'empty'删除所有当前的垃圾
    public $fieldName = 'title';
    
    public $field = 'delstate';//垃圾标记字段
    
    public function run()
    {
        //校验参数
        if(is_null($this->className) || is_null($this->type)) {
            throw new InvalidArgumentException('传递的参数有误。');
        }
        
        if(!Yii::$app->getRequest()->isAjax) {
            throw new MethodNotAllowedHttpException('请求类型有误。');
        }
        
        //状态切换
        $className = $this->className;
        $primayKey = $className::primaryKey()[0];
        
        $query = $className::find();
        if(BackCommonHelper::CheckFieldExist($className, 'lang')) {
            $query = $query->current();
        }
        
        $selectQuery = clone $query;
        
        // 选择执行操作
        switch ($this->type) {
            case self::RECYCLE_TYPE_RESET:
                $id = Yii::$app->getRequest()->post('id');
                $model = $query->andWhere([$primayKey => $id])->one();
                if($model) {
                    $model->updateAttributes([$this->field => ActiveRecord::IS_NOT_DEL]);
                }
                break;
            case self::RECYCLE_TYPE_RESETALL:
                $ids = Yii::$app->getRequest()->post('ids');
                foreach ($query->andWhere([$primayKey => explode(',', $ids)])->all() as $model) {
                    $model->updateAttributes([$this->field => ActiveRecord::IS_NOT_DEL]);
                }
                break;
            case self::RECYCLE_TYPE_DEL:
                $id = Yii::$app->getRequest()->post('id');
                $model = $query->andWhere([$primayKey => $id])->one();
                if($model) {
                    $model->delete();
                }
                break;
            case self::RECYCLE_TYPE_DELALL:
                $ids = Yii::$app->getRequest()->post('ids');
                foreach ($query->andWhere([$primayKey => explode(',', $ids)])->all() as $model) {
                    $model->delete();
                }
                break;
            case self::RECYCLE_TYPE_EMPTY:
                $models = $query->andWhere([$this->field => ActiveRecord::IS_DEL])->all();
                foreach ($models as $model) {
                    $model->delete();
                }
                break;
        }
        
        $str = '';
        $models = $selectQuery->andWhere([$this->field => ActiveRecord::IS_DEL])->all();
        if($models) {
            foreach ($models as $model) {
                if(method_exists($model, 'getAllColumn')) {
                    $columns = $model->getAllColumn(true);
                    if(isset($columns[$model->columnid])) {
                        $classname = $columns[$model->columnid].' ['.$model->columnid.']';
                    } else {
                        $classname = '栏目已删除 ['.$model->columnid.']';
                    }
                } else {
                    $classname = '无栏目';
                }
                
                $deltime = Yii::$app->getFormatter()->asDate($model->deltime);
                $reset = Url::to(['recycle', 'type' => self::RECYCLE_TYPE_RESET]);
                $del = Url::to(['recycle', 'type' => self::RECYCLE_TYPE_DEL]);
                
                $title = '删除日期：'.$deltime."\n".'所属栏目：'.$classname;
                
                $str .= <<<EOF
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-table">
    <tr align="left" class="data-tr" onmouseover="this.className='data-tr-on'" onmouseout="this.className='data-tr'">
        <td width="30" height="28" class="first-col"><input type="checkbox" name="checkid[]" id="checkid[]" value="{$model->{$primayKey}}" /></td>
        <td width="30">{$model->{$primayKey}}</td>
        <td><span class="title" title="{$title}">{$model->{$this->fieldName}}</span></td>
        <td width="70" class="action end-col"><span><a href="javascript:;" data-id="{$model->{$primayKey}}" onclick="Recycle('{$reset}', this)">还原</a></span><span class="nb"><a href="javascript:;" data-id="{$model->{$primayKey}}" onclick="Recycle('{$del}', this)">删除</a></span></td>
    </tr>
</table>
EOF;
            }
            exit($str);
        } else {
            exit('暂无内容');
        }
    }
}