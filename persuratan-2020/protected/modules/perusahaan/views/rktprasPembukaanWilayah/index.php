<button type="button" class="btn btn-sm btn-info" id="addPembukaanWilayah">Tambah Data</button>
<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('createBatas'), array('class' => 'btn btn-primary btn-sm')); ?>

<?php
$list = CHtml::listData(MasterJenisPwh::model()->findAll(), 'id', 'jenis_pembukaan');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-pwh-rkt-form',
    'type' => 'horizontal',
    'htmlOptions'=>array('style'=>'display:none'),
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

    <?php echo $form->select2Group($model, 'id_pwh', array('groupOptions' => array('id' => 'jenis_pembukaan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Pembukaan Wilayah Hutan')))); ?>

    <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Km/Buah')); ?>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
        <?php
        $ajaxOptions = array(
                'dataType' => 'json',
                'type' => 'post',
                'data'=>"js:jQuery('form').serialize()",
                 'url' => Yii::app()->createUrl('/perusahaan/rktprasPembukaanWilayah/index/rkt/'.$id_rkt),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-pwh-grid");
                                $("#' . Yii::app()->controller->id . '-pwh-rkt-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-pwh-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-pwh-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $ajaxString = CHtml::ajax($ajaxOptions);
            
            Yii::app()->clientScript->registerScript("submitForm", "
                
                $( '#".Yii::app()->controller->id . "-pwh-rkt-form' ).submit(function() {
                    //alert('asalamualaikum');
                    //console.log(jQuery('form').serialize());
                    ".$ajaxString = CHtml::ajax($ajaxOptions)."
                    return false;
                });
                
            ", CClientScript::POS_END);
            
            $this->widget('booster.widgets.TbButton', array(
                'id'=>'dungtan',
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
                'htmlOptions'=>array(
                    'onclick'=>'js:$("#jenis_pembukaan").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_pembukaan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Pembukaan Wilayah Hutan");',
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
    'id' => Yii::app()->controller->id . '-pwh-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_pwh',
            'header' => 'Jenis Pembukaan',
            'value' => '$data->idPwh->jenis_pembukaan',
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah (Km/Buah)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktprasPembukaanWilayah/editJumlahPwh')),
        ),
        array(
            'header'=>'',
            'type'=>'raw',
            'value'=>function($data){
                return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
                    'class'=>'deleteInFunction',
                    'onclick'=>'deleteData(this)', 
                    'data-url'=> Yii::app()->createUrl("/perusahaan/rktprasPembukaanWilayah/deletePembukaanWilayah",array("id"=>$data->id))
                ));
            }
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("pembukaanwilayah", "
$('#addPembukaanWilayah').click(function() {
    $('#" . Yii::app()->controller->id . "-pwh-rkt-form').toggle();
});
    
", CClientScript::POS_END);
?>
<script type="text/javascript">


    function deleteData(th){
        //alert($(th).attr("data-url"));
        var urlLink = $(th).attr("data-url");
        if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
            //return true;
            //var th = this,
            afterDelete = function(){};
            jQuery('#<?php echo Yii::app()->controller->id . '-pwh-grid' ?>').yiiGridView('update', {
                type: 'POST',
                url: urlLink,
                success: function(data) {
                    jQuery('#<?php echo Yii::app()->controller->id . '-pwh-grid' ?>').yiiGridView('update');
                    afterDelete(th, true, data);
                },
                error: function(XHR) {
                    return afterDelete(th, false, XHR);
                }
            });
          } else {
            //return false;
          }
        return false;
    }
</script>