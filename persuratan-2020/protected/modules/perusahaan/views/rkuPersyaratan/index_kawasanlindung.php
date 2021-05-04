<button type="button" class="btn btn-sm btn-info" id="addRKUKalin">Tambah Data</button>
<?php
$list = CHtml::listData(MasterJenisKawasanLindung::model()->findAll(), 'id', 'nama_jenis');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-kalin-form',
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
        <?php echo $form->textFieldGroup($model, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->select2Group($model, 'id_jenis_kawasan_lindung', array('groupOptions' => array('id' => 'nama_jenis'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Kawasan Lindung')))); ?>

        <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <div class="col-md-3"></div>
        <div class="col-md-9">
		
            <?php
           /*  $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-kawasan-lindung-grid");
                                $("#' . Yii::app()->controller->id . '-kalin-form")[0].reset();
                                $("#nama_jenis").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#nama_jenis").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Kawasan Lindung");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-kalin-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-kalin-form #"+key+"_em_").show();
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
			 */
			
			
			$ajaxOptions = array(
				'dataType' => 'json',
                'type' => 'post',
				'data'=>"js:jQuery('#".Yii::app()->controller->id."-kalin-form').serialize()",
				'url' => Yii::app()->createUrl('/perusahaan/rkuPersyaratan/index'),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-kawasan-lindung-grid");
                                $("#' . Yii::app()->controller->id . '-kalin-form")[0].reset();
                                $("#nama_jenis").find(".select2-allowclear").removeClass("select2-allowclear");
                                $("#nama_jenis").find(".select2-chosen").empty().addClass("select2-default").html("Pilih Jenis Kawasan Lindung");
                            } else {
                                $.each(data, function(key, val) {
                                    $("#' . Yii::app()->controller->id . '-kalin-form #"+key+"_em_").text(val);
                                    $("#' . Yii:: app()->controller->id . '-kalin-form #"+key+"_em_").show();
                                });
                            }
                        }'
            );
			$ajaxString = CHtml::ajax($ajaxOptions);
			
			Yii::app()->clientScript->registerScript("submitFormkalin", "
				
				$( '#".Yii::app()->controller->id . "-kalin-form' ).submit(function() {
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
//                            'htmlOptions' => array('confirm' => Yii::t('app', 'Form yang telah diisi akan hilang, lanjutkan pembatalan?'), 'class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
                'label' => Yii::t('app', 'Reset'),
            ));
            ?>
        </div>
    </div>

</div>

<?php $this->endWidget(); ?>
<?php
//   print_r("<pre>");
//        print_r($model);
//        print_r("<pre>"); exit(1);
   


$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kawasan-lindung-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => FALSE,
// 'filter'=>$model,
    'template' => '{summary}{items}{pager}',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_kawasan_lindung',
            'header' => 'Jenis Kawasan Lindung',
            'value' => '$data->idJenisKawasanLindung->nama_jenis',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Ha)',
            'class' => 'booster.widgets.TbEditableColumn',            
            'name' => 'jumlah',
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
            'type' => 'raw',
//			'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'editable' => array(
                'url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputJumlah'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-kawasan-lindung-grid");
                }',
            ),
            'footer' => '<strong>' . number_format(RkuKawasanLindung::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
                'header'=>'',
                'type'=>'raw',
                'value'=>function($data){
                        return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
                                'class'=>'deleteInFunction',
                                'onclick'=>'deleteDataKalin(this)', 
                                'data-url'=> Yii::app()->createUrl("/perusahaan/rkuPersyaratan/deleteArealKawasanLindung",array("id"=>$data->id))
                        ));
                },
                'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        
    ),
));
?>
<?php
Yii::app()->clientScript->registerScript("addRKUKalin", "
$('#addRKUKalin').click(function() {
    $('#" . Yii::app()->controller->id . "-kalin-form').toggle();
});
    
", CClientScript::POS_END);
?>

<script type="text/javascript">


	function deleteDataKalin(th){
		//alert($(th).attr("data-url"));
		var urlLink = $(th).attr("data-url");
		if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
			//return true;
			//var th = this,
			afterDelete = function(){};
			jQuery('#<?php echo Yii::app()->controller->id . '-kawasan-lindung-grid' ?>').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#<?php echo Yii::app()->controller->id . '-kawasan-lindung-grid' ?>').yiiGridView('update');
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