<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
<!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
<link rel="stylesheet" type="text/css" href="<?= $dateCss ?>" />
<script type="text/javascript" src="<?= $dateJs ?>"></script>

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


$select_jlahan = MasterJenisPemasaran::model()->findAll();
$list_jlahan = CHtml::listData($select_jlahan, 'id', function($model) {
            $gabung = $model->nama_pemasaran;
            return $gabung;
        });


$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'rku-pasar-form',
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
                
                    $model['id_rku'] = $rkuId;
                    
                    echo $form->dropDownList($model,'tahun_ke',
                                            CHtml::listData($arrRktKe,'tahun','ke'),
                                            array('empty'=>'   --- Pilih RKT Tahun Ke ---   ') ); 
                    
                    echo $form->hiddenField($model,'rkt_ke');	
                    
                    ?>
        
        </div>
    </div>

    
<?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

    
    
    <?php echo $form->select2Group($model, 'id_jenis_pasar', array('groupOptions' => array('id' => "id_jenis_pasar"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_jlahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Jenis Pemasaran...'))))); ?>
<?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanTanam()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
        $("#RkuPasar_tahun_ke").change(function(){

            //var dataToPost = "{namaBlok:'" + $("#Rku_blok").val() + "',idSektor:" +$("#Rku_sektor option:selected").val()+ "}";
            tahun = $("#RkuPasar_tahun_ke option:selected").val();
            
            $("#RkuPasar_tahun").val(tahun);

            
             $("#RkuPasar_rkt_ke").val($("#RkuPasar_tahun_ke option:selected").html());
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

    function simpanTanam()
    {
        var form = new FormData($("#rku-pasar-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/rkuKelestarian/addPemasaran", array('id_rku' => $id_rku)) ?>id_pasar/<?= $id_pasar ?>",
                        success: function (result) {
                            swal(result.header, result.message, result.status).then((ok) => {
                                if (result.status == "success") {
                                    $.fn.yiiGridView.update("rkuKelestarian-pasar-grid");
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
