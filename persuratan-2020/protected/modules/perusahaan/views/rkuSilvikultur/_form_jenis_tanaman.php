<?php
$list = CHtml::listData(MasterJenisProduksiLahan::model()->findAll(), 'id', 'jenis_produksi');
$list2 = CHtml::listData(MasterJenisTanaman::model()->findAll(array('order' => 'nama_tanaman')), 'id', 'nama_tanaman');
$jarak = CHtml::listData(MasterJarakTanam::model()->findAll(), 'id', 'jarak_tanam');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-tanaman-form',
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
        <?php echo $form->textFieldGroup($tanaman, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->select2Group($tanaman, 'id_jenis_produksi_lahan', array('labelOptions' => array('label' => 'Tata Ruang'), 'groupOptions' => array('id' => 'jenis_lahan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Tata Ruang')))); ?>

        <?php echo $form->select2Group($tanaman, 'id_jenis_tanaman', array('labelOptions' => array('label' => 'Jenis Tanaman'), 'groupOptions' => array('id' => 'jenis_tanaman'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list2, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Tanaman')))); ?>

        <?php echo $form->textFieldGroup($tanaman, 'daur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Tahun ')); ?>
        <?php echo $form->textFieldGroup($tanaman, 'jarak_tanam', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5','placeholder'=>'Contoh : 3x1')))); ?>

        <?php //echo $form->select2Group($tanaman, 'id_jarak_tanam', array('widgetOptions' => array('options' => array('allowClear' => true), 'data' => $jarak, 'htmlOptions' => array('class' => 'span5')))); ?>
        <p class="help-block">Penulisan koma gunakan titik (.)</p>
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-tanaman-grid");
                                $("#' . Yii::app()->controller->id . '-tanaman-form")[0].reset();
                                $("#jenis_lahan").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_lahan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tanaman");
                                $("#jenis_tanaman").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_tanaman").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Nama Tanaman");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-tanaman-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-tanaman-form #"+key+"_em_").show();
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
    'id' => Yii::app()->controller->id . '-tanaman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $model->search(),
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
            'name' => 'id_jenis_tanaman',
            'header' => 'Jenis Tanaman',
            'value' => '$data->idJenisTanaman->nama_tanaman',
        ),
        array(
            'name' => 'daur',
            'value' => '$data->daur ? $data->daur . " Tahun" : "-"',
        ),
        array(
            'name' => 'jarak_tanam',
            'value' => '$data->jarak_tanam ? $data->jarak_tanam : "-"',
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