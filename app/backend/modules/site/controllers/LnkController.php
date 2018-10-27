<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\site\controllers;

use Yii;
use app\models\site\Lnk;
use app\models\site\LnkSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\SimpleMoveAction;

/**
 * LnkController implements the CRUD actions for Lnk model.
 */
class LnkController extends Controller
{
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            //简单排序
            'simple-move' => [
                'class' => SimpleMoveAction::class,
                'className' => Lnk::class,
                'id' => $request->get('id'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameFeild' => 'lnk_name',
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
     * Lists all Lnk models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->getRequest()->isPost) {
            $post = Yii::$app->getRequest()->post();
            
            $tip = '';
            if(isset($post['lnk_id'])) {
                $lnkIds = $post['lnk_id'];
                $lnkNames = $post['lnk_name'];
                $lnkLinks = $post['lnk_link'];
                $lnkIcos = $post['lnk_ico'];
                $orderids = $post['orderid'];
                
                for ($i = 0; $i < count($lnkIds); $i++) {
                    if(isset($lnkNames[$i]) && isset($lnkLinks[$i]) && isset($orderids[$i])) {
                        //修改
                        $model = Lnk::find()->andWhere(['lnk_id' => $lnkIds[$i]])->one();
                        $model && $model->updateAttributes([
                            'lnk_name' => $lnkNames[$i],
                            'lnk_link' => $lnkLinks[$i],
                            'lnk_ico' => $lnkIcos[$i],
                            'orderid' => $orderids[$i],
                        ]);
                    }
                    $tip = '批量修改成功！';
                }
            }
            
            $lnkNameadd = $post['lnk_nameadd'];
            $lnkLinkadd = $post['lnk_linkadd'];
            $lnkIcoadd = $post['lnk_icoadd'];
            $orderidadd = $post['orderidadd'];
            if($lnkNameadd && $lnkLinkadd) {
                //新建
                $model = new Lnk();
                $model->lnk_name = $lnkNameadd;
                $model->lnk_link = $lnkLinkadd;
                $model->lnk_ico = $lnkIcoadd;
                $model->orderid = $orderidadd;
                $model->save(false);
                
                $tip .= ' '.$lnkNameadd.' 添加成功！';
            }
            
            !empty($tip) && Yii::$app->getSession()->setFlash('success', $tip);
            
            return $this->redirect(['index']);
        } else {
            $searchModel = new LnkSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing Lnk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = ['index'])
    {
        $model = $this->findModel($id);
        $model->delete();
        
        if(Yii::$app->getRequest()->isAjax) {
            return $this->asJson([
                'state' => true,
                'msg' => $model->lnk_name.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->lnk_name.' 已经成功删除！');
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
            foreach (Lnk::find()->andWhere(['lnk_id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->lnk_name.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            
            foreach ($ids as $key => $id) {
                if($model = Lnk::find()->andWhere(['lnk_id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Lnk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lnk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lnk::find()->andWhere(['lnk_id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
