<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\cms\Column;
use app\models\cms\Info;

return;

$infoArray = Info::find()->alias('i')->select(['c.cname', 'i.id as info_id'])->leftJoin(Column::tableName().' as c', 'c.id = i.columnid')->asArray()->all();
?>
