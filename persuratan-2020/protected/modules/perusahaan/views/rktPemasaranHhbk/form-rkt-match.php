<?php

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    // 'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));


?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php //echo $form->textFieldGroup($model, 'daur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, 'rkt_ke', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>


<?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, 'id_hasil_hutan_nonkayu_silvikultur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>

<?php  echo $form->textFieldGroup($model, 'id_jenis_pasar', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50, 'readonly' => true)))); ?>


<?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo CHtml::activeHiddenField($model, 'id_rkt'); ?>


<?php //echo $form->textFieldGroup($model, 'telepon_kontak', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>



<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <button type="button" name="button" class="btn btn-success" onclick="simpanRKT()">Simpan RKT</button>
        <?php
        /*$this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'success',
            'label' => 'Simpan RKT',
        )); 
         * 
         */
        
        echo ' &nbsp;&nbsp;&nbsp;';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'danger',
            'label' => Yii::t('app', 'Kembali'),
            'htmlOptions' => array('onclick' => 'toggleFormRKTByRKU("#form-rkt","#select-rku","'.$this->createUrl('//perusahaan/rktPemasaran/pilihRKU/tahun/'.$modelRKU->tahun).'")'),
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function simpanRKT()
    {
        var form = new FormData($("#<?=Yii::app()->controller->id . '-form';?>")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?= Yii::app()->createUrl("/perusahaan/rktPemasaranHhbk/formRktMatch/rku/".$modelRKU->id); ?>",
            success: function(result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if(result.status == "success") {
                        $.fn.yiiGridView.update("rkt-pemasaranHhbk-grid");
                        $("#modal").modal("hide");
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