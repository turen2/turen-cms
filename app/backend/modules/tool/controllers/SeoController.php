<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\tool\controllers;

use Yii;
use yii\db\Exception;
use backend\components\Controller;
use backend\models\cms\Column;
use backend\models\tool\SeoSearch;
use backend\models\cms\MasterModel;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
{
    /**
     * Lists all Seo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeoSearch();

        // 获取合适的columnid
        $post = Yii::$app->request->getQueryParam('SeoSearch', null);
        $columnModel = null;
        if($post && isset($post['columnid'])) {
            $columnModel = Column::findOne($post['columnid']);
        }
        if(empty($columnModel)) {
            $columnModel = Column::find()->one();
        }
        if(empty($columnModel)) {
            throw new Exception('系统没有设置栏目，异常。。。。。');
        }

        $className = Column::ColumnConvert('id2Class', $columnModel->type);
        if(strpos($className, 'MasterModel') !== false) {
            $className = MasterModel::className();
            MasterModel::$DiyModelId = $columnModel->type;
        }

        $searchModel->columnid = $columnModel->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $className);

        return $this->render('index', [
            'className' => $className,
            'searchModel' => $searchModel,
            'columnModel' => $columnModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 更新
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate()
    {
        // 组织数据
        $post = Yii::$app->getRequest()->getBodyParams();
        $columnid = $post['columnid'];
        $id = $post['id'];
        unset($post['columnid'], $post['id']);
        $data = $post;

        // 查栏目对应的类型，类，并生成对象
        $columnModel = Column::findOne($columnid);
        $class = Column::ColumnConvert('id2class', $columnModel->type);

        //更新对象
        $class::updateAll($data, ['id' => $id]);

        $this->asJson([
            'state' => true,
            'msg' => '',
        ]);

        /*
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->getSession()->setFlash('success', $model->title.' 已经修改成功！');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        */
    }

    /**
     * 批量更新
     */
    public function actionBatchUpdate()
    {
        // 组织数据
        $post = Yii::$app->getRequest()->getBodyParams();
        // var_dump($post);exit;
        $columnid = $post['columnid'];
        unset($post['columnid']);

        // 查栏目对应的类型，类，并生成对象
        $columnModel = Column::findOne($columnid);
        $class = Column::ColumnConvert('id2class', $columnModel->type);

        foreach ($post['id'] as $key => $item) {
            $id = $item['value'];

            $atrributes = [
                'title' => $post['title'][$key]['value'],
                'slug' => $post['slug'][$key]['value'],
                'keywords' => $post['keywords'][$key]['value'],
                'description' => $post['description'][$key]['value']
            ];

            $class::updateAll($atrributes, ['id' => $id]);
        }

        $this->asJson([
            'state' => true,
            'msg' => '',
        ]);
    }

    /**
     * 推荐
     */
    public function actionRecommend()
    {

    }

    /**
     * 批量推荐
     */
    public function actionBatchRecommend()
    {

    }
}
