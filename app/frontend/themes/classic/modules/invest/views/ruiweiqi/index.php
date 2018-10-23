<?php
use yii\helpers\Url;
$this->title = "瑞薇琪问卷调查";
$this->registerJs($this->render('_script.js'));
$this->registerCss($this->render('_css.css'));
?>
<input type="hidden" class="problem" value="<?= Url::to(['ruiweiqi/getproblem'])?>">
<input type="hidden" class="post-problem" value="<?= Url::to(['ruiweiqi/postproblem'])?>">
<div class="main">
	<div class="row">
		<div class="col-xs-12 zhuti">

		</div>
	</div>
</div>
