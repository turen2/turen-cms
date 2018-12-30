<?php

namespace app\modules\banjia\controllers;

class NewsController extends \app\components\Controller
{
    /**
     * 新闻列表
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 新闻详情
     * @return string
     */
    public function actionDetail()
    {
        return $this->render('list');
    }
}
