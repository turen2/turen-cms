<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\models\ext\Nav;
use yii\helpers\Html;

$webUrl = Yii::getAlias('@web/');
?>

<div class="easy-footer container">
    <p class="easy-footer-nav">
        <!-- 底部导航 -->
        <?php
        $menus = Nav::NavById(Yii::$app->params['config_face_cn_bottom_nav_id']);
        $bottomNav = $menus['main'];
        //$subBottomNav = $menus['sub'];

        foreach ($bottomNav as $index => $item) {
            echo Html::a($item->menuname, $item->linkurl, ['target' => $item->target]);
            if($index != count($bottomNav)-1) {
                echo ' |';
            }
        }
        ?>
    </p>
    <p class="easy-footer-c">2016-<?= date('Y') ?> <?= Yii::$app->params['config_copyright'] ?> - <?= Yii::$app->params['config_icp_code'] ?> <a target="_blank" href="http://www.turen2.com">技术支持</a> <span><?php echo number_format( (microtime(true) - YII_BEGIN_TIME), 3) . 's'; ?></span></p>
</div>

<?= $this->render('_fixed_nav') ?>