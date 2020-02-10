<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/9
 * Time: 12:02
 */

use common\tools\share\ShareWidget;
?>

<div class="manual-sidebox card" style="overflow: visible;">
    <div class="manual-sidebox-title">
        <h3><?= $title ?></h3>
    </div>
    <div class="manual-sidebox-tab">
        <?= ShareWidget::widget([
            'title' => '',
            'images' => $images,
        ]);
        ?>
    </div>
</div>