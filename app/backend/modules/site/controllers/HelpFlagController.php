<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\site\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\site\HelpFlag;
use backend\models\site\HelpFlagSearch;
use backend\components\Controller;
use backend\actions\SimpleMoveAction;

/**
 * HelpFlagController implements the CRUD actions for HelpFlag model.
 */
class HelpFlagController extends Controller
{
    
    public function actions()
    {
        $request = Yii::$app->getRequest();
        return [
            //简单排序
            'quick-move' => [
                'class' => SimpleMoveAction::class,
                'className' => HelpFlag::class,
                'kid' => $request->get('kid'),
                'type' => $request->get('type'),
                'orderid' => $request->get('orderid'),
                'nameField' => 'flagname',
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
     * Lists all HelpFlag models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->getRequest()->isPost) {
            $post = Yii::$app->getRequest()->post();
            
            $tip = '';
            if(isset($post['id'])) {
                $ids = $post['id'];
                $flagnames = $post['flagname'];
                $flags = $post['flag'];
                $orderids = $post['orderid'];
                
                for ($i = 0; $i < count($ids); $i++) {
                    if(isset($flagnames[$i]) && isset($flags[$i]) && isset($orderids[$i])) {
                        //修改
                        $model = HelpFlag::find()->andWhere(['id' => $ids[$i]])->one();
                        $values = [
                            'flagname' => $flagnames[$i],
                            'flag' => $flags[$i],
                        ];
                        if(!empty($orderids[$i])) {
                            $values['orderid'] = $orderids[$i];
                        }
                        $model && $model->updateAttributes($values);
                    }
                    $tip = '批量修改成功！';
                }
            }
            
            $flagnameadd = $post['flagnameadd'];
            $flagadd = $post['flagadd'];
            $orderidadd = $post['orderidadd'];
            if(!empty($flagnameadd) && !empty($flagadd)) {
                //新建
                $model = new HelpFlag();
                $model->loadDefaultValues();
                $model->flagname = $flagnameadd;
                $model->flag = $flagadd;
                if(!empty($orderidadd)) {
                    $model->orderid = $orderidadd;
                }
                $model->save(false);
                
                $tip .= ' '.$flagnameadd.' 添加成功！';
            }
            
            !empty($tip) && Yii::$app->getSession()->setFlash('success', $tip);
            
            return $this->redirect(['index']);
        } else {
            $searchModel = new HelpFlagSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing HelpFlag model.
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
                'msg' => $model->flagname.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', $model->flagname.' 已经成功删除！');
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
            foreach (HelpFlag::find()->andWhere(['id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.$model->flagname.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        } elseif($type == 'order') {//全局提交
            $ids = Yii::$app->getRequest()->post('checkid', []);
            $orders = Yii::$app->getRequest()->post('orderid', []);
            foreach ($ids as $key => $id) {
                if($model = HelpFlag::find()->andWhere(['id' => $id])->one()) {
                    $model->orderid = $orders[$key];
                    $model->save(false);
                }
            }
            Yii::$app->getSession()->setFlash('success', '已完成批量排序操作！');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the HelpFlag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HelpFlag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HelpFlag::find()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
