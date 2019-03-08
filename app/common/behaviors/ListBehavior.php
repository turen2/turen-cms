<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\behaviors;

use Yii;

class ListBehavior extends \yii\base\Behavior
{
    public function columnList($className, $columnId, $listNum = null, $flag = null)
    {
        $query = $className::find()->where(['columnid' => $columnId]);
        if(!empty($flag)) {
            $query->andFilterWhere(['like', 'flag', $flag]);
        }
        $query->orderBy(['orderid' => SORT_DESC]);
        if(!empty($listNum)) {
            $query->limit($listNum);
        }

//        echo $query->createCommand()->getRawSql();exit;

        return $query->asArray()->all();
    }
}