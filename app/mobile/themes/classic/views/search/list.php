<?php

use yii\helpers\Url;

$this->title = '搜索列表';

$css = <<<EOF1

EOF1;
$this->registerCss($css);

$js = <<<EOF2
    // 
EOF2;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');
?>

<form method="post" id="formsearch" name="formsearch" action="" class="zxd-form weixin-form">
    <div class="searchresult-header">
        <div class="search-box">
            <input type="search" name="keyword" id="keyword" value="" placeholder="输入关键词">
            <img class="search-tip" src="<?= $webUrl ?>images/yaqiao/index-search.png">
            <span class="search-false"><img src="<?= $webUrl ?>images/yaqiao/false.png"></span>
        </div>
        <a class="search-cancle" href="<?= Url::home() ?>">取消</a>
    </div>
</form>

<div class="maintab main-result">
    <ul>
        <li id="meitu" class="maintab-color">
            <a href="javascript:;"><span></span>
                <p>案例</p>
            </a>
        </li>
        <li id="article">
            <a href="javascript:;"><span></span>
                <p>动态</p>
            </a>
        </li>
        <li id="ask">
            <a href="javascript:;"><span></span>
                <p>问答</p>
            </a>
        </li>
    </ul>
</div>

<div class="myblack clear" style="margin-top: 2rem;"></div>

<?php // echo $this->render('_article') ?>
<?php // echo $this->render('_ask') ?>
<?php echo $this->render('_photo') ?>























