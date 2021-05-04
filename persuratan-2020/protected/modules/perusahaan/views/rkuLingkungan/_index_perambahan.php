<button type="button" class="btn btn-sm btn-info" id="addPerambahan">Tambah</button>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-perambahan-form',
    'type' => 'horizontal',
    'htmlOptions' => array('style' => 'display:none;'),
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($addPerambahan); ?>

<?php echo $form->textFieldGroup($addPerambahan, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textAreaGroup($addPerambahan, 'perlindungan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<div class="form-group">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <?php
        $ajaxOptions = array('dataType' => 'json',
            'type' => 'post',
            'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-perambahan-grid");
                                $("#' . Yii::app()->controller->id . '-perambahan-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-perambahan-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-perambahan-form #"+key+"_em_").show();
                                });
                            }
                        }'
        );
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'ajaxSubmit', 'context' => 'primary',
            'label' => Yii::t('app', 'Simpan'),
            'ajaxOptions' => $ajaxOptions,
            'size' => 'small',
            'url' => Yii::app()->createUrl('/perusahaan/rkuLingkungan/index')
        ));
        echo ' ';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'default',
            'size' => 'small',
            'label' => Yii::t('app', 'Reset'),
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-perambahan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'perlindungan',
            'header' => 'Jenis Perlindungan',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuLingkungan/deletePerambahan",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("prmmhh", "
$('#addPerambahan').click(function() {
    $('#" . Yii::app()->controller->id . "-perambahan-form').toggle();
});
    
", CClientScript::POS_END);
