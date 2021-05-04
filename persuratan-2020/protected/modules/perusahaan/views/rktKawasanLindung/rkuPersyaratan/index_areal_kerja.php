 <button type="button" class="btn btn-sm btn-info" id="addKerja">Tambah Data</button>
<?php
Yii::app()->session['arealIDBlok']='';
Yii::app()->session['arealNamaBlok']='';

//$strBlokList = "satu";
//$strIDBlokList = "1";
//$strBlokList2 = "dua";
//$strIDBlokList2 = "2";
//$res=array();
//
//$arrP = array('id'=>$strBlokList,'nama'=>$strIDBlokList);
//$arrP2 = array('id'=>$strBlokList2,'nama'=>$strIDBlokList2);
//array_push($res, $arrP);
//array_push($res, $arrP2);

//$arrBlok = explode(",",$strBlokList);
//

$rkuMstr = Rku::model()->findByPk($arealKerja->id_rku);

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

//print_r("<pre>");
//print_r($arrRktKe);
//print_r("</pre>");exit(1);


$periode_rku = Rku::model()->findByPk($arealKerja->id_rku);
for ($i = $periode_rku->tahun_mulai; $i <= $periode_rku->tahun_sampai; $i++) {
    $tahun[$i] = $i;
}

$list = CHtml::listData(MasterJenisProduksiLahan::model()->findAll(), 'id', 'jenis_produksi');

$select_blok = RkuBlok::model()->findAll(array(
    'condition' => 'id_rku=' . $arealKerja->id_rku
        ));
$list_blok = CHtml::listData($select_blok, 'id', function($model) {
            $gabung = $model->namaSektor->nama_sektor . " | " .
                    $model->nama_blok;
            return $gabung;
        });

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-areal-kerja-form',
    'type' => 'horizontal',
    'htmlOptions'=>array('style'=>'display:none'),
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>

