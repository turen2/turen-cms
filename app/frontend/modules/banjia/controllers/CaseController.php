<?php

namespace app\modules\banjia\controllers;

class CaseController extends \app\components\Controller
{
    /**
     * 案例列表
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 案例详情
     * @return string
     */
    public function actionDetail()
    {
        return $this->render('detail');
    }
}
