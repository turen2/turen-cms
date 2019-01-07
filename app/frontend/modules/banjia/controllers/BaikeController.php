<?php

namespace app\modules\banjia\controllers;

class BaikeController extends \app\components\Controller
{
    /**
     * 百科列表
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 百科详情
     * @return string
     */
    public function actionDetail()
    {
        return $this->render('detail');
    }
}
