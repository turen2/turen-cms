<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\diy\FaqsForm;
use common\models\diy\Faqs;
use common\models\diy\FaqsSearch;
use common\models\cms\Column;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * FaqsController implements the CRUD actions for Faqs model.
 */
class FaqsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Faqs models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new FaqsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'model' => new FaqsForm(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columnModel' => Column::find()->current()->where(['id' => Yii::$app->params['config_face_cn_faqs_column_id']])->one(),
        ]);
    }

    /**
     * 问答详情
     * @param $slug
     * @return string
     */
    public function actionDetail($slug)
    {
        $model = $this->findModel($slug);
        //上一条，下一条
        // $prevModel = Column::ModelRelated($model, 'prev');
        // $nextModel = Column::ModelRelated($model, 'next');//model或null

        $faqModels = Faqs::find()->where(['like', 'flag', '最新问答'])->orderBy(['orderid' => SORT_DESC])->limit(4)->all();

        return $this->render('detail', [
            'model' => $model,
            // 'prevModel' => $prevModel,
            // 'nextModel' => $nextModel,
            'faqModels' => $faqModels,
        ]);
    }

    /**
     * Find a model
     * @param $slug
     * @return mixed
     */
    protected function findModel($slug)
    {
        $model = Faqs::find()->current()->andWhere(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
