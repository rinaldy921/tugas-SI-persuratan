<button type="button" class="btn btn-sm btn-info" id="addDamkar">Tambah</button>
<?php
$list = CHtml::listData(MasterJenisDalkar::model()->findAll(), 'id', 'jenis_dalkar');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-damkar-form',
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

<?php echo $form->errorSummary($addAlatDamkar); ?>

<?php echo $form->textFieldGroup($addAlatDamkar, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->select2Group($addAlatDamkar, 'id_damkar', array('groupOptions' => array('id' => 'alat_dalkar'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Alat')))); ?>

<?php echo $form->textFieldGroup($addAlatDamkar, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textAreaGroup($addAlatDamkar, 'keterangan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<div class="form-group">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <?php
        $ajaxOptions = array('dataType' => 'json',
            'type' => 'post',
            'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-damkar-grid");
                                $("#' . Yii::app()->controller->id . '-damkar-form")[0].reset();
                                $("#alat_dalkar").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#alat_dalkar").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Alat");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-damkar-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-damkar-form #"+key+"_em_").show();
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
    'id' => Yii::app()->controller->id . '-damkar-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_damkar',
            'header' => 'Jenis Alat',
            'value' => '$data->idDamkar->jenis_dalkar'
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuLingkungan/inputDamkar')),
        ),
        array(
            'name' => 'keterangan',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuLingkungan/deleteDamkar",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("altdm", "
$('#addDamkar').click(function() {
    $('#" . Yii::app()->controller->id . "-damkar-form').toggle();
});
    
", CClientScript::POS_END);
