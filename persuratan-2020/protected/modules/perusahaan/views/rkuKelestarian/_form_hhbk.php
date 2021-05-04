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

$dateJs  = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
    <!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
    <link rel="stylesheet" type="text/css" href="<?=$dateCss?>" />
    <script type="text/javascript" src="<?=$dateJs?>"></script>

<?php
$select_rkusil = RkuHasilHutanNonkayuSilvikultur::model()->findAll(array(
    'condition' => 'id_rku=' . $id_rku
        ));
$list_rkusil = CHtml::listData($select_rkusil, 'id', function($model){
    $gabung = $model->idJenisProduksiLahan->jenis_produksi . " | ".
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


    <?php echo $form->select2Group($model, 'id_hasil_hutan_nonkayu_silvikultur', array('groupOptions' => array('id' => "idJenisProduksiLahan.jenis_produksi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_rkusil, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih ...'))))); ?>
    <?php echo $form->textFieldGroup($model,'tahun',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>
    <?php echo $form->textFieldGroup($model,'luas',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>
    <?php echo $form->textFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>
    <button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanHHBK()">Simpan</button>

<?php $this->endWidget(); ?>

    
<script type="text/javascript">
        $("#RkuHasilHutanNonkayu_tahun_ke").change(function(){

            //var dataToPost = "{namaBlok:'" + $("#Rku_blok").val() + "',idSektor:" +$("#Rku_sektor option:selected").val()+ "}";
            tahun = $("#RkuHasilHutanNonkayu_tahun_ke option:selected").val();
            
            $("#RkuHasilHutanNonkayu_tahun").val(tahun);

            

             $("#RkuHasilHutanNonkayu_rkt_ke").val($("#RkuHasilHutanNonkayu_tahun_ke option:selected").html());
       });

</script>


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
            url: "<?=Yii::app()->createUrl("/perusahaan/rkuKelestarian/addHhbk",array('id_rku'=>$id_rku))?>?id_hhbk=<?=$id_hhbk?>",
            success: function(result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if(result.status == "success") {
                        $.fn.yiiGridView.update("rku-hhbk-grid");
                        $("#modal").modal("hide");
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
