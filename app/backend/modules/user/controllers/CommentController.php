<?php

namespace app\modules\user\controllers;

use Yii;
use app\models\user\Comment;
use app\models\user\CommentSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\CheckAction;
use app\widgets\ueditor\UEditorAction;
use common\components\AliyunOss;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
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
                'className' => Comment::class,
                'kid' => $request->get('kid'),
            ],
            'ueditor' => [
                'class' => UEditorAction::class,
                'folder' => AliyunOss::OSS_DEFAULT.'/comment',
                'config' => [],
            ],
        ];
    }
    
    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '评论ID为'.$model->uc_id.' 添加成功，结果将展示在列表。');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '评论ID为'.$model->uc_id.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
            foreach (Comment::find()->current()->andWhere(['uc_id' => Yii::$app->getRequest()->post('checkid', [])])->all() as $model) {
                $model->delete();
                $tips .= '<li>'.'评论ID为'.$model->uc_id.' 删除成功！</li>';
            }
            Yii::$app->getSession()->setFlash('success', '<ul>'.$tips.'</ul>');
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Comment model.
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
                'msg' => '评论ID为'.$model->uc_id.' 已经成功删除！',
            ]);
        }
        
        Yii::$app->getSession()->setFlash('success', '评论ID为'.$model->uc_id.' 已经成功删除！');
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('此请求页面不存在。');
        }
    }
}
