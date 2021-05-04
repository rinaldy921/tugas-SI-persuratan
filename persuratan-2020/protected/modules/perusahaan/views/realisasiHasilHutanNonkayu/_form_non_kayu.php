<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs  = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";

?>
    <!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->

    <link rel="stylesheet" type="text/css" href="<?=$dateCss?>" />
    <script type="text/javascript" src="<?=$dateJs?>"></script>


<?php
$select_rkusil = RktHasilHutanNonkayu::model()->findAll(array(
    'condition'=>'id_rkt='.$id_rkt
));
$list_rkusil = CHtml::listData($select_rkusil, 'id', function($model){
    $gabung = $model->idJenisLahan->jenis_lahan. " | ".
              $model->idJenisProduksiLahan->jenis_produksi . " | ".
              $model->idBlok->idSektor->nama_sektor. " | ".
              $model->idBlok->idBlok->nama_blok. " | ".
              $model->idHasilHutanNonkayu->nama_hhbk . " (".$model->idSatuanVolumeNonkayu->satuan.")";
    return $gabung;
});

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=> 'hhbk_rku-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        // 'htmlOptions' => array(
		// 	'enctype' => 'multipart/form-data',
		// ),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

    <?php echo $form->select2Group($model, 'id_rkt_hasil_hutan_nonkayu', array('groupOptions' => array('id' => "idJenisProduksiLahan.jenis_produksi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_rkusil, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih ...'))))); ?>
    <?php echo $form->textFieldGroup($model,'id_bulan',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255,'readonly'=>'readonly')))); ?>
    <?php echo $form->textFieldGroup($model,'tahun',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255,'readonly'=>'readonly')))); ?>
    <?php echo $form->textFieldGroup($model,'realisasi',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>
    <button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanHHBK()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".tangal").datepicker(
            {
                'autoclose':true,
                'format':'yyyy',
                'language':'id',
                viewMode: "years",
                minViewMode: "years"
            }
        );
    });

    function simpanHHBK()
    {
        var form = new FormData($("#hhbk_rku-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=Yii::app()->createUrl("/perusahaan/realisasiHasilHutanNonkayu/formNonKayu", array('bulan'=>$bulan,'tahun_periode'=>$tahun_periode,'tahun'=>$tahun,'id_rkt'=>$id_rkt))?>",
            success: function(result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if(result.status == "success") {
                        // $.fn.yiiGridView.update("realisasiHasilHutanNonkayu-hhbk-grid");
                        // $.fn.yiiGridView.update("realisasiHasilHutanNonkayu-hhbk-grid",{data:"aksi=updateGrid&tahun=<?=$tahun?>&id_bulan=<?=$bulan?>&tahun_periode=<?=$tahun_periode?>",complete:function(){
                        //     setTimeout(function(){
                        //         generateTable();
                        //     }, 100);
                        //
                        // }});
                        <?php
                            $modelBulan = MasterBulan::model()->find(array('condition'=>'id='.$bulan));
                            $bulan_text = $modelBulan->bulan;
                        ?>
                        var paraam = "FormPeriodeRealisasiPrasyarat[form]=panen_non_kayu&FormPeriodeRealisasiPrasyarat[periode]=<?=$bulan?>&FormPeriodeRealisasiPrasyarat[rkt]=<?=$tahun?>&FormPeriodeRealisasiPrasyarat[tahun_periode]=<?=$bulan_text?>+<?=$tahun_periode?>"
                        $('#grid-content').empty();
                        $("#modal").modal("hide");
                        $.ajax({
                            type: "POST",
                            data: paraam,
                            dataType: 'html',
                            url:'<?=Yii::app()->createUrl('//perusahaan/realisasiHasilHutanNonkayu/index')?>',
                            success: function(response, statusText, xhr, $form){
                                $('#grid-content').html(response);

                            }
                        });


                        // console.log(result.buton_hide);
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
