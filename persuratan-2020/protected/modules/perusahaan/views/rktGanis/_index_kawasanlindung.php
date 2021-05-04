
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

<p style="color:red"><strong>* Untuk pengisian koma (,) isikan dengan titik (.)</strong></p>

<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <?php echo $form->textFieldGroup($model, 'id_rkt', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->select2Group($model, 'id_kawasan_lindung', array('groupOptions' => array('id' => 'nama_jenis'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Kawasan Lindung')))); ?>

        <?php echo $form->textFieldGroup($model, 'jumlah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <div class="col-md-3"></div>
        <div class="col-md-9">
		
           <?php
			
			$ajaxOptions = array(
				'dataType' => 'json',
                'type' => 'post',
				'data'=>"js:jQuery('#".Yii::app()->controller->id."-kalin-form').serialize()",
				'url' => Yii::app()->createUrl('/perusahaan/rktGanis/createkawasanlindung/rkt/'.$idRkt),
                'success' => 'js:function(data) {
                            if(data.status == "success"){
                                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-kawasanlindung-grid");
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
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kawasanlindung-grid',
    // 'filter'=>$model,
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'template' => "{items}",
    // 'extraRowColumns'=> array('firstLetter'),
    // 'extraRowExpression' =>  '"<b style=\"font-size: 3em; color: #333;\">".substr($data->firstName, 0, 1)."</b>"',
    // 'extraRowHtmlOptions' => array('style'=>'padding:10px'),
    'columns' => array(
        // 'id',
        // 'id_rkt',
        // 'id_blok',
        /* array(
            'name' => 'id_blok',
            'value' => '$data->idBlok->idBlok->nama_blok',
            'footer' => '<strong>Total</strong>'
        ), */
		
		 array(
            'name' => 'id_jenis_kawasan_lindung',
            'header' => 'Kawasan Lindung',
            'value' => '$data->idKawasanLindung->nama_jenis',
            'footer' => '<strong>Total</strong>',
        ),
		
        // 'jumlah',
        array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            'type' => 'raw',
            // 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktGanis/inputJumlahKawasanLindung'),
                'success' => 'js:function() {
                    $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-kawasanlindung-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
                }',
                'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
            ),
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        // 'realisasi',
        array(
            // 'header'=>'Realisasi',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'realisasi',
            'type' => 'raw',
            'visible' => false,
            'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
            // 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktGanis/inputJumlahKawasanLindung'),
                'success' => 'js:function() {
                    $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-kawasanlindung-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
                }',
                'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
            ),
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'realisasi') . '</strong>',
        ),
        array(
            // 'header'=>'%',
            'name' => 'persentase',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            'value' => 'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>' . $model->getTotalPersen($model->search()->getData(), 'persentase') . '</strong>',
        // 'class'=>'TbPercentOfTypeEasyPieOperation'
        ),
		
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteDataKalin(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktGanis/deletekawasanlindung",array("id"=>$data->id))
				));
			}
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
			jQuery('#<?php echo Yii::app()->controller->id . '-kawasanlindung-grid' ?>').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#<?php echo Yii::app()->controller->id . '-kawasanlindung-grid' ?>').yiiGridView('update');
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
