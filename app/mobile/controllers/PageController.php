<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\ext\Job;
use common\models\cms\Column;
use common\models\cms\Info;

class PageController extends \app\components\Controller
{
    /**
     * 单页详情，通用单页面输出
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
     * 单页面，关于我们
     * @return string
     */
//    public function actionAboutUs()
//    {
//        $pageId = Yii::$app->params['config_face_cn_about_us_id'];
//        $model = $this->findModelByColumnId($pageId);
//        return $this->render('about-us', [
//            'model' => $model,
//        ]);
//    }

    /**
     * 加入我们，工作招聘
     * @return string
     */
    public function actionJobs()
    {
        $jobModels = Job::find()->current()->active()->orderBy(['orderid' => SORT_DESC])->all();
        return $this->render('jobs', [
            'jobModels' => $jobModels,
        ]);
    }

    protected function findModelByColumnId($columnId)
    {
        $model = Info::find()->alias('i')->select(['c.cname title', 'c.parentstr', 'i.*'])->leftJoin(Column::tableName().' as c', 'c.id = i.columnid')->where(['c.id' => $columnId])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
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
        $model = Info::find()->alias('i')->select(['c.cname title', 'c.parentstr', 'i.*'])->leftJoin(Column::tableName().' as c', 'c.id = i.columnid')->active()->andWhere(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
