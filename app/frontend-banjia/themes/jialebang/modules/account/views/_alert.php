<?php if($flash = Yii::$app->session->getFlash('info')) { ?>
    <div class="alert alert-info"><i class="iconfont jia-yes_b"></i> <?= $flash ?></div>
<?php } ?>
<?php if($flash = Yii::$app->session->getFlash('success')) { ?>
    <div class="alert alert-success"><i class="iconfont jia-yes_b"></i> <?= $flash ?></div>
<?php } ?>
<?php if($flash = Yii::$app->session->getFlash('warning')) { ?>
    <div class="alert alert-warning"><i class="iconfont jia-caution_b"></i> <?= $flash ?></div>
<?php } ?>
<?php if($flash = Yii::$app->session->getFlash('danger')) { ?>
    <div class="alert alert-danger"><i class="iconfont jia-close_b"></i> <?= $flash ?></div>
<?php } ?>