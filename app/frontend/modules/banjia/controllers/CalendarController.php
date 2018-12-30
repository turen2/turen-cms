<?php

namespace app\modules\banjia\controllers;

class CalendarController extends \app\components\Controller
{
    /**
     * 吉日日历
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
