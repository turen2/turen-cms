<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

use common\models\diy\FaqsForm;
use Yii;
use common\models\diy\Faqs;
use common\models\diy\FaqsSearch;
use app\components\Controller;
use yii\filters\VerbFilter;

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
    public function actionIndex()
    {
        $searchModel = new FaqsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->getRequest()->isAjax) {
            $pageSize = $dataProvider->pagination->pageSize;
            if($dataProvider->count < $pageSize) {
                $complete = true;
            } else {
                $complete = false;
            }

            return $this->asJson([
                'state' => true,
                'code' => 200,
                'complete' => $complete,//是否已经加载完了
                'msg' => $this->renderAjax('ajax-index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]),
            ]);
        } else {
            return $this->render('index', [
                'model' => new FaqsForm(),
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Creates a new Faqs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Faqs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
