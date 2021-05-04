<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
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

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'perusahaan_id', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => Yii::app()->user->idPerusahaan())))); ?>

<?php echo $form->dropDownListGroup($model, 'jenis_legalitas', array('widgetOptions' => array('data' => array("Akte Pendirian" => "Akte Pendirian", "Akte Perubahan" => "Akte Perubahan",), 'htmlOptions' => array('class' => 'input-large')))); ?>

<?php echo $form->textFieldGroup($model, 'perubahan_ke', array('groupOptions' => array('id' => 'perubahan'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'notaris', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'nomor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('autoclose' => true, 'format' => 'yyyy-m-d'), 'htmlOptions' => array('class' => 'span5')), 'append' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

<?php echo $form->textFieldGroup($model, 'no_surat_kemenkumham', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->datePickerGroup($model, 'tgl_surat_kemenkumham', array('widgetOptions' => array('options' => array('autoclose' => true, 'format' => 'yyyy-m-d'), 'htmlOptions' => array('class' => 'span5')), 'append' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Upload Akte (PDF)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_akte_legalitas" type="file">
        </div>
                <i>Ukuran File Maksimal 5 Mb</i>
                    <br>
                <?php
                {
                    if(!is_null($model->pdf_akte_legalitas)) {
                        echo "File SK: <a href='".Yii::app()->createUrl("/").$model->pdf_akte_legalitas."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    }
                }
                 ?>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Upload Surat Kemenkumham (PDF)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_surat_kemenkumham" type="file">
        </div>
        <i>Ukuran File Maksimal 2 Mb</i>
                    <br>
                <?php
                {
                    if(!is_null($model->pdf_surat_kemenkumham)) {
                        echo "File SK: <a href='".Yii::app()->createUrl("/").$model->pdf_surat_kemenkumham."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    }
                }
                 ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
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
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
Yii::app()->getClientScript()->registerScript("j_legalitas", "
$('#perubahan').hide();
$('#LegalitasPerusahaan_jenis_legalitas').change(function() {
    var le = this.value;
    if (le == 'Akte Perubahan') {
        $('#perubahan').show();
    }
    if (le == 'Akte Pendirian') {
        $('#LegalitasPerusahaan_perubahan_ke').attr('value',0);
        $('#perubahan').hide();
    }
});
", CClientScript::POS_END);
