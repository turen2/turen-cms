<?php

namespace app\modules\sys\controllers;

use Yii;
use app\models\sys\MultilangTpl;
use app\models\sys\MultilangTplSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;
use app\actions\SimpleMoveAction;

/**
 * MultilangTplController implements the CRUD actions for MultilangTpl model.
 */
class MultilangTplController extends Controller
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
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'check' => [
                'class' => CheckAction::class,
                'className' => MultilangTpl::class,
                'id' => $request->get('id'),
                'field' => 'is_visible',
                'openName' => '前台显示',
                'closeName' => '前台隐藏',
            ],
            //简单排序
            'simple-move' => [
                'class' => SimpleMoveAction::class,
                'className' => MultilangTpl::class,
                'id' => $request->get('id'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameField' => 'lang_name',
            ],
        ];
    }

    /**
     * Lists all MultilangTpl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MultilangTplSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MultilangTpl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MultilangTpl();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->lang_name.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MultilangTpl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->lang_name.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing MultilangTpl model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        
        //指定默认前台或后台的站点不能删除
        $state = true;
        $msg = $model->lang_name.' 已经成功删除！';
        
        if(!empty($model->back_default)) {
            $state = false;
            $msg = $model->lang_name.' 被指定后台默认不能删！';
        }
        if(!empty($model->front_default)) {
            $state = false;
            $msg = $model->lang_name.' 被指定前台默认不能删！';
        }
        if($model->lang_sign == GLOBAL_LANG) {
            $state = false;
            $msg = $model->lang_name.' 为系统当前选中语言，请先切换为其它语言后再来删除！';
        }
        
        if($state) {
            $model->delete();
        }
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => $state,
                'msg' => $msg,
            ]);
        }
        
        Yii::$app->getSession()->setFlash($state?'success':'warning', $msg);
        return $this->redirect($returnUrl);
    }
    
    /**
     * 批量提交并处理
     * @param string $type delete | order
     * @return \yii\web\Response
     */
    public function actionBatch($type)
    {
        if($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = MultilangTpl::findOne(['id' => $id])) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the MultilangTpl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MultilangTpl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MultilangTpl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
