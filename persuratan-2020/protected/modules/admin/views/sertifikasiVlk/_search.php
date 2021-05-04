<?php
/* @var $this SertifikasiVlkController */
/* @var $model SertifikasiVlk */
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
		<?php echo $form->label($model,'nomor'); ?>
		<?php echo $form->textField($model,'nomor',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'berlaku'); ?>
		<?php echo $form->textField($model,'berlaku'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'berakhir'); ?>
		<?php echo $form->textField($model,'berakhir'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'penerbit'); ?>
		<?php echo $form->textField($model,'penerbit',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_penerbit'); ?>
		<?php echo $form->textField($model,'id_penerbit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'predikat'); ?>
		<?php echo $form->textField($model,'predikat',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_doc'); ?>
		<?php echo $form->textField($model,'file_doc',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tanggal'); ?>
		<?php echo $form->textField($model,'tanggal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_verified'); ?>
		<?php echo $form->textField($model,'is_verified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->