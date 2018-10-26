<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\user\controllers;

use Yii;
use app\models\user\Level;
use app\models\user\LevelSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\SimpleMoveAction;

/**
 * LevelController implements the CRUD actions for Level model.
 */
class LevelController extends Controller
{
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            //简单排序
            'simple-move' => [
                'class' => SimpleMoveAction::class,
                'className' => Level::class,
                'id' => $request->get('id'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameFeild' => 'level_name',
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
                    'batch' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Level models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->getRequest()->isPost) {
            $post = Yii::$app->getRequest()->post();
            
            $tip = '';
            if(isset($post['id'])) {
                $ids = $post['id'];
                $level_names = $post['level_name'];
                $level_expval_mins = $post['level_expval_min'];
                $level_expval_maxs = $post['level_expval_max'];
                $orderids = $post['orderid'];
                
                for ($i = 0; $i < count($ids); $i++) {
                    if(isset($level_names[$i]) && isset($level_expval_mins[$i]) && isset($level_expval_maxs[$i]) && isset($orderids[$i])) {
                        //修改
                        $model = Level::find()->current()->andWhere(['level_id' => $ids[$i]])->one();
                        $model && $model->updateAttributes([
                            'level_name' => $level_names[$i],
                            'level_expval_min' => $level_expval_mins[$i],
                            'level_expval_max' => $level_expval_maxs[$i],
                            'orderid' => $orderids[$i],
                        ]);
                    }
                    $tip = '批量修改成功！';
                }
            }
            
            $level_nameadd = $post['level_nameadd'];
            $level_expval_minadd = $post['level_expval_minadd'];
            $level_expval_maxadd = $post['level_expval_maxadd'];
            $orderidadd = $post['orderidadd'];
            if(!empty($level_nameadd) && $level_expval_minadd && $level_expval_maxadd) {
                //新建
                $model = new Level();
                $model->level_name = $level_nameadd;
                $model->level_expval_min = $level_expval_minadd;
                $model->level_expval_max = $level_expval_maxadd;
                $model->orderid = $orderidadd;
                
                $model->save(false);
                
                $tip .= ' '.$level_nameadd.' 添加成功！';
            }
            
            !empty($tip) && Yii::$app->getSession()->setFlash('success', $tip);
            
            return $this->redirect(['index']);
        } else {
            $searchModel = new LevelSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
        $searchModel = new LevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Deletes an existing Level model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        $model->delete();
        
        $state = true;
        $msg = $model->level_name.' 已经成功删除！';
        
        if($state && !empty($model->is_default)) {
            $state = false;
            $msg = $model->level_name.' 为默认等级不能删除！';
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
     * 设置为默认
     * @param integer $id
     * @param array $returnUrl
     * @return \yii\web\Response
     */
    public function actionSetDefault($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        
        Level::updateAll(['is_default' => Level::STATUS_OFF], ['lang' => GLOBAL_LANG]);
        
        $model->is_default = Level::STATUS_ON;
        $model->save(false);
        
        Yii::$app->getSession()->setFlash('success', $model->level_name.' 已经设为默认！');
        return $this->redirect($returnUrl);
    }
    
    /**
     * 批量提交并处理
     * @param string $type delete | order
     * @return \yii\web\Response
     */
    public function actionBatch($type)
    {
        if($type == 'delete') {
            $tips = '';
            foreach (Level::find()->current()->andWhere(['level_id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->level_name.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = Level::find()->current()->andWhere(['level_id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Level model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Level the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Level::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
