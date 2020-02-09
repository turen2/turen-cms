<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use common\models\account\CompanyForm;

/**
 * 企业资质
 * Class CompanyController
 * @package app\modules\account\controllers
 */
class CompanyController extends \app\components\Controller
{
    public function actionInfo()
    {
        $model = new CompanyForm();
        return $this->render('info', [
            'model' => $model,
        ]);
    }
}