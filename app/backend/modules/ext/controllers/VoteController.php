<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\ext\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AliyunOss;
use backend\models\ext\Vote;
use backend\models\ext\VoteSearch;
use backend\components\Controller;
use backend\models\ext\VoteOption;
use backend\actions\CheckAction;
use backend\widgets\ueditor\UEditorAction;
use backend\widgets\edititem\EditItemAction;

/**
 * VoteController implements the CRUD actions for Vote model.
 */
class VoteController extends Controller
{
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'edit-item' => [
                'class' => EditItemAction::class,
                'className' => Vote::class,
                'kid' => $request->post('kid'),
                'field' => 'orderid',
                'value' => $request->post('value'),
            ],
            'check' => [
                'class' => CheckAction::class,
                'className' => Vote::class,
                'kid' => $request->get('kid'),
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/vote',
                'config' => [],
            ],
        ];
    }
    
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
     * Lists all Vote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Vote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vote();
        $model->loadDefaultValues();
        
        $optionModel = new VoteOption();
        $optionModel->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && ($model->options = Yii::$app->request->post('options')) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->title.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'optionModel' => $optionModel,
            ]);
        }
    }

    /**
     * Updates an existing Vote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $optionModel = new VoteOption();
        $optionModel->loadDefaultValues();
        
        $optionModels = VoteOption::find()->where(['voteid' => $model->id])->all();

        if ($model->load(Yii::$app->request->post()) && ($model->options = Yii::$app->request->post('options')) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->title.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'optionModel' => $optionModel,
                'optionModels' => $optionModels,
            ]);
        }
    }
    
    /**
     * Deletes an existing Vote model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        $model->delete();
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => true,
                'msg' => $model->title.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->title.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the Vote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vote::find()->current()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
