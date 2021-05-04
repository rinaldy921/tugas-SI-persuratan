<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); 
$crit = array(
	'select' => 'id_kabupaten, nama, provinsi_id'
);
$list = CHtml::listData(Kabupaten::model()->findAll($crit), 'id_kabupaten', function($data) {
	return CHtml::encode($data->nama.' / '. $data->kabupatenProvinsi->nama);
});
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->select2Group($model, 'kabupaten_id', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "prov"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kabupaten...'))))); ?>
	<?php //echo $form->select2Group($model, 'kabupaten_id', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "kab"), 'widgetOptions' => array('asDropDownList' => false, 'options' => array('allowClear' => true, 'data' => 'js: function() { return {results: kab}; }'), 'data' => null, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kabupaten/Kota'))))); ?>
	<?php //echo $form->select2Group($model, 'kabupaten_id', array('groupOptions' => array('id' => "kab"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kabupaten..'))))); ?>
	<?php //echo $form->textFieldGroup($model,'kabupaten_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>4)))); ?>

	<?php echo $form->textFieldGroup($model,'nama',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Tambah' : 'Simpan',
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
