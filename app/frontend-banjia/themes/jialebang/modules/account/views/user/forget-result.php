<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\models\user\User;
use yii\helpers\Html;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="user-result <?= Html::encode($type) ?>">
        <?= $this->render('_step', ['point' => $point]) ?>
        <div class="fpass-content">
            <h3><span class="fpass-title"><?= Html::encode($this->title) ?></span></h3>
            <div class="fpass-case">
                <div class="fpass-detais">
                    <p><?= Html::encode($text) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>