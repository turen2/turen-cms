<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace mobile\controllers;

use Yii;

class SearchController extends \mobile\components\Controller
{
    public $layout = '/main_search';

    public function actionList()
    {

        return $this->render('list');
    }
}
