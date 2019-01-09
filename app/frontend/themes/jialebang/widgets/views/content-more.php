<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/9
 * Time: 16:57
 */

use common\helpers\Functions;
use yii\helpers\Url;

?>

<?php if($boxlist) {?>
<div class="detail-box <?= $htmlClass ?>">
    <h5>
        <b><?= $title ?></b>
        <?php if($moreLink) { ?>
            <a target="_blank" href="<?= $moreLink ?>">更多</a>
        <?php } ?>
    </h5>
    <ul>
        <?php
        foreach ($boxlist as $index => $item) {
            $route['slug'] = $item['slug'];
            echo '<li class="'.(($index+1 == count($boxlist))?'no-border':'').'">'.
                '<a href="'.Url::to($route).'">'.$item['title'].'</a>'.
                '<b>'.Functions::toTime($item['posttime']).'</b>'.
                '</li>';
        }
        ?>
    </ul>
</div>
<?php } ?>