<button type="button" class="btn btn-sm btn-info" id="addNaker">Tambah Data</button>

<?php
$periode_rku = Rku::model()->findByPk($rkuNaker->id_rku);
for ($i = $periode_rku->tahun_mulai; $i <= $periode_rku->tahun_sampai; $i++) {
    $tahun[$i] = $i;
}


$listPendidikan = CHtml::listData(MasterPendidikan::model()->findAll(), 'id_pendidikan', 'pendidikan');
$listKewarganegaraan = CHtml::listData(MasterJenisKewarganegaraan::model()->findAll(), 'id', 'kewarganegaraan');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-naker-form',
    'type' => 'horizontal',
    'htmlOptions' => array('style' => 'display:none'),
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

        <?php echo $form->errorSummary($rkuNaker); ?>

        <?php echo $form->textFieldGroup($rkuNaker, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php //echo $form->select2Group($rkuNaker, 'tahun', array('groupOptions' => array('id' => 'tahun'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $tahun, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Tahun ')))); ?>

        <?php echo $form->dropDownListGroup($rkuNaker, 'is_tenaga_kehutanan', array('widgetOptions' => array('data' => array("1" => "Tenaga Profesional Kehutanan", "0" => "Tenaga Profesional Lainnya",), 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Tenaga Profesional')))); ?>

        <?php echo $form->dropDownListGroup($rkuNaker, 'is_tenaga_tetap', array('widgetOptions' => array('data' => array("1" => "Tenaga Tetap", "0" => "Tenaga Tidak Tetap",), 'htmlOptions' => array('class' => 'input-large')))); ?>

        <?php echo $form->select2Group($rkuNaker, 'id_pendidikan', array('labelOptions' => array('label' => 'Pendidikan'), 'groupOptions' => array('id' => 'pendidikan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listPendidikan, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Pendidikan')))); ?>

        <?php echo $form->select2Group($rkuNaker, 'id_jenis_kewarganegaraan', array('labelOptions' => array('label' => 'Kewarganegaraan'), 'groupOptions' => array('id' => 'kewarganegaraan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listKewarganegaraan, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Kewarganegaraan')))); ?>

        <?php echo $form->textFieldGroup($rkuNaker, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), 'append' => ' Org')); ?>

        <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <?php
                $ajaxOptions = array('dataType' => 'json',
                    'type' => 'post',
                    'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-naker-grid");
                                $("#' . Yii::app()->controller->id . '-naker-form")[0].reset();
                                $("#tahun").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#tahun").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Tahun");                                    
                                $("#pendidikan").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#pendidikan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Pendidikan");
                                $("#kewarganegaraan").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#kewarganegaraan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Kewarganegaraan");                                
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-naker-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-naker-form #"+key+"_em_").show();
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
                    'htmlOptions' => array(
                    //'onclick'=>'js:$("#jenis_batas").find(".select2-allowclear").removeClass("select2-allowclear");$("#jenis_batas").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tata Batas");',
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
            'dataProvider' => $naker->search(),
//            'mergeColumns' => array('tahun', 'is_tenaga_kehutanan', 'is_tenaga_tetap', 'id_jenis_kewarganegaraan', 'id_pendidikan'),
            'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
            'template' => '{items}{pager}',
            'enableSorting' => true,
            // 'filter' => $model,
            'columns' => array(
                array(
                    'name' => 'is_tenaga_kehutanan',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'value' => function($data){
                        if($data->is_tenaga_kehutanan == '1') return 'Tenaga Professional Kehutanan';
                        else return 'Tenaga Professional Lainnya';
                    },
                    'footer' => '<strong>Total</strong>',
                    'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),        
                ),
                array(
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'name' => 'is_tenaga_tetap',
                    'value' => function($data){
                        if($data->is_tenaga_tetap == '1') return 'Tenaga Tetap';
                        else return 'Tenaga Tidak Tetap';
                    }
                ),
                array(
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'name' => 'id_jenis_kewarganegaraan',
                    'value' => '$data->idJenisKewarganegaraan->kewarganegaraan',
                ),
                array(
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'name' => 'id_pendidikan',
                    'value' => '$data->idPendidikan->pendidikan',
                ),                
                array(
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'header' => 'Jumlah (Org)',
                    'class' => 'booster.widgets.TbEditableColumn',
                    'name' => 'jumlah',
                    'value'=>function ($data) {
                        return number_format($data->jumlah,0,',','.');
                    },
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
                    'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputSerapanNaker')),
                    'footer' => '<strong>' . number_format(RkuSerapanTenagaKerja::model()->getTotal($naker->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
                    'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("//perusahaan/rkuPersyaratan/deleteSerapanNaker",array("id"=>$data->id))',
                        ),
                    )
                ),
            )
        ));
        ?>

<?php
Yii::app()->clientScript->registerScript("addnaker", "
$('#addNaker').click(function() {
    $('#" . Yii::app()->controller->id . "-naker-form').toggle();
});
    
", CClientScript::POS_END);
