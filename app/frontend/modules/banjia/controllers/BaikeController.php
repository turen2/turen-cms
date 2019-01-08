<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

use common\models\cms\Column;
use Yii;
use common\models\cms\ArticleSearch;
use yii\web\NotFoundHttpException;

class BaikeController extends \app\components\Controller
{
    /**
     * 百科列表
     * @return string
     */
    public function actionList()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->params['config_face_banjia_cn_baike_column_id']);
        $columnModel = Column::findOne(['id' => Yii::$app->params['config_face_banjia_cn_baike_column_id']]);

        if($columnModel) {
            return $this->render('list', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columnModel' => $columnModel,
            ]);
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }

    /**
     * 百科详情
     * @return string
     */
    public function actionDetail()
    {
        return $this->render('detail');
    }
}
