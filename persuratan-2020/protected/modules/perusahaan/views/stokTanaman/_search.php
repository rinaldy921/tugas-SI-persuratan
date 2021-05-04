<?php
/* @var $this StokTanamanController */
/* @var $model StokTanaman */
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
		<?php echo $form->label($model,'tahun_tanam'); ?>
		<?php echo $form->textField($model,'tahun_tanam',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sektor_id'); ?>
		<?php echo $form->textField($model,'sektor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'blok_id'); ?>
		<?php echo $form->textField($model,'blok_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jumlah_luas'); ?>
		<?php echo $form->textField($model,'jumlah_luas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jenis_lahan'); ?>
		<?php echo $form->textField($model,'jenis_lahan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_perusahaan'); ?>
		<?php echo $form->textField($model,'id_perusahaan'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->