<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/15
 * Time: 12:35
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JqueryAsset;

JqueryAsset::register($this);

$jsonData = Json::encode($province);
$citiesData = Json::encode($cities);
$ipAddressUrl = Url::to(['site/ip-address']);
$js = <<<EOF
var cities = {$citiesData};
var province = {$jsonData};
//返回市下面的区
function area(city)
{
    var areaes = new Array();
    var i = 0;
    for (var key in province) {
        if(key == city) {
             for (var key1 in province[key]) {
                areaes[i] = key1;
                i++;
             }
        }
    }
    
    return areaes;
}

//返回区下面的街道
function street(area)
{
    var streetes = new Array();
    for (var key in province) {
         for (var key1 in province[key]) {
            if(key1 == area) {
                streetes[key1] = province[key][key1];
            }
         }
    }
    
    return streetes[area];
}

//console.log(area('深圳市'));
//console.log(street('龙华区'));
//联级操作
$("select[name='{$formId}[city]']").on('change', function() {
    $("select[name='{$formId}[street]']").html('<option value="">请选择街道</option>');
    var str1 = '<option value="">请选择城区</option>';
    var areaes1 = area($(this).val());
    for (var area1 in areaes1) {
        str1 += '<option value="'+areaes1[area1]+'">'+areaes1[area1]+'</option>';
    }
    $("select[name='{$formId}[area]']").html(str1);
});
$("select[name='{$formId}[area]']").on('change', function() {
    var str2 = '<option value="">请选择街道</option>';
    var areaes2 = street($(this).val());
    for (var area2 in areaes2) {
        str2 += '<option value="'+areaes2[area2]+'">'+areaes2[area2]+'</option>';
    }
    $("select[name='{$formId}[street]']").html(str2);
});

//初始化
$.ajax({
    type: "GET",
    url: "{$ipAddressUrl}",
    dataType: "json",
    success: function(data) {
        if(data.state) {
            var location = data.msg.location;
            if($("select[name='{$formId}[city]']").val() == '' && $("select[name='{$formId}[area]']").val() == '' && $("select[name='{$formId}[street]']").val() == '') {
                for (var ii in cities) {
                    if(location.indexOf(cities[ii].slice(0, cities[ii].length-1)) >= 0){//搜索与匹配
                        $("select[name='{$formId}[city]']").val(cities[ii]).change();
                    }
                }
            }
        }
    }
});
EOF;
$this->registerJs($js);
?>

<?= Html::dropDownList($formId.'[city]', null, ArrayHelper::merge([null => '请选择城市'], $cities), ['class' => 'city']) ?>
<?= Html::dropDownList($formId.'[area]', null, [null => '请选择城区'], ['class' => 'area']) ?>
<?= Html::dropDownList($formId.'[street]', null, [null => '请选择街道'], ['class' => 'street']) ?>