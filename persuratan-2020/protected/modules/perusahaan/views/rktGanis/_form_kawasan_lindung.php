<h4 class="page-header">Kawasan Lindung</h4>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> 'kawasan-lindung-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); 
$blok = BlokSektor::model()->findAll(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan()));
foreach($blok as $b) {
	$idBlok[]=$b->id_blok;
}
$mblok = CHtml::listData(MasterBlok::model()->findAll(array('select'=>'id, nama_blok','condition'=>'id IN ('.implode(',',$idBlok).')')), 'id', 'nama_blok');
// var_dump($mblok);die;
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>


<?php echo $form->textFieldGroup($model,'id_rkt',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$idRkt)))); ?>

<?php //echo $form->textFieldGroup($model,'id_blok',array('label'=>'Id Blok','widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
<?php echo $form->select2Group($model, 'id_blok', array('enableAjaxValidation' => false, 'widgetOptions' => array('data' => $mblok, 'htmlOptions' => array('empty' => Yii::t('app', 'Pilih Blok...'), 'maxlength' => 4)))); ?>

<?php echo $form->textFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<?php echo $form->textFieldGroup($model,'realisasi',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("kawasan-lindung-grid");
                                $("#kawasan-lindung-form")[0].reset();
                                $("#jenis_lahan").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_lahan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tanaman");
                                $("#jenis_tanaman").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#jenis_tanaman").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Nama Tanaman");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#kawasan-lindung-form #"+key+"_em_").text(val);
                                    $("#kawasan-lindung-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'ajaxOptions' => $ajaxOptions,
			'label'=>'Simpan',
		)); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'kawasan-lindung-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model2->search(),
// 'filter'=>$model2,
'template' => '{items}{summary}{pager}',
'columns'=>array(
		'id',
		'id_rkt',
		'id_blok',
		'jumlah',
		'realisasi',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>