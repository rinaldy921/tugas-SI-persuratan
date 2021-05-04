<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'direksi-form',
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

<?php echo $form->textFieldGroup($model, 'nama_direksi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'jabatan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <button type="button" class="btn btn-primary" name="button" onclick="saveDireksi()">Simpan</button>
    </div>
</div>
<!-- <div class="form-group">
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
</div> -->

<?php $this->endWidget(); ?>


<script type="text/javascript">
    function saveDireksi()
    {
        <?php if($mode=="create"): ?>
        var url = "<?php echo $this->createUrl('//perusahaan/dirkom/addDireksi', array('id_legalitas' => $id_legalitas));?>";
        <?php else: ?>
        var url = "<?php echo $this->createUrl('//perusahaan/dirkom/updateDireksi', array('id' => $model->id_direksi));?>";
        <?php endif; ?>
        var form = new FormData($("#direksi-form")[0]);
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
                    $.fn.yiiGridView.update("direksi-grid");
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
