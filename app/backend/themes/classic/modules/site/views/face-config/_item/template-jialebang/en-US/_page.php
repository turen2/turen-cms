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

$infoArray = Column::find()->alias('c')->select(['c.cname', 'i.id as info_id'])->leftJoin(Info::tableName().' as i', 'c.id = i.columnid')->asArray()->all();
?>

绑定页面
