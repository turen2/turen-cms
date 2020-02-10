<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;

class SearchController extends \app\components\Controller
{
    public $layout = '/main_search';

    public function actionList()
    {

        return $this->render('list');
    }
}
