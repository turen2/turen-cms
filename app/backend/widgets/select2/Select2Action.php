<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\select2;

use Yii;
use yii\base\Action;
use yii\web\HttpException;
use yii\base\InvalidArgumentException;
use app\helpers\BackCommonHelper;

class Select2Action extends Action
{
    public $className;//要切换的模型【目前只支持单模型】
    
    public $limit = 10;//每次请求返回限制数量
    
    public $page = 1;//默认请求第一页
    
    public $searchFields = ['name'];//搜索的字段
    
    public $valField = 'id';//返回作为值的字段
    
    public $showField = 'name';//返回显示的字段
    
    public $keyword = '';//要搜索的内容

    public $where = []; //要查询限制的内容，默认没有限制
    
    public function init()
    {
        parent::init();
        
        //保证以ajax进行访问
        if(!Yii::$app->request->getIsAjax()) {
            //throw new HttpException('Select2Action->Request Type Error,not ajax');
        }
        
        //各种校验参数
        if(empty($this->className)) {
            throw new InvalidArgumentException('Select2Action Parameter Error.');
        }
    }

    /**
     * 执行并处理action
     */
    public function run()
    {

        $className = $this->className;
        
        $this->page = empty($this->page)?1:$this->page;
        
        $query = $className::find();
        
        if(BackCommonHelper::CheckFieldExist($className, 'lang')) {
            $query = $query->current();
        }

        if (count($this->where) > 0) {
            $query = $query->andFilterWhere($this->where);
        }

        foreach ($this->searchFields as $field) {
            $query = $query->andFilterWhere(['like', $field, $this->keyword]);
        }
        $count = $query->count();//总数
        $models = $query->limit($this->limit)->offset($this->limit*($this->page-1))->all();//分页
        
        $results = [];
        foreach ($models as $model) {
            $results[] = [
                'id' => $model->{$this->valField}, 
                'text' => $model->{$this->showField},
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