<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
//全站帮助中心
namespace app\controllers;

use Yii;
use app\components\Controller;

/**
 * help controller
 */
class HelpController extends Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }
}
