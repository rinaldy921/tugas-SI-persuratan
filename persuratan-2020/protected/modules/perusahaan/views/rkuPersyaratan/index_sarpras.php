<button type="button" class="btn btn-sm btn-info" id="addSarpras">Tambah Data</button>
<?php
$list = CHtml::listData(MasterJenisSarpras::model()->findAll(), 'id', 'jenis_sarpras');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-sarpras-form',
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
        <?php echo $form->textFieldGroup($addSarpras, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
        
            
        <?php echo $form->textFieldGroup($addSarpras, 'nama_sarpras', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php //echo $form->select2Group($addSarpras, 'id_jenis_sarpras', array('groupOptions' => array('id' => 'jenis_sarpras'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Sarpras ')))); ?>

        <?php echo $form->textFieldGroup($addSarpras, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->textAreaGroup($addSarpras, 'keterangan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
        
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-sarpras-grid");
                                $("#' . Yii::app()->controller->id . '-sarpras-form")[0].reset();
                                $("#jenis_sarpras").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_sarpras").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Sarpras");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-sarpras-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-sarpras-form #"+key+"_em_").show();
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
    'id' => Yii::app()->controller->id . '-sarpras-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_sarpras',
            'header' => 'Nama Sarpras',
            'value' => '$data->nama_sarpras',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
            },
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputJumlahSarpras')),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuSarpras::model()->getTotal($model->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Keterangan',
            'name' => 'keterangan',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuPersyaratan/deleteSarpras",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("adsarpras_", "
$('#addSarpras').click(function() {
    $('#" . Yii::app()->controller->id . "-sarpras-form').toggle();
});
    
", CClientScript::POS_END);
