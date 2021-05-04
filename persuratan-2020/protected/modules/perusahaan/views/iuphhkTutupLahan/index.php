<style>
.deleteInFunction{
	cursor:pointer;
}
</style>

<?php
$this->breadcrumbs = array(
    'Penutupan Lahan'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Keadaan Hutan</h4>
    <button type="button" class="btn btn-sm btn-info" id="addPenutupanLahan">Tambah Data</button>


    <?php
    $list = CHtml::listData(MasterJenisTutupLahan::model()->findAll(), 'id', 'jenis_penutupan');
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-penutupanlahan-form',
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

    <?php echo $form->textFieldGroup($model, 'id_iuphhk', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->select2Group($model, 'id_penutupan_lahan', array('groupOptions' => array('id' => 'jenis_penutupan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Penutupan Lahan')))); ?>

	<?php echo $form->textFieldGroup($model, 'hpt', array('groupOptions' => array(), 'widgetOptions' => array('htmlOptions' => array('class' => 'span2')))); ?>

	<?php echo $form->textFieldGroup($model, 'hp', array('groupOptions' => array(), 'widgetOptions' => array('htmlOptions' => array('class' => 'span2')))); ?>

	<?php echo $form->textFieldGroup($model, 'hpk', array('groupOptions' => array(), 'widgetOptions' => array('htmlOptions' => array('class' => 'span2')))); ?>

	<?php echo $form->textFieldGroup($model, 'apl', array('groupOptions' => array(), 'widgetOptions' => array('htmlOptions' => array('class' => 'span2')))); ?>

    <?php echo $form->textFieldGroup($model, 'hl', array('groupOptions' => array(), 'widgetOptions' => array('htmlOptions' => array('class' => 'span2')))); ?>

    <?php echo $form->textFieldGroup($model, 'hsaw', array('groupOptions' => array(), 'widgetOptions' => array('htmlOptions' => array('class' => 'span2')))); ?>

    <?php echo $form->textFieldGroup($model, 'ksa', array('groupOptions' => array(), 'widgetOptions' => array('htmlOptions' => array('class' => 'span2')))); ?>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            /* $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-tata-batas-grid");
                                $("#' . Yii::app()->controller->id . '-tatabatas-rkt-form")[0].reset();
                                $("#jenis_batas").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_batas").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tata Batas");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-tatabatas-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-tatabatas-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                'label' => Yii::t('app', 'Tambah'),
                'ajaxOptions' => $ajaxOptions,
                'size' => 'small',
                'url' => Yii::app()->createUrl('/perusahaan/rktprasBatasBlok/index/rkt/'.$id_rkt)
            )); */
            
            
            
            
            $ajaxOptions = array(
                'dataType' => 'json',
                'type' => 'post',
                'data'=>"js:jQuery('#".Yii::app()->controller->id."-penutupanlahan-form').serialize()",
                 'url' => Yii::app()->createUrl('/perusahaan/iuphhkTutupLahan/createTutupLahan'),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-grid");
                                $("#' . Yii::app()->controller->id . '-penutupanlahan-form")[0].reset();
                                $("#jenis_penutupan").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_penutupan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Penutupan Lahan");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-penutupanlahan-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-penutupanlahan-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $ajaxString = CHtml::ajax($ajaxOptions);
            
            Yii::app()->clientScript->registerScript("submitForm_batas", "
                
                $( '#".Yii::app()->controller->id . "-penutupanlahan-form' ).submit(function() {
                    //alert('asalamualaikum');
                    //console.log(jQuery('#".Yii::app()->controller->id."-penutupanlahan-form').serialize());
                    ".$ajaxString = CHtml::ajax($ajaxOptions)."
                    return false;
                });
                
            ", CClientScript::POS_END);
            
            $this->widget('booster.widgets.TbButton', array(
                'id'=>'submitButton_batas',
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
                    'onclick'=>'js:$("#jenis_penutupan").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_penutupan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Penutupan Lahan");',
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




    <?php // echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?><?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
		'afterAjaxUpdate' => 'reloadTable',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'enableSorting' => false,
        'template' => '{items}{pager}',
        'columns' => array(
            array(
                'name' => 'id_penutupan_lahan',
                'header' => 'Penutupan Lahan',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value' => '$data->idPenutupanLahan->jenis_penutupan'
            ),
            array(
                'name' => 'hpt',
                'class' => 'booster.widgets.TbEditableColumn',
                'type' => 'raw',
                'editable' => array('url' => $this->createUrl('//perusahaan/iuphhkTutupLahan/input')),
            ),
            array(
                'name' => 'hp',
                'class' => 'booster.widgets.TbEditableColumn',
                'type' => 'raw',
                'editable' => array('url' => $this->createUrl('//perusahaan/iuphhkTutupLahan/input')),
            ),
            array(
                'name' => 'hpk',
                'class' => 'booster.widgets.TbEditableColumn',
                'type' => 'raw',
                'editable' => array('url' => $this->createUrl('//perusahaan/iuphhkTutupLahan/input')),
            ),
            array(
                'name' => 'apl',
                'class' => 'booster.widgets.TbEditableColumn',
                'type' => 'raw',
                'editable' => array('url' => $this->createUrl('//perusahaan/iuphhkTutupLahan/input')),
            ),
            array(
                'name' => 'hl',
                'class' => 'booster.widgets.TbEditableColumn',
                'type' => 'raw',
                'editable' => array('url' => $this->createUrl('//perusahaan/iuphhkTutupLahan/input')),
            ),
            array(
                'name' => 'hsaw',
                'class' => 'booster.widgets.TbEditableColumn',
                'type' => 'raw',
                'editable' => array('url' => $this->createUrl('//perusahaan/iuphhkTutupLahan/input')),
            ),
            array(
                'name' => 'ksa',
                'class' => 'booster.widgets.TbEditableColumn',
                'type' => 'raw',
                'editable' => array('url' => $this->createUrl('//perusahaan/iuphhkTutupLahan/input')),
            ),
            array(
            'header'=>'',
            'type'=>'raw',
            'value'=>function($data){
                    return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
                        'class'=>'deleteInFunction',
                        'onclick'=>'deletePenutupanLahan(this)', 
                        'data-url'=> Yii::app()->createUrl("/perusahaan/iuphhkTutupLahan/delete",array("id"=>$data->id))
                    ));
                }
            ),
        ),
    ));
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("penutupanlahan", "
$('#addPenutupanLahan').click(function() {
    $('#" . Yii::app()->controller->id . "-penutupanlahan-form').toggle();
});
    
", CClientScript::POS_END);

?>
<script type="text/javascript">


    function deletePenutupanLahan(th){
        //alert($(th).attr("data-url"));
        var urlLink = $(th).attr("data-url");
        if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
            //return true;
            //var th = this,
            afterDelete = function(){};
            jQuery('#<?php echo Yii::app()->controller->id . '-grid' ?>').yiiGridView('update', {
                type: 'POST',
                url: urlLink,
                success: function(data) {
                    jQuery('#<?php echo Yii::app()->controller->id . '-grid' ?>').yiiGridView('update');
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
<?php
Yii::app()->clientScript->registerScript("addTh", "

$('#" . Yii::app()->controller->id . "-grid table thead').prepend('<tr><th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Penutupan Lahan</th><th colspan=\'7\' style=\'text-align: center; vertical-align: middle\'>Fungsi Hutan</th></tr>')

function reloadTable(){
		$('#" . Yii::app()->controller->id . "-grid table thead').prepend('<tr><th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Penutupan Lahan</th><th colspan=\'7\' style=\'text-align: center; vertical-align: middle\'>Fungsi Hutan</th></tr>')
}
	
", CClientScript::POS_END);
?>
