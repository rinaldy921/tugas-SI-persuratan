<button type="button" class="btn btn-sm btn-info" id="addArealEfektif">Tambah Data</button>
<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('createBatas'), array('class' => 'btn btn-primary btn-sm')); ?>

<?php
$list = CHtml::listData(MasterJenisProduksiLahan::model()->findAll(), 'id', 'jenis_produksi');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-arealefektif-rkt-form',
    'type' => 'horizontal',
    'htmlOptions'=>array(
        'style'=>'display:none',
        'onsubmit' =>'return false;'
    ),
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
    <p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldGroup($model, 'id_rkt', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->select2Group($model, 'id_jenis_produksi_lahan', array('groupOptions' => array('id' => 'jenis_produksi'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Lahan')))); ?>

    <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Ha')); ?>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            $ajaxOptions = array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-arealefektif-grid");
                                $("#' . Yii::app()->controller->id . '-arealefektif-rkt-form")[0].reset();
                                $("#jenis_produksi").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_produksi").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Lahan");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-arealefektif-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-arealefektif-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit',
                'htmlOptions'   => array(
                    'id'=> 'addButton-arealefektif-rkt-form'.time()
                ),
                'context' => 'primary',
                'label' => Yii::t('app', 'Tambah'),
                'ajaxOptions' => $ajaxOptions,
                'size' => 'small',
                'url' => Yii::app()->createUrl('/perusahaan/rktprasArealEfektif/daftarArealEfektif/rkt/'.$rkt)
            ));
            echo ' ';
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'reset',
                'context' => 'default',
                'size' => 'small',
                'htmlOptions'=>array(
                    'onclick'=>'js:$("#jenis_produksi").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_produksi").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Lahan");',
                ),
//                            'htmlOptions' => array('confirm' => Yii::t('app', 'Form yang telah diisi akan hilang, lanjutkan pembatalan?'), 'class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
                'label' => Yii::t('app', 'Reset'),
            ));
            ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
    </div>
</div>

    <?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-arealefektif-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah (Ha)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktprasArealEfektif/editJumlahArealEfektif')),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    // 'options'=>array(
                    //     'id'=>'delete-arealefektif'.time(),
                    // ),
                    'url' => 'Yii::app()->createUrl("/perusahaan/rktprasArealEfektif/deleteArealEfektif",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("arealefektif", "
$('#addArealEfektif').click(function() {
    $('#" . Yii::app()->controller->id . "-arealefektif-rkt-form').toggle();
});

", CClientScript::POS_END);