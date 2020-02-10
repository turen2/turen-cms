<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\select2;

use Yii;
use yii\base\Action;
use yii\web\HttpException;
use yii\base\InvalidArgumentException;
use backend\helpers\BackCommonHelper;

class Select2TagAction extends Action
{
    public $limit = 10;//每次请求返回限制数量
    
    public $page = 1;//默认请求第一页
    
    public $keyword = '';//要搜索的内容
    
    public $modelClass;//记录在tag中的模型类
    
    public $tagClass;//tag主表
    
    public $tagAssignClass;//tag从表

    public function init()
    {
        parent::init();
        
        //保证以ajax进行访问
        if(!Yii::$app->request->getIsAjax()) {
            //throw new HttpException('Select2Action->Request Type Error,not ajax');
        }
        
        //各种校验参数
        if(empty($this->modelClass) || empty($this->tagClass) || empty($this->tagAssignClass)) {
            throw new InvalidArgumentException('Select2TagAction参数错误。');
        }
    }

    /**
     * 执行并处理action
     */
    public function run()
    {

        $this->page = empty($this->page)?1:$this->page;
        
        $tagClass = $this->tagClass;
        $tagAssignClass = $this->tagAssignClass;
        $modelClass = $this->modelClass;
        
        //联表查询
        $query = $tagClass::find()->alias('t')->select(['t.*'])->leftJoin($tagAssignClass::tableName().' as ta', ' t.tag_id = ta.tag_id');
        
        if(BackCommonHelper::CheckFieldExist($tagClass, 'lang')) {
            $query = $query->current();
        }

        $reflect = new \ReflectionClass(new $modelClass);
        $query->andFilterWhere(['class' => $reflect->getShortName()])->andFilterWhere(['like', 'name', $this->keyword]);
        
        //var_dump($query->createCommand()->getRawSql());exit;
        
        $count = $query->count();//总数
        $models = $query->limit($this->limit)->offset($this->limit*($this->page-1))->all();//分页
        
        $results = [];
        foreach ($models as $model) {
            $results[] = [
                'id' => $model->name, 
                'text' => $model->name,
            ];
        }

        return $this->controller->asJson([
            'status' => true,
            'msg' => $results,
            'total_count' => $count,
            //'incomplete_results' => true,
        ]);
    }
}