<div class="panel panel-default">
    <div class="panel-heading"><div class="panel-title"> Pengisian Rencana Penataan Areal Kerja </div></div>
    <div class="panel-body">
        <?php echo $form->textFieldGroup($arealKerja, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->textFieldGroup($arealKerja, 'daur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'placeholder' => 'Daur Ke')))); ?>
    
        
    <div class="form-group">    
        <div class="col-sm-3" style="text-align: right">
            <?php echo CHtml::activeLabel($model,'rkt_ke');?>
        </div>
        <div class="col-sm-9">
        <?php    
                    echo $form->dropDownList($model,'tahun_ke',
                                            CHtml::listData($arrRktKe,'tahun','ke'),
                                            array('empty'=>'   --- Pilih Blok Kerja Tahun Ke ---   ') ); 
        
                    
                    echo $form->hiddenField($model,'rkt_ke');	
                    
                    ?>
        
        </div>
    </div>
     
        
        <?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        
        
        <?php //echo $form->select2Group($arealKerja, 'tahun', array('groupOptions' => array('id' => 'tahun'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $tahun, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Tahun ')))); ?>

        <?php #echo $form->textFieldGroup($arealKerja, 'lokasi_rkt', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'placeholder' => 'Lokasi RKT')))); ?>
        
        <?php echo $form->select2Group($model, 'id_blok', array('groupOptions' => array('id' => "id_blok"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_blok, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Unit Kelestarian / Petak Kerja...'))))); ?>        
		
	<!--    Dynamic Blok Only
                <div class="form-group">
                <div class="col-sm-3" style="text-align: right"></div>	
				<div class="col-sm-9"> -->
                    <?php
//                        $urlAdd = Yii::app()->createUrl("perusahaan/rkuPersyaratan/addBlokAreal"); 
//			$urlDelete = Yii::app()->createUrl("perusahaan/rkuPersyaratan/deleteBlokAreal"); 
//                        
//                        $this->widget('booster.widgets.TbButton', array(
//                            'buttonType' => 'button',
//                            'htmlOptions' => array('class' => 'btn-sm','id'=>'btnAddNewBlok'),
//                            'context' => 'primary',
//                            'label' => 'Tambah Blok', 
//
//                        ));
                    ?>
          <!--      </div>
				
		</div>
		
        <div id="dataBlokList">
		<div>
			<div class="col-md-3"></div>
			<div class="col-md-9" id="listDelBlok"></div>
		</div>
         
        </div>    
		
		
		<div>
			<div class="col-md-3">&nbsp;</div>
			<div class="col-md-9">&nbsp;</div>
		</div>
		
		-->
                
                
        <?php echo $form->select2Group($arealKerja, 'id_jenis_produksi_lahan', array('labelOptions' => array('label' => 'Tata Ruang'), 'groupOptions' => array('id' => 'jenis_produksi'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Tata Ruang ')))); ?>

        <?php echo $form->textFieldGroup($arealKerja, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Ha')); ?>

        <div class="col-md-3"></div>
        <div class="col-md-9">
            <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-areal-kerja-grid");
                                $("#' . Yii::app()->controller->id . '-areal-kerja-form")[0].reset();
                                $("#tahun").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#tahun").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Tahun");
                                $("#jenis_produksi").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_produksi").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tanaman");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-areal-kerja-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-areal-kerja-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                'label' => Yii::t('app', 'Tambah'),
                'ajaxOptions' => $ajaxOptions,
                'url' => Yii::app()->createUrl('/perusahaan/rkuPersyaratan/index')
            ));
            echo ' ';
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'reset',
                'context' => 'default',
                'size' => 'small',
//                            'htmlOptions' => array('confirm' => Yii::t('app', 'Form yang telah diisi akan hilang, lanjutkan pembatalan?'), 'class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
                'label' => Yii::t('app', 'Reset'),
            ));
            ?>
        </div>
    </div>

</div>
 
 <script type="text/javascript">
        $("#RkuArealKerja_tahun_ke").change(function(){

            //var dataToPost = "{namaBlok:'" + $("#Rku_blok").val() + "',idSektor:" +$("#Rku_sektor option:selected").val()+ "}";
            tahun = $("#RkuArealKerja_tahun_ke option:selected").val();
            
            $("#RkuArealKerja_tahun").val(tahun);
            $("#RkuArealKerja_rkt_ke").val($("#RkuArealKerja_tahun_ke option:selected").html())

            
       });

</script>


  <script  type="text/javascript"> 
      
	$("#btnAddNewBlok").click(function(){
            document.getElementById('dataBlokList').innerHTML = "";
            
            StrBlok = $("#RkuArealKerja_rku_ke option:selected").val();
            
            $.ajax({
		type: "POST",
                data:{
                    idBlok:$('#s2id_RkuArealKerja_id_blok').select2('data').id,
                    txtBlok:$('#s2id_RkuArealKerja_id_blok').select2('data').text
                },
                dataType: "json",
                url: "<?php echo $urlAdd; ?>",
                success: function(result) {
                   $.each( result.data, function(id,val) {
                        $('#dataBlokList').append('<div><div class="col-md-3"></div><div class="col-md-9">'+val.nama+'<a onclick="deleteBlok('+val.id+')" href="#">[hapus]</a></div></div>');
                      });
                   
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        });

        function deleteBlok(idBlok){
            document.getElementById('dataBlokList').innerHTML = "";
            
            $.ajax({
		type: "POST",
                data:{
                    idBlok:idBlok
                },
                dataType: "json",
                url: "<?php echo $urlDelete; ?>",
                success: function(result) {
                   $.each( result.data, function(id,val) {
                        $('#dataBlokList').append('<div><div class="col-md-3"></div><div class="col-md-9">'+val.nama+'<a onclick="deleteBlok('+val.id+')"  href="#">[hapus]</a></div></div>');
                      });
                   
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        }
        
</script>



<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-areal-kerja-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
//    'mergeColumns' => array('daur', 'tahun', 'sektor', 'blok'),    
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'daur',
        ),
        array(
            'header' => 'Blok Kerja Tahun Ke',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'rkt_ke',
            'type' => 'raw',
            'editable' => array(
                'url' => $this->createUrl('//perusahaan/RkuPersyaratan/inputRktKeArealKerja'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id . '-areal-kerja-grid.");
                }'
            ),
            // 'footer' => '<strong>' . RkuBibitNew::model()->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'name' => 'tahun',
            'header' => 'Blok Kerja Tahun',
            'footer' => '<strong>Total</strong>',
        ),
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),        
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'header' => 'Jumlah (Ha)',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
//            'footer' => RkuKawasanLindung::model()->getTotal($model->search()->getData(), 'jumlah') . ' Ha',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputArealkerja')),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuPersyaratan/deleteArealKerja",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("addkerja", "
$('#addKerja').click(function() {
    $('#" . Yii::app()->controller->id . "-areal-kerja-form').toggle();
});
    
", CClientScript::POS_END);