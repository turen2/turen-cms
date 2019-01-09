<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\cms\Article;
use common\models\cms\Column;
use common\models\cms\ArticleSearch;

class BaikeController extends \app\components\Controller
{
    /**
     * 百科列表
     * @return string
     */
    public function actionList()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->params['config_face_banjia_cn_baike_column_id']);
        $columnModel = Column::findOne(['id' => Yii::$app->params['config_face_banjia_cn_baike_column_id']]);

        if($columnModel) {
            return $this->render('list', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columnModel' => $columnModel,
            ]);
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }

    /**
     * 百科详情
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail($slug)
    {
        $model = $this->findModel($slug);
        //上一条，下一条
        $prevModel = Column::ModelRelated($model, 'prev');
        $nextModel = Column::ModelRelated($model, 'next');//model或null
        return $this->render('detail', [
            'model' => $model,
            'prevModel' => $prevModel,
            'nextModel' => $nextModel,
        ]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        $model = Article::find()->current()->andWhere(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
