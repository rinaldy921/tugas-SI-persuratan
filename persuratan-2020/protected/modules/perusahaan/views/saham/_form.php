<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'saham-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php // echo $form->errorSummary($model);  ?>
<?php echo $form->textFieldGroup($modal, 'id_perusahaan', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php
echo $form->radioButtonListGroup($modal, 'jenis', array(
    'widgetOptions' => array(
        'data' => array(
            'PMDN' => 'PMDN',
            'PMA' => 'PMA',
        ),
        'htmlOptions' => array('class' => 'span5')
    )
));
?>
<?php echo $this->renderPartial('_form_saham', array('model' => $model, 'form' => $form)); ?>

<!-- <div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => 'Simpan',
        ));
        ?>
    </div>
</div> -->
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
        var url = "<?php echo $this->createUrl('//perusahaan/saham/create', array('id_legalitas' => $id_legalitas));?>";
        var form = new FormData($("#saham-form")[0]);
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
                    $.fn.yiiGridView.update("saham-saham-grid");
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
