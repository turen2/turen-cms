<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\components\View;
use app\widgets\Tips;
use app\models\sys\Config;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Config */
/* @var $form yii\widgets\ActiveForm */

$this->title = '界面绑定';

$js = <<<EOF
function tabs(tabobj, obj)
{
	$("#"+tabobj+" li[id^="+tabobj+"]").each(function(i){
		if(tabobj+"_title"+i == obj.id)
		{
			$("#"+tabobj+"_title"+i).attr("class","on");
			$("#"+tabobj+"_content"+i).show();
		}
		else
		{
			$("#"+tabobj+"_title"+i).attr("class","");
			$("#"+tabobj+"_content"+i).hide();
		}
	});
}
EOF;
$this->registerJs($js, View::POS_END);

//设置选项卡项
$configTabArr = [
    [
        'name' => '菜单绑定',
        'view' => '_item/_nav',
    ],
    [
        'name' => '栏目绑定',
        'view' => '_item/_column',
    ],
    [
        'name' => '单页绑定',
        'view' => '_item/_page',
    ],
    [
        'name' => '类别绑定',
        'view' => '_item/_cate',
    ],
    [
        'name' => '友链绑定',
        'view' => '_item/_link',
    ],
    [
        'name' => '碎片绑定',
        'view' => '_item/_block',
    ],
];

//统计当前数组数量
echo Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]);
?>

<div class="config-form">
	<div class="toolbar-tab">
    	<ul id="tabs">
    		<?php
    		foreach($configTabArr as $configTabId => $configTabText)
    		{
    			echo '<li id="tabs_title'.$configTabId.'" onclick="tabs(\'tabs\',this);" class="';
    			if($configTabId == 0) echo 'on';
    			echo '"><a href="javascript:;">'.$configTabText['name'].'</a></li>';
    			if($configTabId + 1 < count($configTabArr)) {
    			    echo '<li class="line">-</li>';
    			}
    		}
    		?>
    	</ul>
    </div>
    
    <?php 
    $form = ActiveForm::begin([
        'options' => [],
        'method' => 'POST',
        'action' => ['/site/face-config/batch'],
    ]);
    
	foreach($configTabArr as $configTabId => $configTabText) {
	?>
	<div class="<?php if($configTabId != 0) echo 'undis'; ?>" id="tabs_content<?php echo $configTabId; ?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table">
			<?php
			if(isset($configs[$configTabId])) {
			    echo $this->render($configTabText['view'], [
			        'config' => $configs[$configTabId],
			    ]);
			    ?>
			<?php } ?>
			<tr class="nb">
				<td></td>
				<td>
    				<div class="form-sub-btn">
    					<input type="submit" class="submit" value="提交" />
    					<input type="button" class="back" value="返回" onclick="location.href='<?= Url::to(['/site/face-config/setting']) ?>'" />
    				</div>
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
</div>