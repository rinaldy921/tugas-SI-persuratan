<button type="button" class="btn btn-sm btn-info" id="addSarpras">Tambah Data</button>
<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('createBatas'), array('class' => 'btn btn-primary btn-sm')); ?>

<?php

$pilihan = array('0'=>'Pilih Sarana Prasarana Tidak Sesuai RKU', '1'=>'Pilih Sarana Prasarana Sesuai RKU');
$sarprasRku = CHtml::listData(RkuSarpras::model()->findAll(array('condition' => 'id_rku='.Yii::app()->session['rku_id'])), 'id', 'nama_sarpras');
//$list = CHtml::listData(MasterJenisSarpras::model()->findAll(), 'id', 'jenis_sarpras');

//                    echo '<pre>';
//                    print_r($sarprasRku);
//                    echo '</pre>';


$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-prasyarat-rkt-form',
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

    <?php echo $form->select2Group($model, 'sesuai_rku', array('groupOptions' => array('id' => 'sesuai_rku'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $pilihan, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Sarana dan Prasarana')))); ?>

    
    <?php echo $form->select2Group($model, 'id_jenis_sarpras', array('groupOptions' => array('id' => 'jenis_sarpras','class'=>'hidden'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $sarprasRku, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Sarana dan Prasarana')))); ?>

        
    <?php echo $form->textFieldGroup($model, 'nama_sarpras', array('groupOptions'=>array('id' => 'nama_sarpras','class'=>'hidden'),'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php //echo $form->select2Group($model, 'id_jenis_sarpras', array('groupOptions' => array('id' => 'jenis_sarpras'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Sarana dan Prasarana')))); ?>

    <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' unit')); ?>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            $ajaxOptions = array(
                'dataType' => 'json',
                'type' => 'post',
                'data'=>"js:jQuery('form').serialize()",
                 'url' => Yii::app()->createUrl('/perusahaan/rktprasSarpras/index/rkt/'.$id_rkt),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-prasyarat-grid");
                                $("#' . Yii::app()->controller->id . '-prasyarat-rkt-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-prasyarat-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-prasyarat-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $ajaxString = CHtml::ajax($ajaxOptions);
            
            Yii::app()->clientScript->registerScript("submitForm", "
                
                $( '#".Yii::app()->controller->id . "-prasyarat-rkt-form' ).submit(function() {
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
                    'onclick'=>'js:$("#jenis_sarpras").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_sarpras").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Sarana dan Prasarana");',
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
    'id' => Yii::app()->controller->id . '-prasyarat-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_jenis_sarpras',
            'header' => 'Nama Sarana Prasarana',
            'value' => '$data->nama_sarpras',
        ),
        
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah (unit)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktprasSarpras/editJumlahSarpras')),
        ),
        
         array(
            'name' => 'sesuai_rku',
            'header' => 'Keterangan',
            'value' => '$data->sesuai_rku ? "Sesuai Rku" : "Tidak Sesuai RKU"',
        ),
        
       /*  array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/perusahaan/rktlingPengendalianKebakaran/deleteDalkar",array("id"=>$data->id))',
                ),
            )
        ), */
        
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>function($data){
                return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
                    'class'=>'deleteInFunction',
                    'onclick'=>'deleteData(this)', 
                    'data-url'=> Yii::app()->createUrl("/perusahaan/rktprasSarpras/deleteSarpras",array("id"=>$data->id))
                ));
            }
        ),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("sarpras", "
$('#addSarpras').click(function() {
    $('#" . Yii::app()->controller->id . "-prasyarat-rkt-form').toggle();
});
    
", CClientScript::POS_END);
?>
<script type="text/javascript">

    $('#RktSarpras_sesuai_rku').on('change', function() {
       if(this.value == 1){
           $('#jenis_sarpras').removeClass();
           $('#jenis_sarpras').addClass("form-group");
           
           $('#nama_sarpras').removeClass();
           $('#nama_sarpras').addClass("hidden form-group");
       }
       else if(this.value == 0){
           $('#jenis_sarpras').removeClass();
           $('#jenis_sarpras').addClass("hidden form-group");
           
           $('#nama_sarpras').removeClass();
           $('#nama_sarpras').addClass("form-group");
       }
    });
    
     $('#RktSarpras_id_jenis_sarpras').on('change', function() {
       $('#RktSarpras_nama_sarpras').val($('#RktSarpras_id_jenis_sarpras').find(":checked").text());
    });
    
    


    function deleteData(th){
        //alert($(th).attr("data-url"));
        var urlLink = $(th).attr("data-url");
        if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
            //return true;
            //var th = this,
            afterDelete = function(){};
            jQuery('#<?php echo Yii::app()->controller->id . '-prasyarat-grid' ?>').yiiGridView('update', {
                type: 'POST',
                url: urlLink,
                success: function(data) {
                    jQuery('#<?php echo Yii::app()->controller->id . '-prasyarat-grid' ?>').yiiGridView('update');
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