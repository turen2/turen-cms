<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            //
        ];
    }

    /**
     * 电脑版首页
     * @return mixed
     */
    public function actionHome()
    {
        return $this->render('home');
    }
}
