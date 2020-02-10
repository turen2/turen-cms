<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\models\cms\Column;
use common\models\cms\Photo;
use common\models\cms\PhotoSearch;
use common\helpers\ImageHelper;
use common\tools\like\LikeAction;
use app\behaviors\PlusViewBehavior;

class CaseController extends \app\components\Controller
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
                'modelClass' => Photo::class, // 案例展示
                'id' => Yii::$app->getRequest()->post('id'),
                'type' => Yii::$app->getRequest()->post('type'),
            ]
        ];
    }

    /**
     * 案例列表/ajax数据流
     * @param int $wallpage 动态加载参数
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionList($wallpage = 1)
    {
        $columnId = Yii::$app->params['config_face_cn_case_column_id'];
        $pageSize = 10;
        $columnModel = Column::findOne(['id' => $columnId]);
        $searchModel = new PhotoSearch();
        if($columnModel) {
            if(Yii::$app->getRequest()->isAjax) { // 二次异步请求
                // 调整返回正确的数据段
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $columnId);
                $dataProvider->pagination->setPage($wallpage);
                $dataProvider->pagination->setPageSize($pageSize);
                $models = $dataProvider->getModels();
                $arr = [];
                foreach ($models as $index => $model) {
                    $arr[$index]['title'] = $model->title;
                    $arr[$index]['url'] = Url::to(['/case/detail', 'slug' => $model->slug]);
                    $arr[$index]['picurl'] = empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true);
                    $arr[$index]['address'] = $model->diyfield_case_address;
                    $arr[$index]['hits'] = $model->hits;
                    $arr[$index]['date'] = Yii::$app->getFormatter()->asDate($model->posttime, 'php:Y/m/d');
                }

                return $this->asJson([
                    'state' => "success",
                    'status' => 1,
                    'end' => false,
                    'caseMoreList' => $arr
                ]);
            } else {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $columnId);
                return $this->render('list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'columnModel' => $columnModel,
                ]);
            }
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }

    /**
     * 案例详情
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
     * Finds the Photo model based on its primary key value.
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
