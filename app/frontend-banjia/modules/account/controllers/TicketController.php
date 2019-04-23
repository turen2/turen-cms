<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

/**
 * 工单管理
 * Class TicketController
 * @package app\modules\account\controllers
 */
class TicketController extends \app\components\Controller
{
    public function actionList()
    {
        return $this->render('list', [
        ]);
    }

    protected function findModel($id)
    {
        $model = Article::find()->current()->delstate(Article::IS_NOT_DEL)->andWhere(['id' => $id])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}