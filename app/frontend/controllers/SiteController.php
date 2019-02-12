<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;

/**
 * Site controller
 */
class SiteController extends \app\components\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'main',
                'view' => 'error',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionHome()
    {
        return $this->render('home');
    }
    
    public function actionTest()
    {
        return $this->render('test');
    }
}
