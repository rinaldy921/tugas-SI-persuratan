<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        // 'validateOnType'=>false,
    ),
    'enableAjaxValidation' => false,
        ));
$rkt = Rkt::model()->findAll(array('condition'=>'id_rku = '.$rkuSebelum->id_rku));
?>
<?php
$listRkt = CHtml::listData(Rkt::model()->findAll(array('condition'=>'id_rku = '.$rkuSebelum->id_rku)),'id','nomor_sk');
$list = CHtml::listData(MasterKelasPerusahaan::model()->findAll(), 'id_kelas_perusahaan', 'nama_kelas_perusahaan');
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php //echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model,'tahun_mulai',array('widgetOptions'=>array('htmlOptions'=>array('value'=>$rkuSebelum->tahun_mulai, 'class'=>'span5','maxlength'=>100,'readonly'=>true)))); ?>

<?php echo $form->textFieldGroup($model,'tahun_sampai',array('widgetOptions'=>array('htmlOptions'=>array('value'=>$rkuSebelum->tahun_sampai, 'class'=>'span5','maxlength'=>100,'readonly'=>true)))); ?>

<?php echo $form->datePickerGroup($model,'mulai_berlaku',array('widgetOptions'=>array(
        'options'=>array(
            'format'=>'yyyy-mm-dd',
            'startView'=>0,
            'minViewMode'=>0,
            'autoclose'=>true,
            'todayHighlight'=>true,
            // 'beforeShowYear'=> 'js:function (date){
            //     var mulai = '.$rkuSebelum->tahun_mulai.';
            //     var sampai = '.$rkuSebelum->tahun_sampai.';
            //     if (date.getFullYear() < mulai) {
            //         return false;
            //     }
            //     if(date.getFullYear() >= sampai) {
            //         return false;
            //     }
            // }',

        ),
        'events'=>array(
            'change' => 'js:function(date) {
                $("#Rku_akhir_berlaku").val("");
            }'
        ),
        // 'events'=>array(
        //  'changeDate'=>'js:function(e, date){
        //      e.preventDefault();
        //      var tahun = $("#Rkt_tahun_mulai").val();
        //      if(tahun !== "") {
        //          var a = new Date(tahun).getFullYear();
        //          var b = new Date(this.value).getFullYear();
        //          if(b < a) {
        //              alert("Tanggal mulai berlaku tidak boleh kurang dari tahun mulai.");
        //              $(this).focus();
        //              $(this).datepicker("update","2016-02-15");
        //          }
        //      } else {
        //          alert("Silahkan pilih tahun mulai terlebih dahulu");
        //          $("#Rkt_tahun_mulai").focus();
        //      }
        //  }',
        // ),
        'htmlOptions'=>array('class'=>'span5')), 'append'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>

    <?php echo $form->datePickerGroup($model,'akhir_berlaku',array('widgetOptions'=>array(
        'options'=>array(
            'format'=>'yyyy-mm-dd',
            'startView'=>0,
            'minViewMode'=>0,
            'autoclose'=>true,
            'todayHighlight'=>true,
            'showOnFocus'=>true,
            // 'beforeShowYear'=> 'js:function (date){
            //     var mulai = '.$rkuSebelum->tahun_mulai.';
            //     var sampai = '.$rkuSebelum->tahun_sampai.';
            //     if (date.getFullYear() < mulai) {
            //         return false;
            //     }
            //     if(date.getFullYear() >= sampai) {
            //         return false;
            //     }
            // }',

        ),
        'events'=>array(
            'change'=>'js:function(date){
                var mulai = $("#Rku_mulai_berlaku").val();
                if(mulai !== "") {
                    var sampai = new Date(this.value);
                    var mulai = new Date(mulai);
                        // alert(sampai);

                    if(sampai <= mulai) {
                        $("#Rku_akhir_berlaku").datepicker("hide");
                        alert("Tanggal akhir berlaku tidak boleh kurang atau sama dengan tanggal awal berlaku");
                        $("#Rku_akhir_berlaku").datepicker("update","");
                        // $("#Rku_akhir_berlaku").focus();
                        // $("#Rku_akhir_berlaku").datepicker("show");
                    }
                } else {
                    alert("Silahkan pilih tanggal mulai berlaku terlebih dahulu");
                    $("#Rku_mulai_berlaku").focus();
                }
            }',
        ),
        'htmlOptions'=>array('class'=>'span5')), 'append'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>

<?php //echo $form->textFieldGroup($model, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php //echo $form->textFieldGroup($model, 'id_perusahaan', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'nomor_sk', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php echo $form->datePickerGroup($model, 'tgl_sk', array('widgetOptions' => array('options' => array('format' => 'yyyy-mm-dd', 'autoclose' => true, 'todayHighlight' => true), 'htmlOptions' => array('class' => 'span5')), 'append' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

<?php echo $form->select2Group($model, 'id_kelas_perusahaan', array('groupOptions' => array('id_kelas_perusahaan' => 'nama_kelas_perusahaan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Kelas Perusahaan')))); ?>

<!-- <div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File SK (PDF) <span style="color:red">*</span> </label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_sk" type="file">
        </div>
    </div>
</div> -->

<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File SK (PDF)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_sk" type="file">
        </div>
            <i>Ukuran File Maksimal 2 Mb</i>
        <br>
        <?php
                if(!is_null($model->file_doc)) {
//                    $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                    $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                    $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                    echo "File SK: <a href='".Yii::app()->createUrl('/').$model->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                }
        ?>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File Peta SHP (ZIP)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="shp_map" type="file">
        </div>
            <i>Ukuran File Maksimal 20 Mb</i>
        <br>
        <?php
                if(!is_null($model->file_shp)) {
//                    $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                    $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                    $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                    echo "File SHP: <a href='".Yii::app()->createUrl('/').$model->file_shp."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                }
        ?>
    </div>
</div>




<?php
    if($rkt) {
        echo '<div class="col-md-9 col-md-offset-3">';
        echo '<p>Terdapat data RKT untuk revisi RKU ini. <br>Klik <strong>Ya</strong> atau <strong>Tidak</strong> untuk men-duplikat data RKT sebelumnya.</p>';
        echo '</div>';
        echo $form->radioButtonListGroup(
            $model,
            'checkbox',
            array(
                'labelOptions'=>array('label'=>''),
                'widgetOptions' => array(
                    'data' => array(
                        'Ya',
                        'Tidak',
                    ),
                    // 'htmlOptions'=>array('class'=>'span5')
                ),
                'inline'=>true,
                // 'hint' => 'Terdapat data RKT untuk revisi RKU ini. Klik Ya untuk generate atau tidak untuk membuat data RKT baru.'
            )
        );
    }
?>


<div class="form-group" id="dataRktList" style="display: none">
       <?php echo $form->select2Group($model, 'idRktCopy', array('groupOptions' => array('id' => 'nomor_sk'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listRkt, 'htmlOptions' => array('class' => '', 'placeholder' => '--- Pilih RKT ---')))); ?>


        <?php //echo  $form->dropDownList($model,'idRktCopy',
              //                              CHtml::listData(Rkt::model()->findAllByAttributes(array('id_rku'=>$rkuSebelum->id_rku)),'id','nomor_sk'),
              //                              array('empty'=>'   ---   Pilih RKT  ---   ') ); ?>
          
</div>



<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Simpan' : 'Simpan',
        ));
        echo ' ';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'danger',
            'size' => 'medium',
            'htmlOptions' => array('class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
            'label' => Yii::t('app', 'Batal'),
        ));
        ?>
    </div>
</div>





<?php $this->endWidget(); ?>


<script>

$("input[id='Rku_checkbox_0']").click(function(){
            
           //     alert("Your are clicked " );
                $("#dataRktList").show();
           
        });


function deleteRkt(idBlok){
            document.getElementById('dataRktList').innerHTML = "";
         
                        $('#dataBlokList').append('<div><div class="col-md-3"></div><div class="col-md-9">'+val.nama+'<a onclick="deleteBlok('+val.id+')"  href="#">[hapus]</a></div></div>');
            
        }
        
</script>