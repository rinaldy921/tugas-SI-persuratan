<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'vertical',
        ));
?>

<?php echo $form->textFieldGroup($model, 'isi', array('widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'maxlength' => 255)))); ?>
<div class="form-group">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('app', ' Cari '),
    ));
    ?>    
</div>
<?php $this->endWidget(); ?>