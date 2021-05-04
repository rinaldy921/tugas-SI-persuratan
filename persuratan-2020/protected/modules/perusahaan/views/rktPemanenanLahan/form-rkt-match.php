<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    // 'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));


/*
  $selJenisTanaman = MasterJenisTanaman::model()->findAll(array(
  'condition' => 'id IN ('
  . 'SELECT id_jenis_tanaman FROM rku_tanaman_silvikultur WHERE id_rku = '.$modelRKU->id_rku.' AND id_jenis_produksi_lahan = '.$modelRKU->id_jenis_produksi_lahan.' )'
  ));
  //debug($selJenisTanaman);
  $listTanaman = CHtml::listData($selJenisTanaman, 'id', 'nama_tanaman');
 * 
 */

$listJenisProduksi = CHtml::listData(
        MasterJenisProduksiLahan::model()->findAll(), 
        'id', 'jenis_produksi'
);

$listJenisLahan = CHtml::listData(
        MasterJenisLahan::model()->findAll(array('condition' => "id != 3 ")), 
        'id', 'jenis_lahan'
);

$listJenisKayu = CHtml::listData(
        MasterJenisKayu::model()->findAll(), 
        'id', 'nama_kayu'
);

$listJenisKelompokKayu = CHtml::listData(
        MasterJenisKelompokKayu::model()->findAll(), 
        'id', 'nama_kelompok'
);

?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'daur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, 'rkt_ke', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, '_tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, '_sektor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, '_blok', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, 'namaKabupaten', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->select2Group($model, 'id_jenis_produksi_lahan', array('groupOptions' => array('id' => "jenis_produksi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisProduksi, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Tata Ruang'))))); ?>

<?php echo $form->select2Group($model, 'id_jenis_lahan', array('groupOptions' => array('id' => "jenis_lahan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisLahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Jenis Lahan'))))); ?>

<?php echo $form->select2Group($model, 'id_jenis_kayu', array('groupOptions' => array('id' => "nama_kayu"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisKayu, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Jenis Kayu'))))); ?>

<?php echo $form->select2Group($model, 'id_jenis_kelompok_kayu', array('groupOptions' => array('id' => "nama_kelompok"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisKelompokKayu, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kelompok Kayu'))))); ?>

<?php echo $form->textFieldGroup($model, 'jumlah_luas', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'jumlah_produksi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo CHtml::activeHiddenField($model, 'id_rku_panen'); ?>

<?php echo CHtml::activeHiddenField($model, 'id_rkt'); ?>

<?php echo CHtml::activeHiddenField($model, 'id_blok'); ?>

<?php echo CHtml::activeHiddenField($model, 'id_kabupaten'); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <button type="button" name="button" class="btn btn-success" onclick="simpanRKT()">Simpan RKT</button>
<?php
/* $this->widget('booster.widgets.TbButton', array(
  'buttonType' => 'submit',
  'context' => 'success',
  'label' => 'Simpan RKT',
  ));
 * 
 */

echo ' &nbsp;&nbsp;&nbsp;';
$this->widget('booster.widgets.TbButton', array(
    'buttonType' => 'reset',
    'context' => 'danger',
    'label' => Yii::t('app', 'Kembali'),
    'htmlOptions' => array('onclick' => 'toggleFormRKTByRKU("#form-rkt","#select-rku","' . $this->createUrl('//perusahaan/rktPemanenanLahan/pilihRKU/tahun/' . $modelRKU->tahun) . '")'),
));
?>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function simpanRKT()
    {
        var form = new FormData($("#<?= Yii::app()->controller->id . '-form'; ?>")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/rktPemanenanLahan/formRktMatch/rku/" . $modelRKU->id); ?>",
            success: function (result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if (result.status == "success") {
                        $.fn.yiiGridView.update("rkt-pemanenan-lahan-grid-rku-match");
                        $("#modal").modal("hide");
                        // if(result.buton_hide) {
                        //     $("#buton_new").hide();
                        // }
                    }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error submiting!", xhr.responseText, "error");
            }
        });
    }
</script>