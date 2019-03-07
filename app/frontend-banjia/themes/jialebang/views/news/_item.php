<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\models\cms\Tag;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

//默认参数：$model, $key, $index, $widget
//Html::encode($model->title)
$length = 28;//标题截取长度
$dlength = 82;
$link = Url::to(['/news/detail', 'slug' => $model->slug]);
?>

<?php if(!empty($model->picurl)) { ?>
    <div class="list-img">
        <a href="<?= $link ?>">
            <img src="<?= Yii::$app->aliyunoss->getObjectUrl($model->picurl, true) ?>" />
        </a>
    </div>
<?php } else {
    $dlength = 120;
} ?>

<div class="turen-text">
    <h5>
        <?php
        $options = ['style' => ''];
        if(!empty($model->colorval) || !empty($model->boldval)) {
            Html::addCssStyle($options, ['color' => $model->colorval, 'font-weight' => $model->boldval]);
        }
        echo Html::a(StringHelper::truncate($model->title, $length), $link, ['class' => 'textname', 'title' => $model->title, 'style' => $options['style']]);
        ?>

        <ol>
        <?php
        $tags = Tag::TagList('Article', $model->id);
        if($tags) {
            foreach ($tags as $tag) {
                echo '<li><a target="_blank" href="'.Url::to(['/tag/list', 'type' => 'article', 'name' => trim($tag['name'])]).'">'.$tag['name'].'</a></li>';
            }
        }
        ?>
        </ol>
    </h5>
    <p>
        <?php
        if(empty($model->description)) {
            $des = $model->content;//去除图片链接
        } else {
            $des = $model->description;
        }
        echo StringHelper::truncate(strip_tags($des), $dlength);
        ?>
    </p>
    <dl>
        <dd><i class="fa fa-clock-o"></i><b><?= Yii::$app->getFormatter()->asDateTime($model->posttime, 'php:m月d日 H:i') ?></b></dd>
        <dd><i class="fa fa-eye"></i><b style="color: #888;"><?= $model->hits ?></b></dd>
    </dl>
</div>