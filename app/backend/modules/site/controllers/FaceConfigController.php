<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\site\controllers;

use Yii;
use app\widgets\fileupload\FileUploadAction;
use common\components\AliyunOss;
use app\models\site\FaceConfig;

class FaceConfigController extends \app\components\Controller
{
    protected $_configs = [];
    
    public function init()
    {
        parent::init();
        
        //当前站点指定的语言站配置参数
        foreach (FaceConfig::getConfigAsArray() as $config) {
            $this->_configs[$config['cfg_group']][] = $config;
        }
    }
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'fileupload' => [
                'class' => FileUploadAction::class,
                'uploadName' => 'logourl',
                'folder' => AliyunOss::OSS_DEFAULT.'/face_config',
            ],
        ];
    }
    
    /**
     * 查看配置
     * @return string
     */
    public function actionSetting()
    {
        return $this->render('setting', [
            'configs' => $this->_configs,
            'model' => new FaceConfig(),
        ]);
    }
    
    /**
     * 批量更新，跳转到默认setting
     * @return \yii\web\Response
     */
    public function actionBatch()
    {
//         if(Yii::$app->request->isPost) {
//             var_dump(Yii::$app->request->post());
//             exit;
//         }
        
        //批量更新
        if (Yii::$app->request->isPost && FaceConfig::batchSave(Yii::$app->request->post())) {
            //更新缓存
            FaceConfig::UpdateCache();
            Yii::$app->getSession()->setFlash('success', '界面配置保存成功。');
        }
        
        return $this->redirect(['setting']);
    }
}