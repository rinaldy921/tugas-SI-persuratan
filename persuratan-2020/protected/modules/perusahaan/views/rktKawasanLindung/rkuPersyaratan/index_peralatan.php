<button type="button" class="btn btn-sm btn-info" id="addAlat">Tambah Data</button>
<?php
$list = CHtml::listData(MasterJenisPeralatan::model()->findAll(), 'id', 'jenis_peralatan');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-peralatan-form',
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
        <?php echo $form->textFieldGroup($addPeralatan, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
 
            
        <?php echo $form->textFieldGroup($addPeralatan, 'nama_peralatan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php //echo $form->select2Group($addPeralatan, 'id_peralatan', array('groupOptions' => array('id' => 'jenis_peralatan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Tata Ruang ')))); ?>

        <?php echo $form->textFieldGroup($addPeralatan, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->textAreaGroup($addPeralatan, 'keterangan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <div class="col-md-3"></div>
        <div class="col-md-9">
            <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-peralatan-grid");
                                $("#' . Yii::app()->controller->id . '-peralatan-form")[0].reset();
                                $("#jenis_peralatan").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_peralatan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Peralatan");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-peralatan-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-peralatan-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                'label' => Yii::t('app', 'Tambah'),
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
    'id' => Yii::app()->controller->id . '-peralatan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_peralatan',
            'header' => 'Nama Peralatan',
            'value' => '$data->nama_peralatan',
        ),
        array(
            'header' => 'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputJumlahPeralatan')),
        ),
        'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuPersyaratan/deletePeralatan",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("addperalatan", "
$('#addAlat').click(function() {
    $('#" . Yii::app()->controller->id . "-peralatan-form').toggle();
});
    
", CClientScript::POS_END);
