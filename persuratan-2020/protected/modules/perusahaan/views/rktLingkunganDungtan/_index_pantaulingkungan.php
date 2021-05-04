<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-pemantauanlingkungan-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldGroup($model,'id_rkt',array('groupOptions' => array('class' => 'hidden'),'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'value' => $idRkt)))); ?>
	<?php echo $form->textAreaGroup($model,'kegiatan',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>5)))); ?>
	<?php echo $form->textAreaGroup($model,'keterangan',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>5)))); ?>
	<?php //echo $form->textFieldGroup($model,'status',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxLength'=>255)))); ?>
	<?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-pemantauanlingkungan-grid");
                                $("#' . Yii::app()->controller->id . '-pemantauanlingkungan-form")[0].reset();
                                // $("#jenis_lahan").find(".select2-allowclear").removeClass("select2-allowclear");
                                // $("#jenis_lahan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tanaman");
                                // $("#jenis_tanaman").find(".select2-allowclear").removeClass("select2-allowclear");
                                // $("#jenis_tanaman").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Nama Tanaman");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-pemantauanlingkungan-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-pemantauanlingkungan-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
	?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',
			'context'=>'primary',
			'ajaxOptions'=>$ajaxOptions,
			'label'=>'Simpan'
		)); ?>
    </div>
</div>

<?php $this->endWidget(); ?>



<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createKawasanLindung'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-pemantauanlingkungan-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$modelPantau->search(),
'enableSorting' => false,
// 'filter'=>$model,
'template' => '{items}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
		// 'id_blok',
		// array(
		// 	'name'=>'id_blok',
		// 	'value'=>'$data->idBlok->idBlok->nama_blok'
		// ),
		// array(
		// 	'name'=>'id_jenis_sarpras',
		// 	'value'=>'$data->idJenisSarpras->jenis_sarpras'
		// ),
		'kegiatan',
		'keterangan',
		// array(
		// 	// // 'header'=>'Jumlah',
		// 	'class'=>'booster.widgets.TbEditableColumn',
		// 	'name'=>'penanganan',
		// 	'type'=>'raw',
		// 	// 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
		// 	'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahBangunSarpras')),
		// ),
		// 'realisasi',
		// array(
		// 	// 'header'=>'Realisasi',
		// 	'class'=>'booster.widgets.TbEditableColumn',
		// 	'name'=>'status',
		// 	'type'=>'raw',
		// 	// 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
		// 	'editable'=> array('url'=>$this->createUrl('//perusahaan/rktInfraMukim/inputStatusKonflik')),
		// ),
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{delete}',
			'buttons' => array(
                // 'update' => array(
                //     'visible' => '(Yii::app()->user->idPerusahaan() == $data->idJenisPeralatan->id_perusahaan) ? "1" : "0" ',
                // ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/rktLingkunganDungtan/deletePantau/", array("id"=>$data->id))',
                ),
            ),
		),
),
)); ?>