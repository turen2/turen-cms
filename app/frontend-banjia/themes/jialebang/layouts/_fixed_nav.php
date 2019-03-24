<?php

use yii\helpers\Url;

?>
<div class="fixed-nav">
    <ul>
        <li class="contact-qq tbs-contact-qq" id="onlineService">
            <a target="_blank" href="javascript:;">
                <span class="s1"><span class="point"></span></span><i>在线预约</i>
            </a>
        </li>
        <li class="sub-encode">
            <a href="javascript:;"><span class="s2"></span><i>手机浏览</i></a>
            <ul class="encode">
                <li><span class="wap"><img src="/images/qr/qrcode2.png" /></span><b>手机浏览</b><p>在线下单立享9折</p></li>
            </ul>
        </li>
        <li class="hide"><a href="javascript:;" class="alert-design right-design">
            <span class="s3"></span><i>免费方案</i></a>
        </li>
        <li class=""><a href="<?= Url::to(['calculator/index']) ?>" class="alert-design right-offer">
            <span class="s4"></span><i>自助计价</i></a>
        </li>
        <li class="back-top">
            <a href="javascript:turen.com.scrollTop(500);"><span class="s5"></span><i>回到顶部</i></a>
        </li>
    </ul>
</div>