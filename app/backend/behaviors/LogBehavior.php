<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\behaviors;

use app\models\cms\DiyModel;
use app\models\cms\MasterModel;
use Yii;
use yii\base\Behavior;
use yii\base\Application;
use yii\db\Query;
use yii\helpers\Json;
use app\models\sys\Log;

class LogBehavior extends Behavior
{
    public $refreshTime = 2000;//多少ms算重复请求不计入日志
    
    public $isGetData = true;//是否要插入get请求数据到日志
    
    public $isPostData = true;//是否要插入post请求数据到日志
    
    public $exceptModule = ['debug', 'gii', 'queue'];//忽略模块
    
    public $exceptController = ['log'];//忽略控制器
    
    public $exceptAction = ['menu'];//忽略动作
    
    public $exceptRoute = [];//忽略路由
    
    public function init()
    {
        parent::init();
        
        //print_r('test');
        
    }
    
    public function events()
    {
        return [
            Application::EVENT_BEFORE_ACTION => 'beforeAction',//view yii\base\ActionEvent
            //Application::EVENT_AFTER_ACTION => 'afterAction',//view yii\base\ActionEvent
        ];
    }
    
    public function beforeAction($event)
    {
        $event->isValid = true;// 后续有效
        
        $controller = $event->action->controller;
        
        $route = $controller->route;
        $moduleId = $controller->module->id;
        $controllerId = $controller->id;
        $actionId = $event->action->id;//！！！此处有一bug,当传递参数键为id时，action优化获取参数值，而不是action标识
        
        $httpType = Yii::$app->getRequest()->getMethod();

        //写入操作日志
        if(Yii::$app->getUser()->isGuest) {
            return;
        } else {
            foreach ($this->exceptModule as $module) {//忽略的模块
                if(strstr($route, $module.'/') !== false) {
                    return;
                }
            }
            
            foreach ($this->exceptController as $controller) {//忽略控制器
                if(strstr($route, '/'.$controller.'/') !== false) {
                    return;
                }
            }
            
            foreach ($this->exceptAction as $action) {//忽略动作
                if(strstr($route, '/'.$action) !== false) {
                    return;
                }
            }
            
            foreach ($this->exceptRoute as $r) {//忽略路由器
                if($route == $r) {
                    return;
                }
            }
            
            //var_dump($route.' '. $moduleId.' '. $controllerId.' '. $actionId);exit;
            //打日志
            $this->addLog($route, $moduleId, $controllerId, $actionId, $httpType);
        }
    }
    
    /**
     * 此方法对外开发，主要是处理那些未登录之前，比如login的动作
     * @param Permission $perm
     */
    protected function addLog($route, $moduleId, $controllerId, $actionId, $httpType)
    {
        $request = Yii::$app->request;
        
        $isPost = $request->isPost;
        $ip = $request->getUserIP();
        $agent = $request->getUserAgent();
        $mid = Yii::$app->getRequest()->get('mid', null);//自定义模型参数
        $md5 = md5($agent.$ip.$route.Yii::$app->getUser()->id.GLOBAL_LANG).($isPost?'1':'0');//代理+IP+路由+当前操作者+站点+语言
        
        $key = 'log_duration'.Yii::$app->getUser()->id.GLOBAL_LANG;
        
        $logCache = Yii::$app->cache->get($key);
        if($logCache && (($logCache['md5'] == $md5) || (microtime(true)*1000 - $logCache['t'] < $this->refreshTime))) {//采用调整缓存，不用数据库查询
            //重复刷新，nothing
            return;
        } else {
            $mesage = $this->logMessage($route, $moduleId, $controllerId, $actionId, $httpType, $mid);

            Yii::$app->db->createCommand()->insert(Log::tableName(), [
                'admin_id' => Yii::$app->getUser()->id,
                'username' => Yii::$app->getUser()->getIdentity()->username,
                'route' => $route,
                'name' => $mesage['name'],
                'method' => $request->method,
                'get_data' => $this->isGetData?Json::encode($request->get()):'',
                'post_data' => ($isPost && $this->isPostData)?Json::encode($request->post()):'',
                'ip' => (in_array($ip, ['localhost', '::1']))?'127.0.0.1':$ip,
                'agent' => $agent,
                'md5' => $md5,
                'created_at' => time(),
            ])->execute();
            
            Yii::$app->cache->set($key, [
                't' => microtime(true)*1000,//访止高频率恶意请求
                'md5' => $md5,//不记录刷新动作
            ]);
        }
    }
    
