<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createGanis'), array('class' => 'btn btn-primary'));?>

<?php /*
<button type="button" class="btn btn-sm btn-info" id="addData">Tambah Data</button>
*/?>

<?php
Yii::app()->clientScript->registerScript("ganis", "
$('#addData').click(function() {
    $('#" . Yii::app()->controller->id . "-rkt-ganis-form').toggle();
});
    
", CClientScript::POS_END);

?>

<?php
$listGanis = CHtml::listData(MasterJenisGanis::model()->findAll(), 'id', 'nama_jenis');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-rkt-ganis-form',
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

   <?php echo $form->select2Group($model, 'id_ganis', array('groupOptions' => array('id' => 'id_ganis'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listGanis, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Pengendalian Kebararan')))); ?>

	
	<?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
	



    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            
			$ajaxOptions = array(
				'dataType' => 'json',
                'type' => 'post',
				'data'=>"js:jQuery('#".Yii::app()->controller->id ."-rkt-ganis-form').serialize()",
				 'url' => Yii::app()->createUrl('/perusahaan/rktGanis/createGanisAjax/rkt/'.$model->id_rkt),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-ganis-grid");
                                $("#' . Yii::app()->controller->id . '-rkt-ganis-form")[0].reset();
								 $("#id_ganis").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#id_ganis").find(".select2-chosen").empty().addClass("select2-default").html("Pilih");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-rkt-ganis-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-rkt-ganis-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
			$ajaxString = CHtml::ajax($ajaxOptions);
			
			Yii::app()->clientScript->registerScript("submitForm_ganis", "
				
				$( '#".Yii::app()->controller->id . "-rkt-ganis-form' ).submit(function() {
					//alert('asalamualaikum');
					console.log(jQuery('#".Yii::app()->controller->id."-rkt-ganis-form').serialize());
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
'id'=>Yii::app()->controller->id . '-ganis-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'enableSorting'=>false,
// 'filter'=>$model,
'template' => '{items}{pager}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
        array(
            'name' => 'id_ganis',
            'value' => '$data->idGanis->nama_jenis',
            'footer' => '<strong>Total</strong>'
        ),
		// 'id_ganis',
		array(
            // 'header'=>'Rencana',
            // 'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'jumlah',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
            'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
            // 'type'=>'raw',
            // // 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
            // 'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahGanis'),
            //     'success'=>'js:function() {
            //         $.fn.yiiGridView.update("ganis-grid");
            //     }'
            // ),
        ),
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteDataGanis(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktGanis/deleteganisajax",array("id"=>$data->id))
				));
			}
		),
        // 'realisasi',
        /*array(
            // 'header'=>'Realisasi',
            'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'realisasi',
            'type'=>'raw',
            'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",",".") : ""',
            'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahGanis'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("ganis-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
                }'
            ),
            'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
        ),
         * 
         */
        /*array(
            // 'header'=>'%',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? round(($data->realisasi / $data->jumlah) * 100,2) : "-"',
            'name'=>'persentase',
            'value' => '!empty($data->persentase) ? number_format($data->persentase,2,",",".") : 0',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
        )
         * 
         */
        // array(
        //     'class'=>'booster.widgets.TbButtonColumn',
        //     'buttons' => array(
        //         'update' => array(
        //             'url' => 'Yii::app()->createUrl("//perusahaan/rktGanis/updateGanis",array("id"=>$data->id))',
        //         ),
        //         'delete' => array(
        //             'url' => 'Yii::app()->createUrl("//perusahaan/rktGanis/delGanis",array("id"=>$data->id))',
        //         )
        //     )
        // ),
),
)); ?>

<script type="text/javascript">


	function deleteDataGanis(th){
		//alert($(th).attr("data-url"));
		var urlLink = $(th).attr("data-url");
		if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
			//return true;
			//var th = this,
			afterDelete = function(){};
			jQuery('#<?php echo Yii::app()->controller->id . '-ganis-grid' ?>').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#<?php echo Yii::app()->controller->id . '-ganis-grid' ?>').yiiGridView('update');
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