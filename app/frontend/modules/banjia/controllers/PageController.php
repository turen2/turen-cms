<?php

namespace app\modules\banjia\controllers;

class PageController extends \app\components\Controller
{
    /**
     * page详情
     * @return string
     */
    public function actionInfo()
    {
        return $this->render('info');
    }

}
