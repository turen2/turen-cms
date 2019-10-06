<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Url;

$this->title = '工单详情';
?>
<div class="user-center">
    <div class="container clearfix">
        <?= $this->render('../_account_sidebox') ?>
        <div class="user-content card info">
            <div class="user-content-head">
                <div class="title"><?= $this->title ?><a href="<?= Url::to(['/account/ticket/list']) ?>" class="primary-btn br5 fr">返回列表</a></div>
            </div>
            <div class="user-content-body">
                <div class="tk-head">
                    <h6>工单问题：</h6>
                    <p>问题标题：xxx</p>
                    <div class="tk-files">图片列表</div>
                    <p>
                        <span class="">工单编号：</span> xxxxx
                        <span class="">提交账户：</span>jorry2008
                        <span class="">提交时间：</span>2019-08-01 12：02：01
                        <span class="">状态：</span><span class="">待您评论</span>
                    </p>
                </div>
                <div class="tk-content">
                    <h6>互动内容</h6>
                    <ul class="">
                        <li class="tk-admin">
                            <div class="tk-avatar">头像</div>
                            <p>xia***@163.com：描述</p>
                            <div class="">图片列表</div>
                            <span>发布时间：2018-05-22 15:20:10</span>
                        </li>
                        <li class="tk-user">
                            <div class="tk-avatar">头像</div>
                            <p>xia***@163.com：描述</p>
                            <div class="">图片列表</div>
                            <span>发布时间：2018-05-22 15:20:10</span>
                        </li>
                        <li class="tk-admin">
                            <div class="tk-avatar">头像</div>
                            <p>xia***@163.com：描述</p>
                            <div class="">图片列表</div>
                            <span>发布时间：2018-05-22 15:20:10</span>
                        </li>
                        <li class="tk-user">
                            <div class="tk-avatar">头像</div>
                            <p>xia***@163.com：描述</p>
                            <div class="">图片列表</div>
                            <span>发布时间：2018-05-22 15:20:10</span>
                        </li>
                        <li class="tk-admin">
                            <div class="tk-avatar">头像</div>
                            <p>xia***@163.com：描述</p>
                            <div class="">图片列表</div>
                            <span>发布时间：2018-05-22 15:20:10</span>
                        </li>
                        <li class="tk-user">
                            <div class="tk-avatar">头像</div>
                            <p>xia***@163.com：描述</p>
                            <div class="">图片列表</div>
                            <span>发布时间：2018-05-22 15:20:10</span>
                        </li>
                    </ul>
                </div>
                <div class="tk-comment">
                    <h6>您的评论</h6>
                    <p>xxxxx</p>
                </div>
            </div>
        </div>
    </div>
</div>



