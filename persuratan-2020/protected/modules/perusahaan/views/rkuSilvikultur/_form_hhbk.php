<?php
$list = CHtml::listData(MasterJenisProduksiLahan::model()->findAll(), 'id', 'jenis_produksi');
$list2 = CHtml::listData(MasterHasilHutanNonkayu::model()->findAll(array('order' => 'nama_hhbk')), 'id', 'nama_hhbk');
$list3 = CHtml::listData(SatuanVolumeNonkayu::model()->findAll(array('order' => 'satuan')), 'id', 'satuan');

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-hhbk-form',
    'type' => 'horizontal',
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
        <?php echo $form->textFieldGroup($model_hhbk, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
        <?php echo $form->select2Group($model_hhbk, 'id_jenis_produksi_lahan', array('labelOptions' => array('label' => 'Tata Ruang'), 'groupOptions' => array('id' => 'jenis_lahan2'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Tata Ruang')))); ?>
        <?php echo $form->select2Group($model_hhbk, 'id_hasil_hutan_nonkayu', array('labelOptions' => array('label' => 'Jenis HHBK'), 'groupOptions' => array('id' => 'nama_hhbk'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list2, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis HHBK')))); ?>
        <?php echo $form->select2Group($model_hhbk, 'id_satuan_volume_nonkayu', array('labelOptions' => array('label' => 'Satuan'), 'groupOptions' => array('id' => 'satuan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list3, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Satuan')))); ?>

        <?php //echo $form->select2Group($tanaman, 'id_jarak_tanam', array('widgetOptions' => array('options' => array('allowClear' => true), 'data' => $jarak, 'htmlOptions' => array('class' => 'span5')))); ?>
        <p class="help-block">Penulisan koma gunakan titik (.)</p>
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-hhbk-grid");
                                $("#' . Yii::app()->controller->id . '-hhbk-form")[0].reset();
                                $("#jenis_lahan2").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_lahan2").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Tata Ruang");
                                $("#nama_hhbk").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#nama_hhbk").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis HHBK");
                                $("#satuan").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#satuan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Satuan");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-hhbk-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-hhbk-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                'label' => Yii::t('app', 'Tambah'),
                'size' => 'small',
                'ajaxOptions' => $ajaxOptions,
                'url' => Yii::app()->createUrl('/perusahaan/rkuSilvikultur/create')
            ));
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
    'id' => Yii::app()->controller->id . '-hhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $model_hhbk2->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'id_hasil_hutan_nonkayu',
            'header' => 'Jenis HHBK',
            'value' => '$data->idHasilHutanNonkayu->nama_hhbk',
        ),
        array(
            'name' => 'id_satuan_volume_nonkayu',
            'header' => 'Satuan',
            'value' => '$data->idSatuanVolumeNonkayu->satuan',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                ),
            )
        ),
    )
));
?>
