<?php
/* @var $this LaporanKeuanganController */
/* @var $model IuphhkLaporanKeuangan */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'iuphhk-laporan-keuangan-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_perusahaan'); ?>
		<?php echo $form->textField($model,'id_perusahaan'); ?>
		<?php echo $form->error($model,'id_perusahaan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tahun'); ?>
		<?php echo $form->textField($model,'tahun',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'tahun'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nilai_perolehan'); ?>
		<?php echo $form->textField($model,'nilai_perolehan'); ?>
		<?php echo $form->error($model,'nilai_perolehan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nilai_buku'); ?>
		<?php echo $form->textField($model,'nilai_buku'); ?>
		<?php echo $form->error($model,'nilai_buku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_aset'); ?>
		<?php echo $form->textField($model,'total_aset'); ?>
		<?php echo $form->error($model,'total_aset'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->