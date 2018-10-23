<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\components;

use Yii;
use yii\filters\VerbFilter;
use app\models\cms\Tag;
use yii\web\Response;

class ItemController extends \app\components\Controller
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
    
    /**
     * 全局获取tag标签
     * @param string $query
     * @return []
     */
    public function actionTags($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $items = [];
        $query = urldecode(mb_convert_encoding($query, "UTF-8"));
        foreach (Tag::find()->where(['like', 'name', $query])->asArray()->all() as $tag) {
            $items[] = ['name' => $tag['name']];
        }
        
        return $items;
    }
}