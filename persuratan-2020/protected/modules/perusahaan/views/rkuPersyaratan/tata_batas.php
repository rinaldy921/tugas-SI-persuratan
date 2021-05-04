<button type="button" class="btn btn-sm btn-info" id="addBatas">Tambah Data</button>
<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('createBatas'), array('class' => 'btn btn-primary btn-sm')); ?>

<?php
$list = CHtml::listData(MasterJenisBatas::model()->findAll(), 'id', 'jenis_batas');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-tatabatas-form',
    'type' => 'horizontal',
    'htmlOptions'=>array('style'=>'display:none'),
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

    <?php echo $form->errorSummary($new_tata_batas); ?>

    <?php echo $form->textFieldGroup($new_tata_batas, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->select2Group($new_tata_batas, 'id_jenis_batas', array('groupOptions' => array('id' => 'jenis_batas'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Tata Batas')))); ?>

    <?php echo $form->textFieldGroup($new_tata_batas, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Km')); ?>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-tata-batas-grid");
                                $("#' . Yii::app()->controller->id . '-tatabatas-form")[0].reset();
                                $("#jenis_batas").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_batas").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tata Batas");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-tatabatas-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-tatabatas-form #"+key+"_em_").show();
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
                'htmlOptions'=>array(
                    'onclick'=>'js:$("#jenis_batas").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_batas").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tata Batas");',
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
    'id' => Yii::app()->controller->id . '-tata-batas-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $tata_batas->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => true,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_batas',
            'header' => 'Jenis Batas',
            'value' => '$data->idJenisBatas->jenis_batas',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Km)',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'name' => 'jumlah',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputTataBatas')),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
//            'value' => '$data->jumlah ? $data->jumlah . " Km" : "-"',
            'footer' => '<strong>' . number_format(RkuTataBatas::model()->getTotal($tata_batas->search()->getData(), 'jumlah'),2,",",".") . ' </strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/perusahaan/rkuPersyaratan/deleteBatas",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("addbatas", "
$('#addBatas').click(function() {
    $('#" . Yii::app()->controller->id . "-tatabatas-form').toggle();
});
    
", CClientScript::POS_END);