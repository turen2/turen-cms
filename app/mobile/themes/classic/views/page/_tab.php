<?php

use common\models\ext\Nav;
use yii\helpers\Url;

$js = <<<EOF
    // 
EOF;
$this->registerJs($js);

$naves = Nav::find()->active()->andWhere(['parentid' => Yii::$app->params['config_face_mobile_cn_about_nav_id']])->orderBy(['orderid' => SORT_DESC])->asArray()->all();

$route = [Yii::$app->controller->route];
if(!empty($slug)) {
    $route['slug'] = $slug;
}
$currentUrl = Url::to($route);

$count = count($naves);

//var_dump($count);exit;
?>
<div class="about-tab">
    <ul>
        <?php foreach ($naves as $index => $nav) { ?>
            <li data-current="<?= $currentUrl ?>" class="info-nav <?= ($currentUrl == $nav['linkurl'])?'about-color':'' ?>" style="flex: 1;"><a href="<?= $nav['linkurl'] ?>"><?= $nav['menuname'] ?><span></span></a></li>
            <?php if($count != ($index + 1)) { ?>
            <li><i></i></li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
