<button type="button" class="btn btn-sm btn-info" id="addTekdam">Tambah</button>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-tekdam-form',
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

<?php echo $form->errorSummary($addTekdam); ?>

<?php echo $form->textFieldGroup($addTekdam, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($addTekdam, 'metode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($addTekdam, 'kondisi_kebakaran', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textAreaGroup($addTekdam, 'cara', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<div class="form-group">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <?php
        $ajaxOptions = array('dataType' => 'json',
            'type' => 'post',
            'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-tekdam-grid");
                                $("#' . Yii::app()->controller->id . '-tekdam-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-tekdam-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-tekdam-form #"+key+"_em_").show();
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
    'id' => Yii::app()->controller->id . '-tekdam-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'metode',
            'header' => 'Metode',
        ),
        array(
            'name' => 'kondisi_kebakaran',
            'header' => 'Kondisi Sumber Kebakaran',
        ),
        array(
            'name' => 'cara',
            'header' => 'Cara Penanganan dan Prasarana',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/rkuLingkungan/deleteTekdam",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("tkdmmm", "
$('#addTekdam').click(function() {
    $('#" . Yii::app()->controller->id . "-tekdam-form').toggle();
});
    
", CClientScript::POS_END);
