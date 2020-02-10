<?php

use common\models\ext\Nav;
use yii\helpers\Url;

$js = <<<EOF
$(".aboutnav .info-nav").hover(
  function () {
    $(this).addClass("on");
  },
  function () {
    $(this).removeClass("on");
  }
);
EOF;
$this->registerJs($js);

$naves = Nav::find()->active()->andWhere(['parentid' => Yii::$app->params['config_face_cn_about_us_nav_id']])->orderBy(['orderid' => SORT_DESC])->asArray()->all();

$route = [Yii::$app->controller->route];
if(!empty($slug)) {
    $route['slug'] = $slug;
}
$currentUrl = Url::to($route);
?>

<div class="aboutnav">
    <ul>
        <?php foreach ($naves as $nav) { ?>
        <li data-current="<?= $currentUrl ?>" class="info-nav <?= ($currentUrl == $nav['linkurl'])?'current':'' ?>"><a href="<?= $nav['linkurl'] ?>"><?= $nav['menuname'] ?></a></li>
        <?php } ?>
    </ul>
</div>