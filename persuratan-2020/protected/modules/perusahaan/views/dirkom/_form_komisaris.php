<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'komisaris-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'perusahaan_id', array('groupOptions' => array('class' => 'hidden'),'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => Yii::app()->user->idPerusahaan())))); ?>

<?php echo $form->textFieldGroup($model, 'nama_komisaris', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'jabatan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <button type="button" class="btn btn-primary" name="button" onclick="saveKomisaris()">Simpan</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function saveKomisaris()
    {
        <?php if($mode=="create"): ?>
        var url = "<?php echo $this->createUrl('//perusahaan/dirkom/addKomisaris', array('id_legalitas' => $id_legalitas));?>";
        <?php else: ?>
        var url = "<?php echo $this->createUrl('//perusahaan/dirkom/updateKomisaris', array('id' => $model->id_komisaris));?>";
        <?php endif; ?>
        var form = new FormData($("#komisaris-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            url: url,
            success: function(result) {
                swal(result.header, result.message, result.status);
                if (result.status == "success") {
                    $.fn.yiiGridView.update("komisaris-grid");
                    //$("#modalkebutuhan").modal("hide");
                    $("#modal").modal("hide");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal("Error submiting!", xhr.responseText, "error");
            }
        });
    }
</script>
