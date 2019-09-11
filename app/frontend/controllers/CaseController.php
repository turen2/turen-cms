<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\controllers;

use common\helpers\ImageHelper;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\models\cms\Column;
use common\models\cms\Photo;
use common\models\cms\PhotoSearch;

class CaseController extends \app\components\Controller
{
    /**
     * 案例列表/ajax数据流
     * @param int $wallpage 动态加载参数
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionList($wallpage = 1)
    {
        $columnId = Yii::$app->params['config_face_cn_case_column_id'];
        $pageSize = 27;
        $columnModel = Column::findOne(['id' => $columnId]);
        $searchModel = new PhotoSearch();
        if($columnModel) {
            if(Yii::$app->getRequest()->isAjax) {//二次异步请求
                //调整返回正确的数据段
                $prePageSize = ceil($pageSize/3);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $prePageSize, $columnId);
                $oldPage = Yii::$app->getRequest()->get($dataProvider->pagination->pageParam, 1);//getPage取不到，待定？
                $page = ($oldPage-1)*3+$wallpage;//新的开始小单元页面
                $dataProvider->pagination->setPage($page);
                $dataProvider->pagination->setPageSize($prePageSize);
//                $offset = ($oldPage-1)*$oldSize + ($wallpage-1)*$prePageSize;
//                $dataProvider->query->offset($offset)->limit($prePageSize);
//                $models = $dataProvider->query->all();
//                echo $dataProvider->query->createCommand()->rawSql;
//                exit;
                $models = $dataProvider->getModels();
                $arr = [];
                foreach ($models as $index => $model) {
                    $arr[$index]['image'] = empty($model->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($model->picurl, true);
                    $arr[$index]['title'] = $model->title;
                    $arr[$index]['url'] = Url::to(['/case/detail', 'slug' => $model->slug]);
                    $arr[$index]['hits'] = $model->hits;
                    $arr[$index]['width'] = '100';
                    $arr[$index]['height'] = '100';
                    $size = substr($model->picurl, strrpos($model->picurl, '==')+2, (strrpos($model->picurl, '.') - strrpos($model->picurl, '=='))-2);
                    $size = explode('x', $size);
                    if(count($size) == 2) {
                        $arr[$index]['width'] = $size[0];
                        $arr[$index]['height'] = $size[1];
                    }
                }

                return $this->asJson([
                    'state' => true,
                    'code' => '200',
                    'total' => $prePageSize,
                    'result' => $arr,
                ]);
            } else {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $columnId);
                return $this->render('list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'columnModel' => $columnModel,
                ]);
            }
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }

    /**
     * 案例详情
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail($slug)
    {
        $model = $this->findModel($slug);
        //上一条，下一条
        $prevModel = Column::ModelRelated($model, 'prev');
        $nextModel = Column::ModelRelated($model, 'next');//model或null
        return $this->render('detail', [
            'model' => $model,
            'prevModel' => $prevModel,
            'nextModel' => $nextModel,
        ]);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        $model = Photo::find()->current()->andWhere(['slug' => $slug])->one();
        if (!is_null($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在！');
        }
    }
}
