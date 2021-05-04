<button type="button" class="btn btn-sm btn-info" id="addNaker">Tambah Data</button>
<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('createBatas'), array('class' => 'btn btn-primary btn-sm')); ?>

<?php
$listPendidikan = CHtml::listData(MasterPendidikan::model()->findAll(), 'id_pendidikan', 'pendidikan');
$listKewarganegaraan = CHtml::listData(MasterJenisKewarganegaraan::model()->findAll(), 'id', 'kewarganegaraan');

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-naker-form',
    'type' => 'horizontal',
    'htmlOptions' => array('style' => 'display:none'),
    'enableClientValidation' => true,
        /* 'clientOptions' => array(
          'validateOnSubmit' => true,
          ),
          'enableAjaxValidation' => false, */
        ));
?>
<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldGroup($model, 'id_rkt', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->dropDownListGroup($model, 'is_tenaga_kehutanan', array('widgetOptions' => array('data' => array("1" => "Tenaga Profesional Kehutanan", "0" => "Tenaga Profesional Lainnya",), 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Tenaga Profesional')))); ?>

        <?php echo $form->dropDownListGroup($model, 'is_tenaga_tetap', array('widgetOptions' => array('data' => array("1" => "Tenaga Tetap", "0" => "Tenaga Tidak Tetap",), 'htmlOptions' => array('class' => 'input-large')))); ?>
        
        <?php echo $form->select2Group($model, 'id_jenis_kewarganegaraan', array('labelOptions' => array('label' => 'Kewarganegaraan'), 'groupOptions' => array('id' => 'kewarganegaraan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listKewarganegaraan, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Kewarganegaraan')))); ?>    
        
        <?php echo $form->select2Group($model, 'id_pendidikan', array('labelOptions' => array('label' => 'Pendidikan'), 'groupOptions' => array('id' => 'pendidikan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listPendidikan, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Pendidikan')))); ?>

        <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Org')); ?>

        <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <?php
                $ajaxOptions = array(
                    'dataType' => 'json',
                    'type' => 'post',
                    'data' => "js:jQuery('form').serialize()",
                    'url' => Yii::app()->createUrl('/perusahaan/rktprasTenagaKerja/index/rkt/' . $id_rkt),
                    'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-naker-grid");
                                $("#' . Yii::app()->controller->id . '-naker-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-batas-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-batas-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
                );
                $ajaxString = CHtml::ajax($ajaxOptions);

                Yii::app()->clientScript->registerScript("submitForm", "
                
                $( '#" . Yii::app()->controller->id . "-naker-form' ).submit(function() {
                    //alert('asalamualaikum');
                    //console.log(jQuery('form').serialize());
                    " . $ajaxString = CHtml::ajax($ajaxOptions) . "
                    return false;
                });
                
            ", CClientScript::POS_END);

                $this->widget('booster.widgets.TbButton', array(
                    'id' => 'dungtan',
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'label' => Yii::t('app', 'Tambah'),
                    'size' => 'small',
                ));

                echo ' ';
                $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'reset',
                    'context' => 'default',
                    'size' => 'small',
                    'htmlOptions' => array(
                    //'onclick' => 'js:$("#jenis_batas").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_batas").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Penataan Batas");',
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
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-naker-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'mergeColumns' => array('is_tenaga_kehutanan', 'is_tenaga_tetap', 'id_jenis_kewarganegaraan'),    
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'is_tenaga_kehutanan',
            //'header' => 'Tenaga Profesional',
            'value' => function($data) {
                if ($data->is_tenaga_kehutanan == '1')
                    return 'Tenaga Professional Kehutanan';
                else
                    return 'Tenaga Professional Lainnya';
            }
        ),
        array(
            'name' => 'is_tenaga_tetap',
            //'header' => 'Jenis Tenaga',
            'value' => function($data) {
                if ($data->is_tenaga_tetap == '1')
                    return 'Tenaga Tetap';
                else
                    return 'Tenaga Tidak Tetap';
            }
        ),
        array(
            'name' => 'id_jenis_kewarganegaraan',
            //'header' => 'Tata Ruang',
            'value' => '$data->idJenisKewarganegaraan->kewarganegaraan',
        ),
        array(
            'name' => 'id_pendidikan',
            //'header' => 'Tata Ruang',
            'value' => '$data->idPendidikan->pendidikan',
        ),
        array(
            'header' => 'Jumlah (Org)',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
//            'footer' => RkuKawasanLindung::model()->getTotal($model->search()->getData(), 'jumlah') . ' Ha',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktprasTenagaKerja/inputSerapanNaker')),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    // 'options'=>array(
                    //     'id'=>'delete-inframukim'.time(),
                    // ),
                    'url' => 'Yii::app()->createUrl("/perusahaan/rktprasTenagaKerja/deleteNaker",array("id"=>$data->id))',
                ),
            )
        ),
        // array(
        //     'header'=>'',
        //     'type'=>'raw',
        //     'value'=>function($data){
        //         return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
        //             'class'=>'deleteInFunction',
        //             'onclick'=>'deleteData(this)', 
        //             'data-url'=> Yii::app()->createUrl("/perusahaan/rktprasTenagaKerja/deleteNaker",array("id"=>$data->id))
        //         ));
        //     }
        // ),                
    )
));
?>

<?php
Yii::app()->clientScript->registerScript("batas", "
$('#addNaker').click(function() {
    $('#" . Yii::app()->controller->id . "-naker-form').toggle();
});
    
", CClientScript::POS_END);
?>
<script type="text/javascript">


    function deleteData(th) {
        //alert($(th).attr("data-url"));
        var urlLink = $(th).attr("data-url");
        if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
            //return true;
            //var th = this,
            afterDelete = function () {};
            jQuery('#<?php echo Yii::app()->controller->id . '-batas-grid' ?>').yiiGridView('update', {
                type: 'POST',
                url: urlLink,
                success: function (data) {
                    jQuery('#<?php echo Yii::app()->controller->id . '-batas-grid' ?>').yiiGridView('update');
                    afterDelete(th, true, data);
                },
                error: function (XHR) {
                    return afterDelete(th, false, XHR);
                }
            });
        } else {
            //return false;
        }
        return false;
    }
</script>