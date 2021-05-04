<p style="color:red"><strong>* Untuk pengisian koma (,) isikan dengan titik (.)</strong></p>
<button type="button" class="btn btn-sm btn-info" id="addData">Tambah Data</button>

<?php
Yii::app()->clientScript->registerScript("tauling", "
$('#addData').click(function() {
    $('#" . Yii::app()->controller->id . "-rkt-form').toggle();
});
    
", CClientScript::POS_END);

?>

<?php
$list = CHtml::listData(MasterJenisPwh::model()->findAll(), 'id', 'jenis_pembukaan');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-rkt-form',
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

    <?php //echo $form->textFieldGroup($model, 'id_pwh', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
	<?php echo $form->select2Group($model, 'id_pwh', array('groupOptions' => array('id' => 'id_pwh'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Pengendalian Kebararan')))); ?>

	
	<?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
	
	<?php //echo $form->textFieldGroup($model, 'persentase', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>



    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            
			$ajaxOptions = array(
				'dataType' => 'json',
                'type' => 'post',
				'data'=>"js:jQuery('form').serialize()",
				 'url' => Yii::app()->createUrl('/perusahaan/rktGanis/createpwh/rkt/'.$model->id_rkt),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-pwh-grid");
                                $("#' . Yii::app()->controller->id . '-rkt-form")[0].reset();
								  $("#id_pwh").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#id_pwh").find(".select2-chosen").empty().addClass("select2-default").html("Pilih");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
			$ajaxString = CHtml::ajax($ajaxOptions);
			
			Yii::app()->clientScript->registerScript("submitForm", "
				
				$( '#".Yii::app()->controller->id . "-rkt-form' ).submit(function() {
					//alert('asalamualaikum');
					//console.log(jQuery('form').serialize());
					".$ajaxString = CHtml::ajax($ajaxOptions)."
					return false;
				});
				
			", CClientScript::POS_END);
			
			$this->widget('booster.widgets.TbButton', array(
				'id'=>'submitButton',
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




<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-pwh-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
 'enableSorting'=>false,
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
			'name'=>'id_pwh',
			'value'=>'$data->idPwh->jenis_pembukaan',
			'footer' => '<strong>Total</strong>'
		),
		// 'jumlah',
		array(
			// 'header'=>'Jumlah',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'jumlah',
			'type'=>'raw',
			'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahPwh'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-pwh-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
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
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahPwh'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-pwh-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
	            }',
	            'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
			),
			'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
		),
		/*array(
            // 'header'=>'%',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
        ), */
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteData(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktGanis/deletepwh",array("id"=>$data->id))
				));
			}
		),
		
		
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
),
)); ?>

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