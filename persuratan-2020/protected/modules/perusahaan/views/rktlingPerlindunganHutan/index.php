<button type="button" class="btn btn-sm btn-info" id="addDalhutan">Tambah Data</button>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-dungtan-form',
    'type' => 'horizontal',
    'htmlOptions' => array('style' => 'display:none;'),
    'enableClientValidation' => true,
	
	/*
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
	 */
        ));
?>
<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
    <p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldGroup($model, 'id_rkt', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textAreaGroup($model, 'rencana', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')), )); ?>

    <?php echo $form->textAreaGroup($model, 'keterangan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>


    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            /* $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-dalmakit-grid");
                                $("#' . Yii::app()->controller->id . '-dalmakit-rkt-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-dalmakit-rkt-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-dalmakit-rkt-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                'label' => Yii::t('app', 'Tambah'),
                'ajaxOptions' => $ajaxOptions,
                'size' => 'small',
                'url' => Yii::app()->createUrl('/perusahaan/rktlingPerlindunganHutan/index/rkt/'.$id_rkt)
            )); */
			
			
			
			
			$ajaxOptions = array(
				'dataType' => 'json',
                'type' => 'post',
				'data'=>"js:jQuery('form').serialize()",
				'url' => Yii::app()->createUrl('/perusahaan/rktlingPerlindunganHutan/index/rkt/'.$id_rkt),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-dalmakit-grid");
                                $("#' . Yii::app()->controller->id . '-dungtan-form")[0].reset();
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-dungtan-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-dungtan-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
			$ajaxString = CHtml::ajax($ajaxOptions);
			
			Yii::app()->clientScript->registerScript("submitForm", "
				
				$( '#".Yii::app()->controller->id . "-dungtan-form' ).submit(function() {
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
    'id' => Yii::app()->controller->id . '-dalmakit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'rencana',
            'header' => 'Rencana (Satuan)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPerlindunganHutan/editJumlahPerlindunganHutan')),
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPerlindunganHutan/editJumlahPerlindunganHutan')),
        ),
        /* array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/perusahaan/rktlingPerlindunganHutan/deletePerlindunganHutan",array("id"=>$data->id))',
                ),
            )
        ), */
        array(
            'name' => 'keterangan',
            'header' => 'Keterangan',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPerlindunganHutan/editJumlahPerlindunganHutan')),
        ),		
        array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteData(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktlingPerlindunganHutan/deletePerlindunganHutan",array("id"=>$data->id))
				));
			}
		),
    )
));
?>
<?php
Yii::app()->clientScript->registerScript("dalhutan", "
$('#addDalhutan').click(function() {
    $('#" . Yii::app()->controller->id . "-dungtan-form').toggle();
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
			jQuery('#<?php echo Yii::app()->controller->id . '-dalmakit-grid' ?>').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#<?php echo Yii::app()->controller->id . '-dalmakit-grid' ?>').yiiGridView('update');
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