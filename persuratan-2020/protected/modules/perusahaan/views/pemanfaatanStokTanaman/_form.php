<?php
/* @var $this PemanfaatanStokTanamanController */
/* @var $model PemanfaatanStokTanaman */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
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
        //$modelSektor = new RkuSektor();
        $criteria = new CDbCriteria();
        $criteria->condition = 'id_perusahaan=:id';
        $criteria->params = array(':id'=>Yii::app()->user->idPerusahaan());
        $list = CHtml::listData(RkuSektor::model()->findAll($criteria), 'id_sektor', 'nama_sektor');
    
     $urlGetBlok = Yii::app()->createUrl("perusahaan/stoktanaman/getblok"); 

?>

	
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model, 'tahun_tanam', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

    
    
        <div class="form-group">
               <div class="col-sm-3" style="text-align: right">
                           <?php// echo CHtml::activeLabel($model,'sektor');?>
               </div>
               <div class="col-sm-9">
                       <?php //echo  $form->dropDownList($model,'sektor_id',
                                  //                 CHtml::listData(RkuSektor::model()->findAllByAttributes(array('id_perusahaan'=>Yii::app()->user->idPerusahaan())),'id_sektor','nama_sektor'),
                                    //               array('empty'=>'   --- Pilih Unit Kelestarian ---   ') ); ?>

                       <?php // echo $form->labelEx($model,'sektor_id'); ?>
                       <?php //echo $form->textField($model,'sektor_id'); ?>
                       <?php //echo $form->error($model,'sektor_id'); ?>
               </div>
        </div>
    
        <?php echo $form->select2Group($model, 'sektor_id', array('groupOptions' => array('id_sektor' => 'nama_sektor'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Unit Kelestarian')))); ?>

        <?php echo $form->select2Group($model, 'blok_id', array('groupOptions' => array('id_sektor' => 'nama_sektor'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Petak Kerja')))); ?>

        
	
        <?php echo $form->select2Group($model, 'jenis_pemanfaatan', array('widgetOptions' => array('options' => array('allowClear' => true), 'data' => array('0'=>'Produksi', '1' => 'Lainnya'), 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Lahan')))); ?>


    
    
        <?php echo $form->textFieldGroup($model, 'jumlah_luas', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

    

	

	

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Simpan')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->



<script>
    $("#PemanfaatanStokTanaman_sektor_id").change(function(){
            $.ajax({
			type: "POST",
                data:{
                    idSektor:$("#PemanfaatanStokTanaman_sektor_id").val()
                },
                dataType: "json",
                url: "<?php echo $urlGetBlok; ?>",
                success: function(result) {
                    $("#PemanfaatanStokTanaman_blok_id").empty();
                    
                         $.each(result,function(item,index){
                             $("#PemanfaatanStokTanaman_blok_id").append(new Option(index,item));
                            
                         });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        });


</script>