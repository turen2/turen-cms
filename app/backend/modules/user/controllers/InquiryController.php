<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\user\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\user\Inquiry;
use backend\models\user\InquirySearch;
use backend\components\Controller;

/**
 * InquiryController implements the CRUD actions for Inquiry model.
 */
class InquiryController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Inquiry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * view a Inquiry model
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * ajax edit a Inquiry model
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEdit()
    {
        $id = Yii::$app->getRequest()->get('id');
        $field = Yii::$app->getRequest()->post('field');
        $timeField = Yii::$app->getRequest()->post('time_field', null);
        $value = Yii::$app->getRequest()->post('value');

        $model = $this->findModel($id);
        $model->{$field} = $value;
        if(!empty($timeField)) {
            $model->{$timeField} = time();
        }
        $model->save(false);

        return $this->asJson([
            'state' => true,
            'msg' => '编辑成功',
        ]);
    }

    /**
     * Finds the Inquiry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Inquiry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inquiry::find()->where(['ui_id' => $id])->with('user')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}