<?php
/* @var $this RkuSektorController */
/* @var $model RkuSektor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rku-sektor-rkuSektor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_rku'); ?>
		<?php echo $form->textField($model,'id_rku'); ?>
		<?php echo $form->error($model,'id_rku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_rku_blok'); ?>
		<?php echo $form->textField($model,'id_rku_blok'); ?>
		<?php echo $form->error($model,'id_rku_blok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nama_sektor'); ?>
		<?php echo $form->textField($model,'nama_sektor'); ?>
		<?php echo $form->error($model,'nama_sektor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc'); ?>
		<?php echo $form->textField($model,'desc'); ?>
		<?php echo $form->error($model,'desc'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->