    /**
     * 日志描述
     * @param string $route
     * @return string[]
     */
    protected function logMessage($route, $moduleId, $controllerId, $actionId, $httpType, $mid = null)
    {
        //$httpType POST | GET
        $message = ['name' => '暂无描述', 'content' => ''];

        //1.先处理精确特殊的路由请求
        $mesages = [
            //默认页
            'site/home/index' => ['name' => '框架刷新', 'content' => ''],
            'site/home/default' => ['name' => '后台首页', 'content' => ''],
            'site/other/error' => ['name' => '进入了错误页面', 'content' => ''],
        ];
        
        if(isset($mesages[$route])) {
            $message = $mesages[$route];
        }
        
        //2.处理通用请求
        $mcs = [
            'cms/article' => '文章',
            'cms/block' => '碎片',
            'cms/cate' => '类别',
            'cms/column' => '栏目',
            'cms/file' => '文件',
            'cms/flag' => '标记',
            'cms/info' => '单页面',
            'cms/photo' => '图片',
            'cms/src' => '信息来源',
            'cms/video' => '视频',
            'cms/master-model' => $this->diyModelMessage($mid),
            'cms/diy-field' => '自定义字段',
            'ext/ad' => '广告',
            'ext/ad-type' => '广告位',
            'ext/job' => '招聘',
            'ext/link' => '友链',
            'ext/link-type' => '友链分类',
            'ext/nav' => '导航菜单',
            'ext/vote' => '投票',
            'site/admin' => '管理者',
            'site/help-cate' => '系统帮助分类',
            'site/help' => '系统帮助',
            'site/lnk' => '快捷方式',
            'site/face-config' => '界面配置',
            'sys/admin' => '管理者',
            'sys/config' => '系统配置',
            'sys/dev-log' => '开发日志',
            'sys/log' => '操作日志',
            'sys/role' => '角色',
            'sys/template' => '模板',
            'shop/product' => '产品',
            'shop/brand' => '产品品牌',
            'shop/product-cate' => '产品分类',
            'shop/product-flag' => '产品标记',
            'user/user' => '用户',
            'cms/diy-model' => '附加栏目',
            'site/help-flag' => '帮助标记',
            'sys/multilang' => '多语言',
            'user/comment' => '用户留言',
            'user/favorite' => '用户收藏',
            'user/inquiry' => '服务订单',
            'user/contact' => '联系我们',
            'user/complaint' => '投诉建议',
        ];
        
        $actions = [
            'index' => '{name}',
            'create' => '添加新{name}',
            'update' => '编辑{name}',
            'edit' => '编辑{name}',
            'delete' => '删除{name}',
            'check' => '{name}显示隐藏',
            'batch' => '批量{name}删除或排序',
            'quick-move' => '快捷移动{name}',
            'recycle' => '{name}回收站操作',
            'get-tags' => '获取{name}标签',
            'fileupload' => '上传{name}单图',
            'multiple-fileupload' => '上传{name}多图',
            'ueditor' => '操作{name}编辑器',
            'login' => '{name}登录',
            'logout' => '{name}退出',
            'setting' => '查看{name}',
        ];
        
        //var_dump($moduleId.'/'.$controllerId.'/'.$actionId);exit;
        
        //通用匹配
        if(isset($mcs[$moduleId.'/'.$controllerId]) && isset($actions[$actionId])) {
            $message['name'] = str_replace('{name}', $mcs[$moduleId.'/'.$controllerId], $actions[$actionId]);
            
            //$httpType POST | GET 进一步加工
            if($actionId == 'index') {
                $message['name'] = $message['name'].(($httpType == 'POST')?',批量提交':',查看列表');
            }
            if($actionId == 'create') {
                $message['name'] = $message['name'].(($httpType == 'POST')?',提交':',进入表单');
            }
            if($actionId == 'update') {
                $message['name'] = $message['name'].(($httpType == 'POST')?',提交':',进入表单');
            }
            if($actionId == 'batch') {
                $message['name'] = $message['name'].(($httpType == 'POST')?',提交':',进入表单');
            }
        }
        
        return $message;
    }

    /**
     * 自定义模型信息
     */
    protected function diyModelMessage($mid) {
        $title = '';
        $model = DiyModel::find()->select(['dm_title'])->where(['dm_id' => $mid])->one();
        if($model) {
            $title = $model->dm_title;
        }

        return $title;
    }
}