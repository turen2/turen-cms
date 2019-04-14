<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use common\models\com\VerifyConsult;
use common\models\shop\Product;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ServiceController extends \app\components\Controller
{
    /**
     * @inheritdoc
     * 强制使用post进行删除操作，post受csrf保护
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'consult' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 服务详情
     * @return string
     */
    public function actionDetail($slug)
    {
        $curModel = $this->findModel($slug);
        $models = Product::find()->active()->orderBy(['orderid' => SORT_DESC])->all();
        return $this->render('detail', [
            'curModel' => $curModel,
            'models' => $models,
            'slug' => $slug,
        ]);
    }

    public function actionVerifyConsult()
    {
        $model = new VerifyConsult();
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
        $model = Product::find()->active()->where(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
