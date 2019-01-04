<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\com\controllers;

use Yii;
use app\components\Controller;
use yii\helpers\Inflector;
use yii\web\HttpException;

/**
 * LinkController.
 */
class LinkController extends Controller
{
    /**
     * 统一生成拼音
     * @param string $text
     * @return []
     */
    public function actionPinyin($text = '')
    {
        if(!Yii::$app->getRequest()->isAjax) {
            throw new HttpException(403, '请求类型出错。');
        }
        
        //直接采用intl方案
        $this->asJson([
            'state' => true,
            'code' => 200,
            'msg' => Inflector::slug($text),
        ]);
    }
}
