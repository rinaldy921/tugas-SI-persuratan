<?php
$list = CHtml::listData(MasterSistemSilvikultur::model()->findAll(), 'id', 'jenis_silvikultur');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>
<?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldGroup($model, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->select2Group($model, 'id_jenis_silvikultur', array('labelOptions' => array('label' => 'Jenis Sistem Silvikultur'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'palceholder' => 'Pilih Sistem Silvikultur')))); ?>

        <?php // echo $form->textFieldGroup($model, 'sistem_silvikultur', array('groupOptions' => array('id' => 'nama_silvikultur'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

        <?php echo $form->textFieldGroup($model, 'jumlah', array('labelOptions' => array('label' => 'Luas'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)), 'append' => ' Ha ')); ?>
        <p class="help-block">Penulisan koma gunakan titik (.)</p>
        <?php $this->endWidget(); ?>