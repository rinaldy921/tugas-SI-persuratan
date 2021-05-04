<?php
/* @var $this LaporanKeuanganController */
/* @var $model IuphhkLaporanKeuangan */
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
		<?php echo $form->label($model,'tahun'); ?>
		<?php echo $form->textField($model,'tahun',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nilai_perolehan'); ?>
		<?php echo $form->textField($model,'nilai_perolehan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nilai_buku'); ?>
		<?php echo $form->textField($model,'nilai_buku'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_aset'); ?>
		<?php echo $form->textField($model,'total_aset'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->