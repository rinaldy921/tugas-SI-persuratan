<button type="button" class="btn btn-sm btn-info" id="addPwh">Tambah Data</button>
<?php
$list = CHtml::listData(MasterJenisPwh::model()->findAll(), 'id', 'jenis_pembukaan');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-pwh-form',
    'type' => 'horizontal',
    'htmlOptions' => array('style' => 'display:none;'),
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>

<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <?php echo $form->textFieldGroup($addPwh, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->select2Group($addPwh, 'id_jenis_pwh', array('groupOptions' => array('id' => 'jenis_pwh'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih PWH ')))); ?>

        <?php echo $form->textFieldGroup($addPwh, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <div class="col-md-3"></div>
        <div class="col-md-9">
            <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-pwh-grid");
                                $("#' . Yii::app()->controller->id . '-pwh-form")[0].reset();
                                $("#jenis_pwh").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_pwh").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis PWH");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-pwh-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-pwh-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                'label' => Yii::t('app', 'Simpan'),
                'ajaxOptions' => $ajaxOptions,
                'size' => 'small',
                'url' => Yii::app()->createUrl('/perusahaan/rkuPersyaratan/index')
            ));
            echo ' ';
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'reset',
                'context' => 'default',
                'size' => 'small',
//                            'htmlOptions' => array('confirm' => Yii::t('app', 'Form yang telah diisi akan hilang, lanjutkan pembatalan?'), 'class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
                'label' => Yii::t('app', 'Reset'),
            ));
            ?>
        </div>
    </div>

</div>

<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-pwh-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_jenis_pwh',
            'header' => 'Jenis Pembukaan',
            'value' => '$data->idJenisPwh->jenis_pembukaan',
        ),
        array(
            'header' => 'Jumlah (meter)',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputJumlahPwh')),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuPersyaratan/deletePwh",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("load_nav_script", "
$('#addPwh').click(function() {
    $('#" . Yii::app()->controller->id . "-pwh-form').toggle();
});
    
", CClientScript::POS_END);
