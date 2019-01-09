<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

use common\models\cms\Column;
use common\models\cms\Info;

class PageController extends \app\components\Controller
{
    /**
     * 单页详情
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionInfo($slug)
    {
        $model = $this->findModel($slug);
        return $this->render('info', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Info model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Info the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        //$model = Info::find()->one();
        $model = Info::find()->alias('i')->select(['c.cname title', 'c.parentstr', 'i.*'])->leftJoin(Column::tableName().' as c', 'c.id = i.columnid')->andWhere(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }

}
