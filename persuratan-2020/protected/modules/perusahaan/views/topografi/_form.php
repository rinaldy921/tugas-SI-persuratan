<div class="panel panel-info">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<div class="panel-body">
<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model, 'id_iuphhk', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'col-md-8', 'value' => Yii::app()->user->idIuphhk())))); ?>

	<?php echo $form->textFieldGroup($model,'datar',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')),'append'=>'Ha')); ?>

	<?php echo $form->textFieldGroup($model,'landai',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')),'append'=>'Ha')); ?>

	<?php echo $form->textFieldGroup($model,'agak_curam',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')),'append'=>'Ha')); ?>

	<?php echo $form->textFieldGroup($model,'curam',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')),'append'=>'Ha')); ?>

	<?php echo $form->textFieldGroup($model,'sangat_curam',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')),'append'=>'Ha')); ?>

	<?php echo $form->textFieldGroup($model,'ketinggian',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')),'append'=>'dpl')); ?>
</div>    
    <div class="panel-footer">
<!-- <div class="form-group"> -->
    <div class="col-sm-3"></div>
    <!-- <div class="col-sm-9"> -->
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
    <!-- </div> -->
</div>

<?php $this->endWidget(); ?>
</div>