<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><?= "<?= " ?>Html::encode($this->title) ?> <small>
                    <?= "<?php " ?>if (isset($this->params['breadcrumbs'])) {
                        $params = [
                            'tag' => 'ol',
                            'encodeLabels' => true, // 转义
                            'homeLink' => [
                                'label' => <?= $generator->generateString('Home') ?>,
                                'url' => ['index']
                            ],
                            'links' => $this->params['breadcrumbs'],
                        ];
                        
                        echo Breadcrumbs::widget($params);
                    }
                    ?>
                    </small></h5>
                    
                    <div class="ibox-tools">
                    	<a href=<?= Url::to(['index']) ?> class="btn btn-outline btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="返回到上一级"><i class="fa fa-reply" aria-hidden="true"></i> 返回</a>
                        <a href="javascript: location.reload();" class="btn btn-outline btn-success btn-xs">刷新</a>
                    </div>
                </div>
                <div class="ibox-content">
                <p>
                    <?= "<?= " ?>Html::a('<i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 返回', ['index'], ['class' => 'btn btn-default btn-rounded return btn-sm']) ?>
                    <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => <?= $generator->generateString('您确认要删除吗？') ?>,
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= "<?= " ?>Html::a(<?= $generator->generateString('Create') ?>, ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                </p>
            
                <?= "<?= " ?>DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            /*
                            [
                                //'attribute' => 'country.name',//可以直接联表
                                //'label' => 'Belong Country',//修改label标签
                                //ArrayHelper::getValue($this->model, $attributeName);//获取指定属性值的方法
                                //'value' => function($model, $_this) {return $value;},//匿名函数获取值
                                //'format' => 'text',//指定格式化
                                //'status' => true,//是否显示
                            ],
                            */
                <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                    echo "                              '" . $name . "',\n";
                    }
                } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                    echo "                            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }
                ?>
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>