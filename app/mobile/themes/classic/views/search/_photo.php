<?php

$webUrl = Yii::getAlias('@web/');
?>

<div class="search-photo" style="display: block;">
    <ul>
        <li class="photo1">
            <a href="#">
                <p>搜索功能测试中<font>搜索</font>搜索功能测试中  搜索功能测试中<font>搜索</font>搜索功能测试中</p>
                <dl class="photo1-pic">
                    <dd><img src="<?= $webUrl ?>images/nopic.jpg"></dd>
                    <dd><img src="<?= $webUrl ?>images/nopic.jpg"></dd>
                </dl>
                <h5>
                    <b>资讯中心</b>
                    <b><i></i></b>
                    <b>阅读860</b>
                </h5>
            </a>
        </li>
    </ul>
    <div data-role="widget-pagination">
        <a class="widget-pagination-disable">上一页</a>
        <div>
            <a class="widget-pagination-current-page" href="#">1/1</a>
        </div>
        <a href="#">下一页</a>
    </div>
</div>