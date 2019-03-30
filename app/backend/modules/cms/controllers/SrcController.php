<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\cms\controllers;

use Yii;
use app\models\cms\Src;
use app\models\cms\SrcSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\SimpleMoveAction;

/**
 * SrcController implements the CRUD actions for Src model.
 */
class SrcController extends Controller
{
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            //简单排序
            'simple-move' => [
                'class' => SimpleMoveAction::class,
                'className' => Src::class,
                'kid' => $request->get('kid'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameField' => 'srcname',
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
     * Lists all Src models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->getRequest()->isPost) {
            $post = Yii::$app->getRequest()->post();
            
            $tip = '';
            if(isset($post['id'])) {
                $ids = $post['id'];
                $srcnames = $post['srcname'];
                $linkurls = $post['linkurl'];
                $orderids = $post['orderid'];
                
                for ($i = 0; $i < count($ids); $i++) {
                    if(isset($srcnames[$i]) && isset($linkurls[$i]) && isset($orderids[$i])) {
                        //修改
                        $model = Src::find()->current()->andWhere(['id' => $ids[$i]])->one();
                        $model && $model->updateAttributes([
                            'srcname' => $srcnames[$i],
                            'linkurl' => $linkurls[$i],
                            'orderid' => $orderids[$i],
                        ]);
                    }
                    $tip = '批量修改成功！';
                }
            }
            
            $srcnameadd = $post['srcnameadd'];
            $linkurladd = $post['linkurladd'];
            $orderidadd = $post['orderidadd'];
            if(!empty($srcnameadd) && !empty($linkurladd)) {
                //新建
                $model = new Src();
                $model->srcname = $srcnameadd;
                $model->linkurl = $linkurladd;
                $model->orderid = $orderidadd;
                $model->save(false);
                
                $tip .= ' '.$srcnameadd.' 添加成功！';
            }
            
            !empty($tip) && Yii::$app->getSession()->setFlash('success', $tip);
            
            return $this->redirect(['index']);
        } else {
            $searchModel = new SrcSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
        $searchModel = new SrcSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Deletes an existing Src model.
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
                'msg' => $model->srcname.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->srcname.' 已经成功删除！');
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
            foreach (Src::find()->current()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->srcname.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = Src::find()->current()->andWhere(['id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Src model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Src the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Src::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
