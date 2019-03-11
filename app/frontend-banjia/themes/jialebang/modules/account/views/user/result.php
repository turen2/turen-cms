<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="user-result <?= Html::encode($type) ?>">
        <h1><?= Html::encode($title) ?></h1>
        <p><?= Html::encode($text) ?></p>
    </div>
</div>
