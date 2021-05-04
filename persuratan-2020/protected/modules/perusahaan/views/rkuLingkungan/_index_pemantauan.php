<button type="button" class="btn btn-sm btn-info" id="addPemantauan">Tambah</button>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-tauling-form',
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

<?php echo $form->errorSummary($addPemantauan); ?>

<?php echo $form->textFieldGroup($addPemantauan, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($addPemantauan, 'rencana', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($addPemantauan, 'kegiatan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textAreaGroup($addPemantauan, 'keterangan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<div class="form-group">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <?php
        $ajaxOptions = array('dataType' => 'json',
            'type' => 'post',
            'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-tauling-grid");
                                $("#' . Yii::app()->controller->id . '-tauling-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-tauling-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-tauling-form #"+key+"_em_").show();
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
    'id' => Yii::app()->controller->id . '-tauling-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'rencana',
        ),
        array(
            'name' => 'kegiatan',
        ),
        array(
            'name' => 'keterangan',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuLingkungan/deletePemantauan",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("addpemantauan", "
$('#addPemantauan').click(function() {
    $('#" . Yii::app()->controller->id . "-tauling-form').toggle();
});
    
", CClientScript::POS_END);
