<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
<!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
<link rel="stylesheet" type="text/css" href="<?= $dateCss ?>" />
<script type="text/javascript" src="<?= $dateJs ?>"></script>

<?php
$select_penerbit = MasterPenerbit::model()->findAll();
$list_penerbit = CHtml::listData($select_penerbit, 'id_penerbit', 'penerbit');

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'penilikan-form',
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

<?php echo $form->textFieldGroup($model, 'id_perusahaan', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => Yii::app()->user->idPerusahaan())))); ?>
<?php echo $form->textFieldGroup($model, 'nomor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->datePickerGroup($model, 'tgl_penetapan', array('widgetOptions' => array('options' => array('format' => 'yyyy-mm-dd', 'autoclose' => true), 'htmlOptions' => array('class' => 'span5 tangal')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>
<?php echo $form->dropDownListGroup($model, 'predikat', array('widgetOptions' => array('data' => array("Mempertahankan Sertifikat VLK" => "Mempertahankan Sertifikat VLK", "Mencabut Sertifikat VLK" => "Mencabut Sertifikat VLK"), 'htmlOptions' => array('class' => 'input-large')))); ?>
<!-- <?php echo $form->textFieldGroup($model, 'dinyatakan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?> -->
<?php echo $form->dropDownListGroup($model, 'penilikan_ke', array('widgetOptions' => array('data' => array("1" => "1", "2" => "2"), 'htmlOptions' => array('class' => 'input-large')))); ?>
<?php echo $form->select2Group($model, 'id_penerbit', array('groupOptions' => array('id' => "penerbit"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_penerbit, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Penerbit'))))); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File Dokumen (PDF) </label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_phpl" type="file">
        </div>
            <i>Ukuran File Maksimal 2 Mb</i>
        <br>
        <br>
        <?php
        //if ($id_penilikan != "") {
            if (!is_null($model->file_doc)) {
//                $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                echo "File Dokumen: <a href='" . Yii::app()->createUrl("/") . $model->file_doc ."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
            }
        //}
        ?>
    </div>
</div>

<button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanPenilikan()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".tangal").datepicker({'autoclose': true, 'format': 'yyyy-mm-dd', 'language': 'id'});
    });

    function simpanPenilikan()
    {
        var form = new FormData($("#penilikan-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/sertifikasiPhpl/addPenilikanVLK", array('id' => $modelSertifikat->id)) ?>?id_penilikan=<?= $id_penilikan ?>",
                        success: function (result) {
                            swal(result.header, result.message, result.status).then((ok) => {
                                $.fn.yiiGridView.update("sertifikasiPhpl-grid");
                                $("#modal").modal("hide");

                                if (result.buton_hide) {
                                    $("#buton_new").hide();
                                }
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error submiting!", xhr.responseText, "error");
                        }
                    });
                }
</script>
