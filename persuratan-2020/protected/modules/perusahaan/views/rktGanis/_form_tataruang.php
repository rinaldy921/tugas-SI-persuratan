<h4 class="page-header">Kawasan Lindung</h4>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> 'tata-ruang-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'id_rkt',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$idRkt)))); ?>

	<?php echo $form->textFieldGroup($model,'id_blok',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

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