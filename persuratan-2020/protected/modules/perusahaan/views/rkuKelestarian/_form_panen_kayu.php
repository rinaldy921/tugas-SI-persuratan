<?php
$rkuMstr = Rku::model()->findByPk($id_rku);

//$sizeArr = $rkuMstr->tahun_sampai - $rkuMstr->tahun_mulai;
$arrRktKe=array();
$index=1;

for($i=$rkuMstr->tahun_mulai; $i<=$rkuMstr->tahun_sampai; $i++){
    $objArr;
    
    if($index == 1){
        $objArr = array('tahun' => $rkuMstr->tahun_mulai, 'ke' => $index);
        array_push($arrRktKe,$objArr);
    }else{
        $tahun = $rkuMstr->tahun_mulai + ($index-1);
        
        $objArr = array('tahun' => $tahun, 'ke' => $index);
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


$select_blok = RkuBlok::model()->findAll(array(
    'condition' => 'id_rku=' . $id_rku
        ));
$list_blok = CHtml::listData($select_blok, 'id', function($model) {
            $gabung = $model->namaSektor->nama_sektor . " | " .
                    $model->nama_blok;
            return $gabung;
        });
        
//$select_blok = BlokSektor::model()->findAll(array(
//    'condition' => 'id_rku=' . $id_rku
//        ));
//$list_blok = CHtml::listData($select_blok, 'id', function($model) {
//            $gabung = $model->idSektor->nama_sektor . " | " .
//                    $model->idBlok->nama_blok;
//            return $gabung;
//        });



$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'panenKayuRKU-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    // 'htmlOptions' => array(
    // 	'enctype' => 'multipart/form-data',
    // ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'daur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>


<div class="form-group">    
        <div class="col-sm-3" style="text-align: right">
            <?php echo CHtml::activeLabel($model,'rkt_ke');?>
        </div>
        <div class="col-sm-9">
        <?php   $rkuId = Yii::app()->session['rku_id'];
                //$urlChangeRkuKe = Yii::app()->createUrl("perusahaan/rkuPersyaratan/getTahunRku"); 
                
                    $model['id_rku'] = $rkuId;
                    
                    echo $form->dropDownList($model,'tahun_ke',
                                            CHtml::listData($arrRktKe,'tahun','ke'),
                                            array('empty'=>'   --- Pilih RKU Tahun Ke ---   ') ); 
        
                    
                    echo $form->hiddenField($model,'rkt_ke');	
                    
                    ?>
        
        </div>
    </div>

    
<?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>


    <?php //echo $form->datePickerGroup($model, 'tahun', array('widgetOptions' => array('options' => array('format' => 'yyyy', 'autoclose' => true), 'htmlOptions' => array('class' => 'span5 tangal')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>
<?php echo $form->select2Group($model, 'id_blok', array('groupOptions' => array('id' => "id_blok"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_blok, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Blok Sektor...'))))); ?>

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

<?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php echo $form->textFieldGroup($model, 'produksi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php echo $form->dropDownListGroup($model, 'keterangan', array('groupOptions' => array('class' => ''), 'widgetOptions' => array('data' => array("Pemanenan RKT" => "Pemanenan RKT", 'Penyiapan Lahan' => 'Penyiapan Lahan'), 'htmlOptions' => array('class' => 'span5')))); ?>

<button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanPanenKayu()">Simpan</button>

<?php $this->endWidget(); ?>


<script type="text/javascript">
        $("#RkuPanen_tahun_ke").change(function(){

            //var dataToPost = "{namaBlok:'" + $("#Rku_blok").val() + "',idSektor:" +$("#Rku_sektor option:selected").val()+ "}";
            tahun = $("#RkuPanen_tahun_ke option:selected").val();
            
            $("#RkuPanen_tahun").val(tahun);

            

             $("#RkuPanen_rkt_ke").val($("#RkuPanen_tahun_ke option:selected").html());
       });

</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".tangal").datepicker(
                {
                    'autoclose': true,
                    'format': 'yyyy',
                    'language': 'id',
                    viewMode: "years",
                    minViewMode: "years"
                }
        );
    });

    function simpanPanenKayu()
    {
        var form = new FormData($("#panenKayuRKU-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl('/perusahaan/rkuKelestarian/addPanenKayu', array('id_rku' => $id_rku)) ?>id_panen/<?= $id_panen ?>",
                        success: function (result) {
                            swal(result.header, result.message, result.status).then((ok) => {
                                if (result.status == "success") {
                                    $.fn.yiiGridView.update("rku-panen-kayu-grid");
                                    $("#modal").modal("hide");
                                }
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error submiting!", xhr.responseText, "error");
                        }
                    });
                }
</script>