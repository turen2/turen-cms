<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace mobile\controllers;

use Yii;
use common\models\com\VerifyConsultForm;
use common\models\shop\Product;
use common\models\shop\ProductSearch;
use yii\web\NotFoundHttpException;
use mobile\behaviors\PlusViewBehavior;
use common\models\cms\Column;

class ServiceController extends \mobile\components\Controller
{
    public function behaviors()
    {
        return [
            'plusView' => [
                'class' => PlusViewBehavior::class,
                'modelClass' => Product::class,
                'slug' => Yii::$app->getRequest()->get('slug'),
                'field' => 'hits',
            ]
        ];
    }

    /**
     * 服务列表
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionList()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->params['config_face_cn_product_column_id']);
        $columnModel = Column::findOne(['id' => Yii::$app->params['config_face_cn_product_column_id']]);

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
     * 服务详情
     * @return string
     */
    public function actionDetail($slug)
    {
        $curModel = $this->findModel($slug);
        //上一条，下一条
        $prevModel = Column::ModelRelated($curModel, 'prev');
        $nextModel = Column::ModelRelated($curModel, 'next');//model或null
        $models = Product::find()->active()->orderBy(['orderid' => SORT_DESC])->all();
        return $this->render('detail', [
            'curModel' => $curModel,
            'models' => $models,
            'slug' => $slug,
            'prevModel' => $prevModel,
            'nextModel' => $nextModel,
        ]);
    }

    public function actionVerifyConsult()
    {
        $model = new VerifyConsultForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            //验证成功，录入数据到咨询订单系统

            return $this->asJson([
                'state' => true,
                'code' => '200',
                'result' => '',
            ]);
        } else {
            return $this->renderAjax('_phone_verify', [
                'model' => $model,
            ]);
        }
    }

    /**
     *
     * 类型ajax
     * @return json
     */
    public function actionConsult()
    {
        return $this->asJson([
            'state' => true,
            'code' => '200',
            'result' => print_r(\Yii::$app->request->cookies),
        ]);
    }

    protected function findModel($slug)
    {
        $model = Product::find()->active()->andWhere(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
