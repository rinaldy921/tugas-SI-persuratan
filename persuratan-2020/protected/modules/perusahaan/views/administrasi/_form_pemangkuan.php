<div class="panel panel-info">
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-pemangkuan-hutan-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
$select = Provinsi::model()->findAll();
$list = CHtml::listData($select, 'id_provinsi', 'nama');
$kph = CHtml::listData(MasterJenisKph::model()->findAll(), 'id', 'nama_kph')
?>
<div class="panel-body">
<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'id_iuphhk', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'col-md-8')))); ?>

<?php echo $form->select2Group($model, 'dinhut_prov', array('labelOptions'=>array('label'=>'Dishut Provinsi'),'wrapperHtmlOptions' => array('class' => ''), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "prov"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Provinsi'))))); ?>

<?php echo $form->select2Group($model, 'dinhut_kab', array('labelOptions'=>array('label'=>'Kabupaten'),'wrapperHtmlOptions' => array('class' => ''), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "kab"), 'widgetOptions' => array('asDropDownList' => false, 'options' => array('allowClear' => true, 'data' => 'js: function() { return {results: kab}; }'), 'data' => null, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kabupaten/Kota'))))); ?>

<?php echo $form->select2Group($model, 'id_kph', array('wrapperHtmlOptions' => array('class' => ''), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "kph"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $kph, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih KPH'))))); ?>

<?php echo $form->textFieldGroup($model, 'bkph', array('groupOptions' => array('class' => ''), 'widgetOptions' => array('htmlOptions' => array('class' => '')))); ?>

<?php echo $form->textFieldGroup($model, 'rph', array('groupOptions' => array('class' => ''), 'widgetOptions' => array('htmlOptions' => array('class' => '')))); ?>
</div>
<div class="panel-footer">
<!-- <div class="form-group"> -->
    <div class="col-sm-3"></div>
    <!-- <div class="col-sm-9"> -->
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Create' : 'Save',

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
<?php
$js_kab = (!$model->isNewrecord) ? "var kab = " . CJSON::encode($data['oldkab']) . ";" : "var kab = [];";
Yii::app()->getClientScript()->registerScript("reg_data_1", $js_kab, CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerScript("pick_prov", "
var pv = $('#AdmPemangkuanHutan_dinhut_prov').value;
var ph_kab = $('#AdmPemangkuanHutan_dinhut_kab').attr('placeholder');
var ph_rph = $('#AdmPemangkuanHutan_rph').attr('placeholder');
$('#AdmPemangkuanHutan_dinhut_prov').change(function() {
    var prov = this.value;
    if (prov != pv) {
        pv = this.value;
        $('#AdmPemangkuanHutan_dinhut_kab').attr('readonly',false);
        $('#kab').find('.select2-allowclear').removeClass('select2-allowclear');
        $('#kab').find('.select2-chosen').empty().addClass('select2-default').html(ph_kab);
    }
    if (prov != '') {
        var url = '" . Yii::app()->createUrl('/perusahaan/' . Yii::app()->controller->id . '/getKabupaten') . "';
        $.getJSON(url, {id: prov}, function(data) { kab = data; });
        $('#AdmPemangkuanHutan_dinhut_kab').attr('readonly',false);
        $('#AdmPemangkuanHutan_dinhut_kab').focus();
    } else {
        $('#AdmPemangkuanHutan_dinhut_kab').attr('readonly',true);
    }
});
$('#AdmPemangkuanHutan_dinhut_kab').change(function() {
    var kabb = this.value
    if (kabb != '') { 
        $('#kab').find('.select2-chosen').removeClass('select2-default');
    }
});
", CClientScript::POS_END);
