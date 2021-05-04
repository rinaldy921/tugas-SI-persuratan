<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
));
$ganis = CHtml::listData(MasterJenisGanis::model()->findAll(array('select' => 'id, nama_jenis')), 'id', 'nama_jenis');
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'id_rkt',array('groupOptions' => array('class' => 'hidden'),'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'value' => $idRkt)))); ?>

	<?php //echo $form->textFieldGroup($model,'id_ganis',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php echo $form->select2Group($model, 'id_ganis', array('enableAjaxValidation' => false, 'widgetOptions' => array('data' => $ganis, 'htmlOptions' => array('empty' => Yii::t('app', 'Pilih Jenis...'), 'maxlength' => 4)))); ?>

	<?php echo $form->textFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'realisasi',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', 
		array(
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
