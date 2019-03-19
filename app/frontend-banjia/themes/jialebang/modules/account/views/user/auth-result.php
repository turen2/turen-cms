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

$url = Yii::$app->getUser()->getReturnUrl();
$second = 6;
//倒计时跳转动作
$js = <<<EOF
var text = $('#result-text');
//走时间
function fn(i){
    if(!i) i = {$second};
    --i;
    text.find('.second').html(i);
    if(i > 0) {
        setTimeout(fn, 1000, i);
    } else {
        location.href = '{$url}';
    }
}
fn();
EOF;

$this->registerJs($js);
?>
<div class="container">
    <div class="user-result">
        <div class="fpass-content">
            <h3><span class="fpass-title"><?= Html::encode($this->title) ?></span></h3>
            <div class="fpass-case">
                <div class="fpass-detais">
                    <div class="result-text">
                        <p><?= Html::encode($text) ?></p>
                        <p id="result-text"><span class="second"><?= $second?></span> 秒后将返回至<?= Html::a('目标页面', $url)?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>