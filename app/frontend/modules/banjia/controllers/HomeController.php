<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

use Yii;
use yii\web\Controller;

/**
 * Home controller for the `banjia` module
 */
class HomeController extends Controller
{
    /**
     * Renders the default view for the module
     * @return string
     */
    public function actionDefault()
    {
        //echo Yii::$app->getViewPath();exit;

        //var_dump(Yii::$app->getView()->theme->pathMap);exit;
        
        return $this->render('default');
    }
}
