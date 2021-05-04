<div class="panel panel-default">
    <div class="panel-heading"><div class="panel-title"> Pemilihan Sistem Silvikultur </div></div>
    <div class="panel-body">
<?php
$list = CHtml::listData(MasterSistemSilvikultur::model()->findAll(), 'id', 'jenis_silvikultur');
?>
<div id="data">
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>
<?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldGroup($model, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->select2Group($model, 'id_jenis_silvikultur', array('labelOptions' => array('label' => 'Jenis Sistem Silvikultur'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'palceholder' => 'Pilih Sistem Silvikultur')))); ?>

        <?php // echo $form->textFieldGroup($model, 'sistem_silvikultur', array('groupOptions' => array('id' => 'nama_silvikultur'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

        <?php echo $form->textFieldGroup($model, 'jumlah', array('labelOptions' => array('label' => 'Luas'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)), 'append' => ' Ha ')); ?>
        <p class="help-block">Penulisan koma gunakan titik (.)</p>
        <?php $this->endWidget(); ?>
</div>
        <div class="form-group">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'id' => 'subm',
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'size' => 'small',
                    'label' => 'Simpan',
                ));
                ?>
                <div id="load">
                    <img src="<?php echo Yii::app()->baseUrl.'/img/ajax-loader.gif';?>"/>
                    <p class="help-block" style="color:green"> Tersimpan</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-sistem-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $modelSis->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_jenis_silvikultur',
            // 'header' => 'Tata Ruang',
            'value' => '$data->idJenisSilvikultur->jenis_silvikultur',
        ),
        array(
            'name' => 'jumlah'
        ),
        // array(
        //     'name' => 'id_jenis_tanaman',
        //     'header' => 'Jenis Tanaman',
        //     'value' => '$data->idJenisTanaman->nama_tanaman',
        // ),
        // array(
        //     'name' => 'daur',
        //     'value' => '$data->daur ? $data->daur . " Tahun" : "-"',
        // ),
        // array(
        //     'name' => 'jarak_tanam',
        //     'value' => '$data->jarak_tanam ? $data->jarak_tanam : "-"',
        // ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/deleteSistem", array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
<?php
//$cs = Yii::app()->clientScript;
//if (!$model->isNewRecord){
//    $hide = $model->id_jenis_silvikultur!=3 ? "$('#nama_silvikultur').hide();": '';
//}else{
//    $hide = "$('#nama_silvikultur').hide();";
//}
//$cs->registerScript('jenis_silvikultur', "
//$hide 
//$('#RkuSistemSilvikultur_id_jenis_silvikultur').change(function() {
//    var _id = this.value;
//    if (_id == 3) {
//        $('#nama_silvikultur').show('slow');
//        $('#RkuSistemSilvikultur_sistem_silvikultur').attr('value', null);
//    }else{
//        $('#nama_silvikultur').hide('slow');
//    }
//});
//", CClientScript::POS_END);
