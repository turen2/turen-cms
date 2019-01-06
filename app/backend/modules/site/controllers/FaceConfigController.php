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
use app\models\sys\MultilangTpl;
use app\models\sys\Template;

class FaceConfigController extends \app\components\Controller
{
    /**
     * 查看配置
     * @return string
     */
    public function actionSetting()
    {
        //当前语言下的模板
        $multilangTplmodel = MultilangTpl::findOne(['lang_sign' => GLOBAL_LANG]);
        if($multilangTplmodel) {
            $template = Template::findOne(['temp_id' => $multilangTplmodel->template_id]);
            if($template) {
                return $this->render('setting', [
                    'templateId' => $template->temp_id,
                    'templateCode' => $template->temp_code,
                    'configs' => FaceConfig::FaceConfigArray($template->temp_id),
                    'model' => new FaceConfig(),
                ]);
            } else {
                throw new UserException('当前语言下，指定的模板不存在！');
            }
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