<div class="panel panel-info">
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-pemerintahan-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
$select = Provinsi::model()->findAll();
$list = CHtml::listData($select, 'id_provinsi', 'nama');
?>
<div class="panel-body">
<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php //echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'id_iuphhk', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'col-md-8')))); ?>

<?php echo $form->select2Group($model, 'provinsi', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "prov"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Provinsi'))))); ?>

<?php echo $form->select2Group($model, 'kabupaten', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "kab"), 'widgetOptions' => array('asDropDownList' => false, 'options' => array('allowClear' => true, 'data' => 'js: function() { return {results: kab}; }'), 'data' => null, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kabupaten/Kota'))))); ?>

<?php echo $form->select2Group($model, 'kecamatan', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "kec"), 'widgetOptions' => array('asDropDownList' => false, 'options' => array('allowClear' => true, 'data' => 'js: function() { return {results: kec}; }'), 'data' => null, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kecamatan'))))); ?>

<?php //echo $form->textFieldGroup($model, 'provinsi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 2)))); ?>

<?php // echo $form->textFieldGroup($model, 'kabupaten', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 4)))); ?>

<?php // echo $form->textFieldGroup($model, 'kecamatan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 6)))); ?>
</div>
    <div class="panel-footer">

<!-- <div class="form-group"> -->
    <div class="col-sm-3"></div>
    <!-- <div class="col-sm-9"> -->
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Simpan' : 'Simpan',
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
<!--     </div>
</div> -->
</div>

<?php $this->endWidget(); ?>
<?php
$js_kab = (!$model->isNewrecord) ? "var kab = " . CJSON::encode($data['oldkab']) . ";" : "var kab = [];";
$js_kec = (!$model->isNewrecord) ? "var kec = " . CJSON::encode($data['oldkec']) . ";" : "var kec = [];";
Yii::app()->getClientScript()->registerScript("reg_data_1", $js_kab, CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerScript("reg_data_2", $js_kec, CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerScript("pick_prov", "
var pv = $('#AdmPemerintahan_provinsi').value;
var ph_kab = $('#AdmPemerintahan_kabupaten').attr('placeholder');
var ph_kec = $('#AdmPemerintahan_kecamatan').attr('placeholder');
$('#AdmPemerintahan_provinsi').change(function() {
    var prov = this.value;
    if (prov != pv) {
        pv = this.value;
        $('#AdmPemerintahan_kabupaten').attr('readonly',false);
        $('#kab').find('.select2-allowclear').removeClass('select2-allowclear');
        $('#kab').find('.select2-chosen').empty().addClass('select2-default').html(ph_kab);
        $('#AdmPemerintahan_kecamatan').attr('readonly',true);
        $('#kec').find('.select2-allowclear').removeClass('select2-allowclear');
        $('#kec').find('.select2-chosen').empty().addClass('select2-default').html(ph_kec);
    }
    if (prov != '') {
        var url = '" . Yii::app()->createUrl('/perusahaan/' . Yii::app()->controller->id . '/getKabupaten') . "';
        $.getJSON(url, {id: prov}, function(data) { kab = data; });
        $('#AdmPemerintahan_kabupaten').attr('readonly',false);
        $('#AdmPemerintahan_kabupaten').focus();
    } else {
        $('#AdmPemerintahan_kabupaten').attr('readonly',true);
        $('#AdmPemerintahan_kecamatan').attr('readonly',true);
    }
});
$('#AdmPemerintahan_kabupaten').change(function() {
    var kabb = this.value
    if (kabb != '') { 
        $('#kab').find('.select2-chosen').removeClass('select2-default');
        var url = '" . Yii::app()->createUrl('/perusahaan/' . Yii::app()->controller->id . '/getKecamatan') . "';
        $.getJSON(url, {id: kabb}, function(data) { kec = data; });
        $('#AdmPemerintahan_kecamatan').attr('readonly',false);
        $('#AdmPemerintahan_kecamatan').focus();
    } else {
        $('#AdmPemerintahan_kecamatan').attr('readonly',true);
    }
});
$('#AdmPemerintahan_kecamatan').change(function() {
    if (this.value != '') { 
        $('#kec').find('.select2-chosen').removeClass('select2-default');
    }
});
", CClientScript::POS_END);
