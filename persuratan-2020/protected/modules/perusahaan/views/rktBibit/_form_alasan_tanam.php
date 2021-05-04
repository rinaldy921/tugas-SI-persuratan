
<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
<!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
<link rel="stylesheet" type="text/css" href="<?= $dateCss ?>" />
<script type="text/javascript" src="<?= $dateJs ?>"></script>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'tanam_alasan-form',
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

<?php echo $form->textFieldGroup($model, 'no_surat', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('format' => 'yyyy', 'autoclose' => true), 'htmlOptions' => array('class' => 'span5 tangal')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>
<?php echo $form->dropDownListGroup($model, 'keterangan', array('widgetOptions' => array('data' => array("Penambahan Blok" => "Penambahan Blok", "Penggantian Blok" => "Penggantian Blok",), 'htmlOptions' => array('class' => 'input-large')))); ?>
<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Upload Surat (PDF)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_alasan" type="file">
        </div>
    </div>
</div>
<button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanTanamAlasan()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".tangal").datepicker(
                {
                    'autoclose': true,
                    'format': 'yyyy-mm-dd',
                    'language': 'id',
                    // viewMode: "years",
                    // minViewMode: "years"
                }
        );

<?php if (isset($_SESSION['id_alasan_rkt']) && $_SESSION['id_alasan_rkt'] != 0): ?>
            var url = "<?php echo $this->createUrl('//perusahaan/rktBibit/formRKTnotRelated'); ?>";
            var title = "Tambah Data RKT Penanaman (Tidak Sesuai RKU)";
            changeModalConten(url, title);
<?php endif; ?>
    });

    function simpanTanamAlasan()
    {
        var form = new FormData($("#tanam_alasan-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/rktBibit/formAlasanTanam") ?>",
            success: function (result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if (result.status == "success") {
                        // $.fn.yiiGridView.update("rktBibit-tanam-grid");
                        // $("#modal").modal("hide");
                        var url = "<?php echo $this->createUrl('//perusahaan/rktBibit/formRKTnotRelated'); ?>";
                        var title = "Tambah Data RKT Penanaman (Tidak Sesuai RKU)";
                        changeModalConten(url, title);
                    }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error submiting!", xhr.responseText, "error");
            }
        });
    }
</script>
