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



$select_rkusil = RkuTanamanSilvikultur::model()->findAll(array(
    'condition' => 'id_rku=' . $id_rku
        ));
$jenisTataRuang = MasterJenisProduksiLahan::model()->findAll();
$list_rkusil = CHtml::listData($jenisTataRuang, 'id', function($model) {
            $gabung = $model->jenis_produksi; // . " | " .
            //$model->idJenisTanaman->nama_tanaman;
            return $gabung;
        });

        
$select_blok = RkuBlok::model()->findAll(array(
    'condition' => 'id_rku=' . $id_rku
        ));
$list_blok = CHtml::listData($select_blok, 'id', function($model) {
            $gabung = $model->namaSektor->nama_sektor . " | " .
                    $model->nama_blok;
            return $gabung;
        });
 
$select_jlahan = MasterJenisLahan::model()->findAll();
$list_jlahan = CHtml::listData($select_jlahan, 'id', function($model) {
            $gabung = $model->jenis_lahan;
            return $gabung;
        });


$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'BibitRKU-form',
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
        <?php echo CHtml::activeLabel($model,'tahun_ke');?>
    </div>
    <div class="col-sm-9">
        <?php   $rkuId = Yii::app()->session['rku_id'];
                $model['id_rku'] = $rkuId;
                echo $form->dropDownList($model,'tahun_ke',
                                            CHtml::listData($arrRktKe,'tahun','ke'),
                                            array('empty'=>'   --- Pilih Blok Kerja Tahun Ke ---   ') ); 
                echo $form->hiddenField($model,'rkt_ke');	
        ?>
        </div>
</div>
<?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php //echo $form->select2Group($model, 'id_blok', array('groupOptions' => array('id' => "id_blok"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_blok, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Blok Sektor...'))))); ?>
<?php echo $form->select2Group($model, 'id_blok', array('groupOptions' => array('id' => "id_blok"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_blok, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Unit Kelestarian/Petak Kerja...'))))); ?>        
<?php echo $form->select2Group($model, 'id_jenis_produksi_lahan', array('groupOptions' => array('id' => "id_jenis_produksi_lahan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_rkusil, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Tata Ruang...'))))); ?>
<?php #echo $form->select2Group($model, 'id_jenis_lahan', array('groupOptions' => array('id' => "id_jenis_lahan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_jlahan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Jenis Lahan...'))))); ?>
<?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanPembibitan()">Simpan</button>
<?php $this->endWidget(); ?>
<script type="text/javascript">
        $("#RkuBibit_tahun_ke").change(function(){

            //var dataToPost = "{namaBlok:'" + $("#Rku_blok").val() + "',idSektor:" +$("#Rku_sektor option:selected").val()+ "}";
            tahun = $("#RkuBibit_tahun_ke option:selected").val();
            
            $("#RkuBibit_tahun").val(tahun);

             $("#RkuBibit_rkt_ke").val($("#RkuBibit_tahun_ke option:selected").html());
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

    function simpanPembibitan()
    {
        var form = new FormData($("#BibitRKU-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl('/perusahaan/rkuKelestarian/addPembibitan', array('id_rku' => $id_rku)) ?>id_bibit/<?= $id_bibit ?>",
                        success: function (result) {
                            swal(result.header, result.message, result.status).then((ok) => {
                                if (result.status == "success") {
                                    $.fn.yiiGridView.update("rku-pembenihan-grid");
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
