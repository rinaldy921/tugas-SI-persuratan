<button type="button" class="btn btn-sm btn-info" id="addInfraMukim">Tambah Data</button>
<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('createBatas'), array('class' => 'btn btn-primary btn-sm')); ?>

<?php
$list = CHtml::listData(MasterJenisInfraMukim::model()->findAll(), 'id', 'nama_sarana');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-inframukim-rkt-form',
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

    <?php echo $form->select2Group($model, 'id_infra_mukim', array('groupOptions' => array('id' => 'nama_sarana'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Infrastruktur Pemukiman')))); ?>

    <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Unit')); ?>

<?php echo $form->textAreaGroup($model, 'keterangan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            $ajaxOptions = array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-inframukim-grid");
                                $("#' . Yii::app()->controller->id . '-inframukim-rkt-form")[0].reset();
                                $("#nama_sarana").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#nama_sarana").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Infrastruktur Pemukiman");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-inframukim-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-inframukim-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit',
                'htmlOptions'   => array(
                    'id'=> 'addButton-inframukim-rkt-form'.time()
                ),
                'context' => 'primary',
                'label' => Yii::t('app', 'Tambah'),
                'ajaxOptions' => $ajaxOptions,
                'size' => 'small',
                'url' => Yii::app()->createUrl('/perusahaan/rktsosInfraMukim/daftarInfraMukim/rkt/'.$rkt)
            ));
            echo ' ';
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'reset',
                'context' => 'default',
                'size' => 'small',
                'htmlOptions'=>array(
                    'onclick'=>'js:$("#nama_sarana").find(".select2-allowclear").removeClass("select2-allowclear");$("#nama_sarana").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Peralatan");',
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
    'id' => Yii::app()->controller->id . '-inframukim-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_infra_mukim',
            'header' => 'Jenis Infrastruktur Pemukiman',
            'value' => '$data->idInfraMukim->nama_sarana',
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah (Unit)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktsosInfraMukim/editJumlahInfraMukim')),
        ),
        'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    // 'options'=>array(
                    //     'id'=>'delete-inframukim'.time(),
                    // ),
                    'url' => 'Yii::app()->createUrl("/perusahaan/rktsosInfraMukim/deleteInfraMukim",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("inframukim", "
$('#addInfraMukim').click(function() {
    $('#" . Yii::app()->controller->id . "-inframukim-rkt-form').toggle();
});

", CClientScript::POS_END);
