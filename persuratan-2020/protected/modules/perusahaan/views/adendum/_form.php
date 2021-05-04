<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $model->isNewRecord ? $form->textFieldGroup($model,'id_iuphhk',array('groupOptions' => array('class' => 'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'value' => $iuphhk)))) : $form->textFieldGroup($model,'id_iuphhk',array('groupOptions' => array('class' => 'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'nomor_adendum',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>

	<?php echo $form->datePickerGroup($model,'tanggal',array('widgetOptions'=>array('options'=>array('autoclose'=>true, 'format'=>'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span5')), 'append'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>

	<?php echo $form->textFieldGroup($model,'luas',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Simpan' : 'Simpan',
		)); 
		echo ' ';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'danger',
            'size' => 'medium',
            'htmlOptions' => array('class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
            'label' => Yii::t('app', 'Batal'),
        ));
		?>
    </div>
</div>

<?php $this->endWidget(); ?>
