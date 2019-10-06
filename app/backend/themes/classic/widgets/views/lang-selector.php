<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
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
