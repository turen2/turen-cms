<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace mobile\controllers;

use Yii;
use common\models\cms\Column;
use common\models\cms\Photo;
use common\models\cms\PhotoSearch;
use yii\web\NotFoundHttpException;
use common\tools\like\LikeAction;
use mobile\behaviors\PlusViewBehavior;

class ChexingController extends \mobile\components\Controller
{
    public function behaviors()
    {
        return [
            'plusView' => [
                'class' => PlusViewBehavior::class,
                'modelClass' => Photo::class,
                'slug' => Yii::$app->getRequest()->get('slug'),
                'field' => 'hits',
            ]
        ];
    }

    public function actions()
    {
        return [
            // 点赞
            'like' => [
                'class' => LikeAction::class,
                'modelClass' => Photo::class, // 车型展示
                'id' => Yii::$app->getRequest()->post('id'),
                'type' => Yii::$app->getRequest()->post('type'),
            ]
        ];
    }

    /**
     * 车型介绍列表
     * @return string
     */
    public function actionList()
    {
        $searchModel = new PhotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 12, Yii::$app->params['config_face_cn_chexing_column_id']);
        $columnModel = Column::findOne(['id' => Yii::$app->params['config_face_cn_chexing_column_id']]);

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
     * 车型介绍详情
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
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        $model = Photo::find()->current()->andWhere(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
