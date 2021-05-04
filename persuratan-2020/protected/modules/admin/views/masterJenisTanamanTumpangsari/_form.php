<?php
/* @var $this MasterJenisTanamanTumpangsariController */
/* @var $model MasterJenisTanamanTumpangsari */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => Yii::app()->controller->id . '-form',
                    'type' => 'horizontal',
                    'enableClientValidation' => true,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                    ),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'enableAjaxValidation' => false,
                        ));
?>


	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model, 'nama', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>


	<div class="row buttons" >
		<?php echo CHtml::submitButton(Yii::t('app', 'Simpan')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->