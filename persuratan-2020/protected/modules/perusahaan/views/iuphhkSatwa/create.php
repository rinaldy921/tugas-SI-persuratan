<?php
$this->breadcrumbs=array(
	'Iuphhk Satwas'=>array('index'),
	'Create',
);

?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_sosial_ekonomi.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Input Data Satwa Dilindungi</h4>

    <?php
    $list = CHtml::listData(MJenisHewan::model()->findAll(), 'id_jenis_hewan', 'nama_jenis');
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

    <div class="panel panel-default">
        <!-- <div class="panel-heading"></div> -->
        <div class="panel-body">
            <?php echo $form->textFieldGroup($satwa, 'id_iuphhk', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5','value'=>Yii::app()->user->idIuphhk())))); ?>

            <?php echo $form->select2Group($satwa, 'id_jenis', array('labelOptions' => array('label' => 'Jenis Hewan'), 'groupOptions' => array('id' => 'jenis_hewan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Hewan')))); ?>

            <?php echo $form->textFieldGroup($satwa,'nama_satwa',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

            <?php echo $form->textAreaGroup($satwa,'keterangan', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

            <div class="col-md-3"></div>
            <div class="col-md-9">
                <?php
                $ajaxOptions = array('dataType' => 'json',
                    'type' => 'post',
                    'success' => 'js:function(data) {
                                if(data.status == "success"){
                                    $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-grid");
                                    $("#' . Yii::app()->controller->id . '-form")[0].reset();
                                    $("#jenis_hewan").find(".select2-allowclear").removeClass("select2-allowclear");
                                    $("#jenis_hewan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Hewan");
                                } else {
                                    $.each(data, function(key, val) {
                                        $("#' . Yii::app()->controller->id . '-form #"+key+"_em_").text(val);
                                        $("#' . Yii:: app()->controller->id . '-form #"+key+"_em_").show();
                                    });
                                }
                            }'
                );
                
                $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                    'label' => Yii::t('app', 'Tambah'),
                    'size' => 'small',
                    'ajaxOptions' => $ajaxOptions,
                    'url' => Yii::app()->createUrl('/perusahaan/iuphhkSatwa/create')
                ));
                $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'reset',
                    'context' => 'default',
                    'size' => 'small',
                    'htmlOptions'=>array(
                        'onclick'=>'js:$("#jenis_hewan").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_hewan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Hewan");',
                    ),
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
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'enableSorting'=>false,
        'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
        'template' => '{items}{pager}',
        // 'filter' => $model,
        'columns' => array(
            array(
                'name' => 'id_jenis',
                'header' => 'Jenis Hewan',
                'value' => '$data->idJenis->nama_jenis',
            ),
            array(
                'name' => 'nama_satwa',
                'header' => 'Nama Satwa',
                'value' => '$data->nama_satwa',
            ),
            array(
                'name' => 'keterangan',
                'value' => '$data->keterangan',
            ),
            array(
                'header' => 'Aksi',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{delete}'
            ),
        )
    ));
    ?>



    <?php 
//     echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary'));?><?php //$this->widget('booster.widgets.TbGridView',array(
// 'id'=>Yii::app()->controller->id . '-grid',
// 'type' => 'bordered condensed striped',
// 'responsiveTable' => true,
// 'dataProvider'=>$model->search(),
// 'filter'=>$model,
// 'template' => '{items}{summary}{pager}',
// 'columns'=>array(
//      'id',
//      'id_iuphhk',
//      'id_jenis',
//      'nama_satwa',
//      'keterangan',
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
// ),
// )); 
?>
</div>
