<?php /*
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-masterjenissarpras-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Isikan jenis sarpras jika tidak terdapat pada tabel dibawah.</p>

<?php echo $form->errorSummary($modelMasterJenisSarpras); ?>

	<?php echo $form->textFieldGroup($modelMasterJenisSarpras,'id_perusahaan',array('groupOptions'=>array('class'=>'hidden'),'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>Yii::app()->user->idPerusahaan())))); ?>
	<?php echo $form->textFieldGroup($modelMasterJenisSarpras,'jenis_sarpras',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','id'=>'jenisSarpras', 'maxlength'=>255)))); ?>
	<?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'beforeSend'=>'js:function(){$("#nipz-submit").prop("disabled",true);$("#jenisSarpras").prop("disabled",true);}',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-bangunsarpras-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
                                $("#nipz-submit").prop("disabled",false);
                                $("#jenisSarpras").prop("disabled",false);
                                $("#' . Yii::app()->controller->id . '-masterjenissarpras-form")[0].reset();
                                // $("#jenis_lahan").find(".select2-allowclear").removeClass("select2-allowclear");
                                // $("#jenis_lahan").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Tanaman");
                                // $("#jenis_tanaman").find(".select2-allowclear").removeClass("select2-allowclear");
                                // $("#jenis_tanaman").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Nama Tanaman");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-masterjenissarpras-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-masterjenissarpras-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
	?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'id'=>'nipz-submit',
			'buttonType'=>'ajaxSubmit',
			'context'=>'primary',
			'ajaxOptions'=>$ajaxOptions,
			'label'=>'Simpan'
		)); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

*/ ?>


<button type="button" class="btn btn-sm btn-info" id="addDatasarana">Tambah Data</button>
<?php
Yii::app()->clientScript->registerScript("sarana", "
$('#addDatasarana').click(function() {
    $('#" . Yii::app()->controller->id . "-rkt-sarana-form').toggle();
});
    
", CClientScript::POS_END);

?>

<?php
$listDataMAsterSarana = CHtml::listData(MasterJenisSarpras::model()->findAll(), 'id', 'jenis_sarpras');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-rkt-sarana-form',
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
    <p class="help-block">Isikan jenis sarpras jika tidak terdapat pada tabel dibawah..</p>

    <?php echo $form->errorSummary($model); ?>

    
	<?php echo $form->select2Group($model, 'id_jenis_sarpras', array('groupOptions' => array('id' => 'id_jenis_sarpras'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listDataMAsterSarana, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Pengendalian Kebararan')))); ?>
	<?php echo $form->textFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>
	



    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
           
			$ajaxOptions = array(
				'dataType' => 'json',
                'type' => 'post',
				'data'=>"js:jQuery('#".Yii::app()->controller->id."-rkt-sarana-form').serialize()",
				 'url' => Yii::app()->createUrl('/perusahaan/rktGanis/createsarana/rkt/'.$model->id_rkt),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-rkt-sarana-grid");
                                $("#' . Yii::app()->controller->id . '-rkt-sarana-form")[0].reset();
								 $("#id_jenis_sarpras").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#id_jenis_sarpras").find(".select2-chosen").empty().addClass("select2-default").html("Pilih");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-rkt-sarana-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-rkt-sarana-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
			$ajaxString = CHtml::ajax($ajaxOptions);
			
			Yii::app()->clientScript->registerScript("submitForm_sarana", "
				
				$( '#".Yii::app()->controller->id . "-rkt-sarana-form' ).submit(function() {
					//alert('asalamualaikum');
					//console.log(jQuery('#".Yii::app()->controller->id."-rkt-sarana-form').serialize());
					".$ajaxString = CHtml::ajax($ajaxOptions)."
					return false;
				});
				
			", CClientScript::POS_END);
			
			$this->widget('booster.widgets.TbButton', array(
				'id'=>'submitButton_sarana',
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
                'label' => Yii::t('app', 'Reset'),
            ));
            ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
    </div>
</div>


<p style="color:red"><strong>* Untuk pengisian koma (,) isikan dengan titik (.)</strong></p>
<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createKawasanLindung'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-rkt-sarana-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
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
	array(
		'name'=>'id_jenis_sarpras',
		'value'=>'$data->idJenisSarpras->jenis_sarpras',
		'footer' => '<strong>Total</strong>'
	),
	// 'jumlah',
	array(
		// // 'header'=>'Jumlah',
		'class'=>'booster.widgets.TbEditableColumn',
		'name'=>'jumlah',
		'type'=>'raw',
		'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
		'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahBangunSarpras'),
			'success'=>'js:function() {
                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-rkt-sarana-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
            }',
            'onShown' => 'js: function(e, editable) {
                var isi = editable.value.replace(".", "");
                var isi = isi.replace(",", ".");
                var tip = $(this).data("editableContainer").tip();
                tip.find("input").val(isi);
            }'
		),
		'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
	),
	// 'realisasi',
	array(
		// 'header'=>'Realisasi',
		'class'=>'booster.widgets.TbEditableColumn',
		'name'=>'realisasi',
		'type'=>'raw',
		'visible'=>false,
		'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
		'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahBangunSarpras'),
			'success'=>'js:function() {
                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-bangunsarpras-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
            }'
		),
		'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
	),
	/*array(
        // 'header'=>'%',
        // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
        // 'class'=>'TbPercentOfTypeEasyPieOperation'
        'name'=>'persentase',
        'value' => '!empty($data->persentase) ? number_format($data->persentase,2,",",".") : 0',
        'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
    ), */
    /* array(
		'class'=>'booster.widgets.TbButtonColumn',
		'template' => '{delete}',
		'buttons' => array(
            // 'update' => array(
            //     'visible' => '(Yii::app()->user->idPerusahaan() == $data->idJenisPeralatan->id_perusahaan) ? "1" : "0" ',
            // ),
            'delete' => array(
                'visible' => '(Yii::app()->user->idPerusahaan() == $data->idJenisSarpras->id_perusahaan) ? "1" : "0" ',
                'url' => 'Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/rktGanis/deleteSarpras/", array("id"=>$data->id))',
                // 'options'=>array(
                // 	'id'=>'nipz-del',
                // 	'onclick'=>'js:$("#nipz-del").prop("disabled",true);'
                // )
            ),
        ),
	), */
	
	array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				//if (Yii::app()->user->idPerusahaan() == $data->idJenisSarpras->id_perusahaan){
					return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
						'class'=>'deleteInFunction',
						'onclick'=>'deleteDataSarana(this)', 
						'data-url'=> Yii::app()->createUrl("/perusahaan/rktGanis/deleteSarpras",array("id"=>$data->id))
					));
				//}
			}
		),
),
)); ?>

<script type="text/javascript">


	function deleteDataSarana(th){
		//alert($(th).attr("data-url"));
		var urlLink = $(th).attr("data-url");
		if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
			//return true;
			//var th = this,
			afterDelete = function(){};
			jQuery('#<?php echo Yii::app()->controller->id . '-rkt-sarana-grid' ?>').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#<?php echo Yii::app()->controller->id . '-rkt-sarana-grid' ?>').yiiGridView('update');
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