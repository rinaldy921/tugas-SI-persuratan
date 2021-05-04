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

//$selTataRuang = MasterJenisProduksiLahan::model();        

$selJenisProdLahan = MasterJenisProduksiLahan::model()->findAll(array(
    'condition' => 'id IN ('
    . 'SELECT id_jenis_produksi_lahan FROM rku_tanaman_silvikultur WHERE id_rku = ' . $rku->id_rku . ' )'
        ));
$list_prodlahan = CHtml::listData($selJenisProdLahan, 'id', 'jenis_produksi');

$select_lahan = MasterJenisLahan::model()->findAll();
$list_lahan = CHtml::listData($select_lahan, 'id', 'jenis_lahan');

$select_jenistanaman = MasterJenisTanaman::model()->findAll(array(
    'condition' => 'id IN ('
    . 'SELECT id_jenis_tanaman FROM rku_tanaman_silvikultur WHERE id_rku = ' . $rku->id_rku . ' )'
        ));
$list_tanaman = CHtml::listData($select_jenistanaman, 'id', 'nama_tanaman');



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

<?php echo $form->select2Group($model, 'id_jenis_produksi_lahan', array('groupOptions' => array('id' => "jenis_produksi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_prodlahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Tata Ruang'))))); ?>

<?php echo $form->select2Group($model, 'id_jenis_lahan', array('groupOptions' => array('id' => "jenis_lahan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_lahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Lahan'))))); ?>

<?php echo $form->numberFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

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
        $('#RktSiapLahan_rkt_ke_new').val($('#Rkt_tahun_mulai').val());
        var form = new FormData($("#<?= Yii::app()->controller->id . '-form'; ?>")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/rktPenyiapanLahan/formRktDismatch/alasan/" . $alasan . "/tahun/" . $tahun) ?>",
            success: function (result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if (result.status == "success") {
                        $.fn.yiiGridView.update("rkt-penyiapan-lahan-grid-rku-dismatch");
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
