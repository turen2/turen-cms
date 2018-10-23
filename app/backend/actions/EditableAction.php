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
use yii\web\Response;
use yii\web\HttpException;

/**
 * 将指定字段修改为指定内容，并跳转到指定路由
*/
 
/*
 * 使用方法：
 * public function actions()
 {
     return [
         'order' => [
             'class' => 'app\actions\EditableAction',
             'className' => Test::class,
             'id' => Yii::$app->getRequest()->get('id'),
             'feild' => 'order',
             'value' => Yii::$app->getRequest()->post('value'),
         ],
     ];
 } */
 
class EditableAction extends Action
{
    public $className;//要切换的模型
    public $keyFeild = '';
    public $id;//主键id值
    
    public $feild;//指定要修改的字段名
    public $value;//指定一个值
    
    public function init()
    {
        parent::init();
        
        //保证以ajax进行访问
        if(!Yii::$app->request->getIsAjax()) {
            throw new HttpException(Yii::t('common', 'DynamicInputAction->Request Type Error,not ajax'));
        }
        
        //目前只做ajax
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
    
    public function run()
    {
        //校验参数
        if(is_null($this->className) || is_null($this->id) || is_null($this->feild) || is_null($this->value)) {
            throw new InvalidArgumentException(Yii::t('common', 'Parameter Error.'));
        }
        
        //状态切换
        //跳过模型，比如跳过beforeSave()相关的操作
        //$model = $this->findModel($this->id);
        //$model->{$this->feild} = $this->value;
        
        $className = $this->className;
        $command = Yii::$app->getDb()->createCommand();
        $params = [];
        $command->update($className::tableName(), [$this->feild => $this->value], [$this->keyFeild => $this->id], $params);

        //$model->update(false, [$this->feild])
        if($command->execute()) {//更新不验证，且只更新一个字段
        	return ['output' => $this->findModel($this->id)->{$this->feild}, 'message' => ''];
        } else {
            return ['output' => '', 'message' => '修改失败'];
        }
    }
    // Else return to rendering a normal view
   	//return $this->render('view', ['model'=>$model]);
   	
    protected function findModel($id)
    {
    	$className = $this->className;
    	
    	if (($model = $className::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('此请求页面不存在。');
    	}
    }
}