<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); 
$jenisbatas = CHtml::listData(MasterJenisBatas::model()->findAll(array('select' => 'id, jenis_batas')), 'id', 'jenis_batas');
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'id_rkt',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'value'=>$idRkt)))); ?>

	<?php //echo $form->textFieldGroup($model,'id_jenis_batas',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php echo $form->select2Group($model, 'id_jenis_batas', array('enableAjaxValidation' => false, 'widgetOptions' => array('data' => $jenisbatas, 'htmlOptions' => array('empty' => Yii::t('app', 'Pilih Jenis...'), 'maxlength' => 4)))); ?>

	<?php echo $form->textFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'realisasi',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
