<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
));?>
<?php echo $form->hiddenField($modelRealisasi,'id'); ?>
<?php echo $form->hiddenField($modelRealisasi,'id_bulan'); ?>
<?php echo $form->hiddenField($modelRealisasi,'tahun'); ?>
<?php echo $form->dropDownListGroup($modelRealisasi, 'id_rkt_konflik_sosial', array(
    'enableAjaxValidation' => false,
    'widgetOptions' => array(
        'data' => $jenis_konflik,
        'htmlOptions' => array(
            'empty' => Yii::t('app', 'Pilih Jenis...'),
            'maxlength' => 4
        )
    )
)); ?>
<?php echo $form->textAreaGroup($modelRealisasi,'penanganan',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>5)))); ?>
<?php echo $form->textFieldGroup($modelRealisasi, 'status', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
<?php echo $form->textFieldGroup($modelRealisasi, 'persentase', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'class' => 'span2',
            'maxlength' => 50
        )
    )
)); ?>
<?php $this->endWidget(); ?>
