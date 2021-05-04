<?php
/* @var $this IuphhkTenagaKerjaController */
/* @var $model IuphhkTenagaKerja */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_perusahaan'); ?>
		<?php echo $form->textField($model,'id_perusahaan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_jenis_tenaga_kerja'); ?>
		<?php echo $form->textField($model,'id_jenis_tenaga_kerja'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_kualifikasi'); ?>
		<?php echo $form->textField($model,'id_kualifikasi'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_pendidikan'); ?>
		<?php echo $form->textField($model,'id_pendidikan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nama'); ?>
		<?php echo $form->textField($model,'nama',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'no_sertifikat'); ?>
		<?php echo $form->textField($model,'no_sertifikat',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tgl_awal_sertifikat'); ?>
		<?php echo $form->textField($model,'tgl_awal_sertifikat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tgl_akhir_sertifikat'); ?>
		<?php echo $form->textField($model,'tgl_akhir_sertifikat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_aktif'); ?>
		<?php echo $form->textField($model,'is_aktif',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->