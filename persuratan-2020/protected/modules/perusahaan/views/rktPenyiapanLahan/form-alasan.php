<?php
$rkuMstr = Rku::model()->findByPk(Yii::app()->session['rku_id']);

//$sizeArr = $rkuMstr->tahun_sampai - $rkuMstr->tahun_mulai;
$arrRktKe=array();
$index=1;

for($i=$rkuMstr->tahun_mulai; $i<=$rkuMstr->tahun_sampai; $i++){
    $objArr;
    
    if($index == 1){
        $objArr = array('tahun' => $index, 'ke' => $index.' | '.$rkuMstr->tahun_mulai);
        array_push($arrRktKe,$objArr);
    }else{
        $tahun = $rkuMstr->tahun_mulai + ($index-1);
        
        $objArr = array('tahun' => $index, 'ke' => $index.' | '.$tahun);
        array_push($arrRktKe,$objArr);
    }
    $index++;
}



$themeBase = Yii::app()->theme->baseUrl;

$dateJs = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
<!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
<link rel="stylesheet" type="text/css" href="<?= $dateCss ?>" />
<script type="text/javascript" src="<?= $dateJs ?>"></script>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'form-alasan',
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
<?php echo $form->dropDownListGroup($model, 'keterangan', array('widgetOptions' => array('data' => array("Penambahan Blok RKT" => "Penambahan Blok RKT", "Perubahan Blok RKT" => "Perubahan Blok RKT","Luncuran Blok RKT"=>"Luncuran Blok RKT"), 'htmlOptions' => array('class' => 'input-large')))); ?>

<div class="form-group">    
        <div class="col-sm-3" style="text-align: right">
            <?php echo CHtml::activeLabel($model,'rkt_ke');?>
        </div>
        <div class="col-sm-9">
        <?php  
                
                    
                    echo $form->dropDownList($model,'tahun_ke',
                                            CHtml::listData($arrRktKe,'tahun','ke'),
                                            array('empty'=>'   --- Pilih RKT Tahun Ke ---   ') ); 

                    echo $form->hiddenField($model,'rkt_ke');
                    echo $form->hiddenField($model,'id_rku');
                    ?>
        
        </div>
    </div>


<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Upload Surat (PDF)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_alasan" type="file">
        </div>
    </div>
</div>
<button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanAlasan()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
        $("#RktFormAlasan_tahun_ke").change(function(){

            //var dataToPost = "{namaBlok:'" + $("#Rku_blok").val() + "',idSektor:" +$("#Rku_sektor option:selected").val()+ "}";
            tahun = $("#RktFormAlasan_tahun_ke option:selected").val();
            
            $("#RktFormAlasan_rkt_ke").val($('#RktFormAlasan_tahun_ke option:selected').val());  //update rkt ke
            $("#RktFormAlasan_id_rku").val('<?php echo Yii::app()->session['rku_id'] ?>');  //temp tahun

            
       });

</script>

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

    });

    function simpanAlasan()
    {
        var form = new FormData($("#form-alasan")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/rktPenyiapanLahan/entryAlasan/tahun/" . $tahun) ?>",
            success: function (result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if (result.status == "success") {
                        // $.fn.yiiGridView.update("rktBibit-tanam-grid");
                        // $("#modal").modal("hide");
                        var url = "<?php echo $this->createUrl('//perusahaan/rktPenyiapanLahan/formRktDismatch/'); ?>" + "alasan/" + result.id + "/tahun/" + result.rkt_ke;
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
