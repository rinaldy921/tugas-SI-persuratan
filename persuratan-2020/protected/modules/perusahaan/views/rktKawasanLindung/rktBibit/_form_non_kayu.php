<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs  = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
    <!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
    <link rel="stylesheet" type="text/css" href="<?=$dateCss?>" />
    <script type="text/javascript" src="<?=$dateJs?>"></script>

<?php
// echo $model->idRkt->id_rku;
$select_hhnk = MasterHasilHutanNonkayu::model()->findAll();
$list_hhnk = CHtml::listData($select_hhnk, 'id', 'nama_hhbk');

$select_satuan = SatuanVolumeNonkayu::model()->findAll();
$list_satuan = CHtml::listData($select_satuan, 'id', 'satuan');

$select_lahan = MasterJenisLahan::model()->findAll();
$list_lahan = CHtml::listData($select_lahan, 'id', 'jenis_lahan');

$select_prodlahan = MasterJenisProduksiLahan::model()->findAll();
$list_prodlahan = CHtml::listData($select_prodlahan, 'id', 'jenis_produksi');

$select_sektor = BlokSektor::model()->findAll(array(
    'condition' => 'id_rku = '.$model->idRkt->id_rku . " ORDER BY id ASC"
));
$list_sektor = CHtml::listData($select_sektor, 'id', function($data) {
    $gabung = $data->idSektor->nama_sektor . " | ".
              $data->idBlok->nama_blok;
    return $gabung;
});

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=> 'hhbk-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

    <?php echo $form->select2Group($model, 'id_jenis_lahan', array('groupOptions' => array('id' => "jenis_lahan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_lahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Lahan'))))); ?>
    <?php echo $form->select2Group($model, 'id_jenis_produksi_lahan', array('groupOptions' => array('id' => "jenis_produksi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_prodlahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Produksi Lahan'))))); ?>
    <?php echo $form->select2Group($model, 'id_blok', array('groupOptions' => array('id' => "sektor"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_sektor, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Blok Sektor'))))); ?>
    <?php echo $form->select2Group($model, 'id_hasil_hutan_nonkayu', array('groupOptions' => array('id' => "nama_hhbk"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_hhnk, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Hasil Hutan Non Kayu'))))); ?>
    <?php echo $form->select2Group($model, 'id_satuan_volume_nonkayu', array('groupOptions' => array('id' => "satuan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_satuan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Satuan'))))); ?>
    <?php echo $form->numberFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

    <button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanHHBK()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".tangal").datepicker({'autoclose':true,'format':'yyyy-mm-dd','language':'id'});
    });

    function simpanHHBK()
    {

        if($("#RktHasilHutanNonkayu_id_hasil_hutan_nonkayu").val() == "") {
            swal("Informasi", "Harap Pilih Hasil Hutan Non Kayu", "warning");
            return false;
        }

        if($("#RktHasilHutanNonkayu_id_satuan_volume_nonkayu").val() == "") {
            swal("Informasi", "Harap Pilih Satuan", "warning");
            return false;
        }

        if($("#RktHasilHutanNonkayu_jumlah").val() == "") {
            swal("Informasi", "Harap isi Realisasi", "warning");
            return false;
        }

        var form = new FormData($("#hhbk-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=Yii::app()->createUrl("/perusahaan/rktBibit/formNonKayu",array('id'=>$model->id_rkt))?>?id_pk=<?=$id_pk?>&id_rkt_sil=<?=$model->id_rku_hasil_hutan_nonkayu_silvikultur?>",
            success: function(result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if(result.status == "success") {
                        $.fn.yiiGridView.update("rktBibit-nonkayu-grid");
                        $("#modal").modal("hide");

                        // if(result.buton_hide) {
                        //     $("#buton_new").hide();
                        // }
                    }
                });
            },
          error: function(xhr, ajaxOptions, thrownError) {
              swal("Error submiting!", xhr.responseText, "error");
          }
      });
    }
</script>