<div class="panel panel-info">
<?php
$select = Provinsi::model()->findAll();
$list = CHtml::listData($select, 'id_provinsi', 'nama');

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>
<div class="panel-body">
<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'perusahaan_id', array('groupOptions' => array('class' => 'hidden'),'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => Yii::app()->user->idPerusahaan())))); ?>

<?php echo $form->textFieldGroup($model, 'nama_cabang', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'alamat', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->select2Group($model, 'provinsi', array('groupOptions' => array('id' => "prov"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Provinsi'))))); ?>

<?php echo $form->select2Group($model, 'kabupaten', array('groupOptions' => array('id' => "kab"), 'widgetOptions' => array('asDropDownList' => false, 'options' => array('allowClear' => true, 'data' => 'js: function() { return {results: kab}; }'), 'data' => null, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kabupaten/Kota'))))); ?>

<?php echo $form->textFieldGroup($model, 'kode_pos', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 7)))); ?>

<?php echo $form->textFieldGroup($model, 'telepon', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php //echo $form->textFieldGroup($model, 'email', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php //echo $form->textFieldGroup($model, 'website', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'kontak', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'telepon_kontak', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'email_kontak', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
</div>
    <div class="panel-footer">

<!-- <div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9"> -->
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
    <!-- </div> -->
</div>
</div>
<?php $this->endWidget(); ?>
<?php
$jse_code = (!$model->isNewrecord) ? "var kab = " . CJSON::encode($data['oldp']) . ";" : "var kab = [];";
Yii::app()->getClientScript()->registerScript("prg_data", $jse_code, CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerScript("pick_prov", "
var pv;
var ph = $('#PerusahaanCabang_kabupaten').attr('placeholder');
$('#PerusahaanCabang_provinsi').change(function() {
    var pr = this.value;
    if (pr != pv) {
        pv = this.value;
        $('#PerusahaanCabang_kabupaten').attr('value', null);
        $('#PerusahaanCabang_kabupaten').attr('readonly',false);
        $('#kab').find('.select2-allowclear').removeClass('select2-allowclear');
        $('#kab').find('.select2-chosen').empty().addClass('select2-default').html(ph);
    }
    if (pr != '') {
        $('#PerusahaanCabang_kabupaten').attr('value', null);
        $('#kab').show();
        var url = '" . Yii::app()->createUrl('/perusahaan/data/getKabupaten') . "';
        $.getJSON(url, {id: pr}, function(data) { kab = data; });
        $('#PerusahaanCabang_kabupaten').attr('readonly',false);
        $('#PerusahaanCabang_kabupaten').focus();
    } else {
        $('#PerusahaanCabang_kabupaten').attr('readonly',true);
    }
});
$('#PerusahaanCabang_kabupaten').change(function() {
    if (this.value != '') { $('#kab').find('.select2-chosen').removeClass('select2-default'); }
});
", CClientScript::POS_END);