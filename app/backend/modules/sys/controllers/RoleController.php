<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\sys\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\sys\Role;
use backend\models\sys\RoleSearch;
use backend\components\Controller;
use backend\actions\CheckAction;
use backend\models\sys\RoleItem;
use backend\models\cms\DiyModel;
use backend\models\sys\Admin;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            'check' => [
                'class' => CheckAction::class,
                'className' => Role::class,
                'kid' => $request->get('kid'),
                'openName' => '有效',
                'closeName' => '无效',
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
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->role_name.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'diyModels' => DiyModel::find()->active()->asArray()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //更新路由
            $post = Yii::$app->request->post();
            $data = isset($post['Perm'])?$post['Perm']:[];
            RoleItem::BatchUpdate($model->role_id, $data);
            
        	Yii::$app->getSession()->setFlash('success', $model->role_name.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'diyModels' => DiyModel::find()->active()->asArray()->all(),
            ]);
        }
    }
    
    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        
        //特殊情况下不能删除
        $state = true;
        $msg = $model->role_name.' 已经成功删除！';
        
        if($state && Admin::find()->where(['role_id' => $id])->count('id') > 0) {
            $state = false;
            $msg = '此角色已经作用在指定的站点上，请先解绑站点。';
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
        
        Yii::$app->getSession()->setFlash(($state?'success':'warning'), $msg);
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
