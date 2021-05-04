<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
<!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
<link rel="stylesheet" type="text/css" href="<?= $dateCss ?>" />
<script type="text/javascript" src="<?= $dateJs ?>"></script>

<?php
//$select_prodlahan = MasterJenisProduksiLahan::model()->findAll();

$select_sektor = RkuBlok::model()->findAll(array(
    'condition' => 'id_rku = ' . $rku->id_rku . " ORDER BY id ASC"
        ));
$list_sektor = CHtml::listData($select_sektor, 'id', function($data) {
            $gabung = $data->namaSektor->nama_sektor . " | " .
                    $data->nama_blok;
            return $gabung;
        });

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

<?php echo $form->numberFieldGroup($model, 'daur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php echo $form->textFieldGroup($model, 'rkt_ke', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>


<?php echo $form->select2Group($model, 'id_blok', array('groupOptions' => array('id' => "sektor"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_sektor, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Blok Sektor'))))); ?>

<div class="form-group">
    <div class="col-sm-3" style="text-align: right">
        <?php echo CHtml::activeLabel($model,'id_kabupaten');?>
    </div>
    <div class="col-sm-9">
    <?php echo  $form->dropDownList($model,'id_kabupaten',
                                CHtml::listData(AdmPemerintahan::model()->findAllByAttributes(array('id_perusahaan'=>Yii::app()->user->idPerusahaan())),'kabupaten','kabupaten0.nama'),
                                array('empty'=>'   --- Pilih Kabupaten ---   ') ); ?>
    </div>
 </div>    
    
<?php echo $form->select2Group($model, 'id_jenis_produksi_lahan', array('groupOptions' => array('id' => "jenis_produksi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisProduksi, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Tata Ruang'))))); ?>

<?php echo $form->select2Group($model, 'id_jenis_lahan', array('groupOptions' => array('id' => "jenis_lahan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisLahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Jenis Lahan'))))); ?>

<?php echo $form->select2Group($model, 'id_jenis_kayu', array('groupOptions' => array('id' => "nama_kayu"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisKayu, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Jenis Kayu'))))); ?>

<?php echo $form->select2Group($model, 'id_jenis_kelompok_kayu', array('groupOptions' => array('id' => "nama_kelompok"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listJenisKelompokKayu, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kelompok Kayu'))))); ?>

<?php echo $form->numberFieldGroup($model, 'jumlah_luas', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php echo $form->numberFieldGroup($model, 'jumlah_produksi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php echo CHtml::activeHiddenField($model, 'id_rkt_form_alasan'); ?>
<?php echo CHtml::activeHiddenField($model, 'id_rkt_new'); ?>
<?php echo CHtml::activeHiddenField($model, 'rkt_ke_new'); ?>

<button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanRKT()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        // $(".tangal").datepicker({'autoclose':true,'format':'yyyy-mm-dd','language':'id'});
        // $(".control-label").attr('class','col-sm-3 control-label required');

        $("#<?= Yii::app()->controller->id . '-form'; ?> .control-label").each(function () {
            var t = this;
            $(t).attr('class', 'col-sm-3 control-label required');
            var hml = $(t).html();
            if (hml.indexOf("span") >= 0) {
                console.log('<span>' + " found");
            } else {
                $(t).append(' <span class="required">*</span>');
            }
        });
    });

    function simpanRKT()
    {

        $('#RktPanenLahan_rkt_ke_new').val($('#Rkt_tahun_mulai').val());
        var form = new FormData($("#<?= Yii::app()->controller->id . '-form'; ?>")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/rktPemanenanLahan/formRktDismatch/alasan/" . $alasan . "/tahun/" . $tahun) ?>",
            success: function (result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if (result.status == "success") {
                        $.fn.yiiGridView.update("rkt-pembibitan-grid-rku-dismatch");
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
