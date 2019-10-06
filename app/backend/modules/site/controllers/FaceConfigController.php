<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\site\controllers;

use Yii;
use yii\base\UserException;
use app\models\site\FaceConfig;
use app\models\sys\Multilang;

class FaceConfigController extends \app\components\Controller
{
    /**
     * 查看配置
     * @return string
     */
    public function actionSetting()
    {
        //当前语言下的模板
        $multilangmodel = Multilang::findOne(['lang_sign' => GLOBAL_LANG]);
        if($multilangmodel) {
            return $this->render('setting', [
                'configs' => FaceConfig::FaceConfigArray(),
                'model' => new FaceConfig(),
            ]);
        }
        throw new UserException('多语言管理下，未设置此语言！');
    }
    
    /**
     * 批量更新，跳转到默认setting
     * @return \yii\web\Response
     */
    public function actionBatch()
    {
        //批量更新
        if (Yii::$app->request->isPost && FaceConfig::batchSave(Yii::$app->request->post())) {
            //FaceConfig::UpdateCache();//更新缓存
            Yii::$app->getSession()->setFlash('success', '界面配置保存成功。');
        }
        
        return $this->redirect(['setting']);
    }
}