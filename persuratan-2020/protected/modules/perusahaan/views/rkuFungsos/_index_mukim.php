<button type="button" class="btn btn-sm btn-info" id="addMukim">Tambah</button>
<?php
$list = CHtml::listData(MasterJenisInfraMukim::model()->findAll(), 'id', 'nama_sarana');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-pemukiman-form',
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

<?php echo $form->errorSummary($addMukim); ?>

<?php echo $form->textFieldGroup($addMukim, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->select2Group($addMukim, 'id_infra_mukim', array('groupOptions' => array('id' => 'framukim'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Infrastruktur')))); ?>

<?php echo $form->textFieldGroup($addMukim, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<div class="form-group">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <?php
        $ajaxOptions = array('dataType' => 'json',
            'type' => 'post',
            'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-pemukiman-grid");
                                $("#' . Yii::app()->controller->id . '-pemukiman-form")[0].reset();
                                $("#framukim").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#framukim").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Infrastruktur");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-pemukiman-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-pemukiman-form #"+key+"_em_").show();
                                });
                            }
                        }'
        );
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'ajaxSubmit', 'context' => 'primary',
            'label' => Yii::t('app', 'Simpan'),
            'ajaxOptions' => $ajaxOptions,
            'size' => 'small',
            'url' => Yii::app()->createUrl('/perusahaan/rkuFungsos/index')
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
    'id' => Yii::app()->controller->id . '-pemukiman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_infra_mukim',
            'header' => 'Jenis',
            'value' => '$data->idInfraMukim->nama_sarana',
        ),
        array(
            'header' => 'Rencana',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuFungsos/inputMukim')),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuFungsos/deleteMukim",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("pmkm", "
$('#addMukim').click(function() {
    $('#" . Yii::app()->controller->id . "-pemukiman-form').toggle();
});
    
", CClientScript::POS_END);
