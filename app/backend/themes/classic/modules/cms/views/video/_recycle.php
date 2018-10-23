<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\widgets\ActiveForm;
use app\assets\RecycleAsset;
use yii\helpers\Url;
use app\actions\RecycleAction;

//回收站功能
RecycleAsset::register($this);
?>

<div id="recycle" class="recycle">
    <div class="header">
        <span class="title">视频列表回收站</span>
        <span class="close"><a href="javascript:RecycleHide()"></a></span>
        <div class="cl"></div>
    </div>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'id' => 'form-recycle',
    ]); ?>
        <div class="list"></div>
        <div class="footer">
        <span class="sel">
            <span>选择：</span>
            <a href="javascript:RecycleCheckAll(true);">全部</a> - 
            <a href="javascript:RecycleCheckAll(false);">无</a> - 
            <a href="javascript:;" onclick="RecycleCheck('<?=Url::to(['recycle', 'type' => RecycleAction::RECYCLE_TYPE_RESETALL])?>')">还原</a> - 
            <a href="javascript:;" onclick="RecycleCheck('<?=Url::to(['recycle', 'type' => RecycleAction::RECYCLE_TYPE_DELALL])?>')">删除</a>
        </span>
        <a href="javascript:;" onclick="RecycleEmpty('<?=Url::to(['recycle', 'type' => RecycleAction::RECYCLE_TYPE_EMPTY])?>')" class="btn">清空</a>
        </div>
    <?php ActiveForm::end(); ?>
</div>