<?php
$list = CHtml::listData(MasterProgresTataBatas::model()->findAll(), 'id_progres_tata_batas', 'nama_progres_tata_batas');
?>
<div class="panel panel-info">
    <?php
    $urlKeterangan = Yii::app()->createUrl("perusahaan/progresTataBatas/getKeterangan"); 
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => Yii::app()->controller->id . '-form',
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

    <div class="panel-body">
        <p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->select2Group($model, 'id_progres_tata_batas', array('groupOptions' => array('id_progres_tata_batas' => 'nama_progres_tata_batas'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('placeholder' => 'Pilih Progres Tata Batas')))); ?>
        <div id="keterangan_tata_batas" style="display: none">    
            <?php echo  $form->select2Group($model,'id_ket_progres_tata_batas',array('0'=>'--- Pilih Progres Tata Batas ---')); ?>
        </div>           
        <?php echo $form->textFieldGroup($model, 'nomor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
            <?php echo $form->datePickerGroup($model,'tanggal',array('widgetOptions'=>array(
            'options'=>array(
                'format'=>'yyyy-mm-dd',
                'startView'=>0,
                'minViewMode'=>0,
                'autoclose'=>true,
                'todayHighlight'=>true,
            ),
            'htmlOptions'=>array('class'=>'span5')), 
            'append'=>'<i class="glyphicon glyphicon-calendar"></i>',
            )); 
            ?>  
        <?php echo $form->textFieldGroup($model, 'keterangan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Upload Sertifikat </label>
            <div class="col-sm-9">
            <div class="input-group">
                <input name="pdf_progres_TB" type="file">
            </div>
            <i>Ukuran File Maksimal 2 Mb</i>
            <br>
            <?php
                //{
                   if(!is_null($model->file_doc)) {
//                        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                        echo "Dokumen Progres TB : <a href='".Yii::app()->createUrl("/").$model->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    }
                //}
            ?>
            </div>
        </div>
    
    </div>
    <div class="panel-footer">

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
        <!--  </div> -->
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

    
    
    $("#ProgresTataBatas_id_progres_tata_batas").change(function(){
            
        var resultSelect = $("#ProgresTataBatas_id_progres_tata_batas option:selected").val();
        //alert(resultSelect);
        $('#ProgresTataBatas_id_ket_progres_tata_batas').empty();
        $('#ProgresTataBatas_id_ket_progres_tata_batas').append('<option value="0" > --- Pilih Progres Tata Batas ---</option>');
        $("#ProgresTataBatas_id_ket_progres_tata_batas").val("0").change();
        
        $.ajax({
            type: "POST",
            data: 'idKet='+resultSelect,
            dataType: "json",
            url: "<?php echo $urlKeterangan; ?>",
            success: function(result) {
                 i=0;
                 res = result.data;
                 res.forEach(function(item){
                     $('#ProgresTataBatas_id_ket_progres_tata_batas').append('<option value="'+item.id+'" >'+item.ket+'</option>');
                    
                     
//                     if(i == 0){
//                         $('#ProgresTataBatas_id_ket_progres_tata_batas').remove();
//                     }  
                      i++;
                });

            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal("Error submiting!", xhr.responseText, "error");
            }
        });
            
        if(resultSelect == 2 || resultSelect == 3){    
             $('#keterangan_tata_batas').show();
        }
        else{
            $('#keterangan_tata_batas').hide();
        }
        
    });
    
</script>
