<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @author jorry
 */
?>

<?php $form = ActiveForm::begin([
    'id' => 'lang-selector', 
    'options' => [
        'name' => 'form1',
        'onChange' => 'document.form1.submit()',
    ],
]); ?>

    <?= Html::dropDownList('lang', $selection, $items) ?>
    
<?php ActiveForm::end(); ?>
