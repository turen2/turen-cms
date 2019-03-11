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
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Config */
/* @var $form yii\widgets\ActiveForm */

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
        'name' => '基本设置',
        'view' => '_item/_base',
    ],
    [
        'name' => '附件设置',
        'view' => '_item/_addon',
    ],
    [
        'name' => '性能设置',
        'view' => '_item/_power',
    ],
    [
        'name' => '核心设置',
        'view' => '_item/_core',
    ],
    [
        'name' => '界面配置',
        'view' => '_item/_face',
    ],
    [
        'name' => '产品配置',
        'view' => '_item/_prod',
    ],
    [
        'name' => '第三方配置',
        'view' => '_item/_third',
    ],
    [
        'name' => '消息配置',
        'view' => '_item/_msg',
    ],
];

//统计当前数组数量
$configTabNum = count($configTabArr);

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
    			echo '"><a href="javascript:;">'.$configTabText['name'].'</a></li><li class="line">-</li>';	
    		}
    		?>
			<li><a href="<?= Url::to(['create']) ?>">增加新变量</a></li>
    	</ul>
    </div>
    
    <?php 
    $form = ActiveForm::begin([
        'options' => [],
        'method' => 'POST',
        'action' => ['/sys/config/batch'],
    ]);
    
	foreach($configTabArr as $configTabId => $configTabText) {
	?>
	<div class="<?php if($configTabId != 0) echo 'undis'; ?>" id="tabs_content<?php echo $configTabId; ?>">
		<!--使用DIV兼容chrome firefox等浏览器-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table">
			<?php
            echo $this->render($configTabText['view'], [
                'config' => isset($configs[$configTabId])?$configs[$configTabId]:[],
            ]);
			if(isset($configs[$configTabId])) {
    			$i = 1;
    			foreach ($configs[$configTabId] as $row) {
    			    if($row['visible']) {
			    ?>
    				
    			<tr <?php if($i == count($configs)) echo 'class="nb"'; ?>>
    				<td class="first-column"><?php echo $row['varinfo']; ?></td>
    				<td class="second-column" width="33%">
    				<?php
    				//统计代码转义
    				if($row['varname'] == 'config_countcode') {
    					$row['varvalue'] = stripslashes($row['varvalue']);
    				}
    				
    				switch($row['vartype']) {
    					case 'text':
    						echo Html::textInput($row['varname'], $row['varvalue'], ['id' => $row['varname'], 'class' => 'input']);
    					break;
    
    					case 'checkbox':
    					    $default = [];
    					    if(strpos($row['vardefault'], '|') !== false) {
    					        foreach (explode('|', $row['vardefault']) as $name) {
    					            if(strpos($name, '=>') !== false) {
    					                $var = explode('=>', $name);
    					                $default[$var[0]] = $var[1];
    					            } else {
    					                $default[$name] = $name;
    					            }
    					        }
    					    } else {
    					        $default[$row['vardefault'] = $row['vardefault']];
    					    }
    					    
    					    if(strpos($row['varvalue'], '|') !== false) {
    					        $row['varvalue'] = explode('|', $row['varvalue']);
    					    } else {
    					        $row['varvalue'] = [$row['varvalue']];
    					    }
    					    
    					    echo Html::checkboxList($row['varname'], $row['varvalue'], $default, ['id' => $row['varname'], 'separator' => '&nbsp;&nbsp;&nbsp;']);
					    break;
    					    
    					case 'radio':
    					    $default = [];
    					    if(strpos($row['vardefault'], '|') !== false) {
    					        foreach (explode('|', $row['vardefault']) as $name) {
    					            if(strpos($name, '=>') !== false) {
    					                $var = explode('=>', $name);
    					                $default[$var[0]] = $var[1];
    					            } else {
    					                $default[$name] = $name;
    					            }
    					        }
    					    } else {
    					        $default[$row['vardefault'] = $row['vardefault']];
    					    }
    					    
    					    echo Html::radioList($row['varname'], $row['varvalue'], $default, ['id' => $row['varname'], 'separator' => '&nbsp;&nbsp;&nbsp;']);
					    break;
					    
    					case 'select':
    					    $default = [];
    					    if(strpos($row['vardefault'], '|') !== false) {
    					        foreach (explode('|', $row['vardefault']) as $name) {
    					            if(strpos($name, '=>') !== false) {
    					                $var = explode('=>', $name);
    					                $default[$var[0]] = $var[1];
    					            } else {
    					                $default[$name] = $name;
    					            }
    					        }
    					    } else {
    					        $default[$row['vardefault'] = $row['vardefault']];
    					    }
    					    
    					    echo Html::dropDownList($row['varname'], $row['varvalue'], $default, ['id' => $row['varname']]);
    					    break;
    
    					case 'textarea':
    					    echo Html::textarea($row['varname'], htmlspecialchars($row['varvalue']), ['id' => $row['varname'], 'class' => 'textarea']);
    					break;
    
    					default:
    					echo '没有获取到类型';
    					break;
    				}
    				?>
    				</td>
    				<td style="border-bottom: 1px dashed #efefef;">
    					[<?php echo $row['orderid']; ?>] Yii::$app->params['<?php echo $row['varname']; ?>']
    				</td>
    			</tr>
    				<?php } ?>
    			<?php } ?>
			<?php } else { ?>
				<tr>
    				<td class="first-column"></td>
    				<td class="second-column" width="33%"></td>
    				<td style="border-bottom: 1px dashed #efefef;"></td>
				</tr>
			<?php } ?>
			<?php $i++; ?>
			<tr class="nb">
				<td></td>
				<td>
    				<div class="form-sub-btn">
    					<input type="submit" class="submit" value="提交" />
    					<input type="button" class="back" value="返回" onclick="location.href='<?= Url::to(['/sys/config/setting']) ?>'" />
    				</div>
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
</div>