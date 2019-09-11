<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\models\ext\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$navArray = ArrayHelper::map(Nav::find()->current()->where(['parentid' => Nav::TOP_ID])->orderBy(['orderid' => SORT_DESC])->asArray()->all(), 'id', 'menuname');
?>

绑定菜单


