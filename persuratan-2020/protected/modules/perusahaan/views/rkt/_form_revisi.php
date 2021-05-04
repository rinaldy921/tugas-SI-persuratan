<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'htmlOptions' => array(
           'enctype' => 'multipart/form-data',
        ),
        'clientOptions' => array(
            'validateOnSubmit'=>true,
	        'validateOnChange'=>true,
	        'validateOnType'=>false,
        ),
	'enableAjaxValidation'=>false,
)); 
if(!$model->isNewRecord) {
	$rku = Rku::model()->find('id_rku = '.$model->id_rku);
}
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php //echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldGroup($model,'rkt_ke',array('widgetOptions'=>array('htmlOptions'=>array('value'=>$rktSebelum->rkt_ke, 'class'=>'span5','maxlength'=>100,'readonly'=>true)))); ?>
	<?php echo $form->textFieldGroup($model,'tahun_mulai',array('widgetOptions'=>array('htmlOptions'=>array('value'=>$rktSebelum->tahun_mulai, 'class'=>'span5','maxlength'=>100,'readonly'=>true)))); ?>
	<?php echo $form->datePickerGroup($model,'mulai_berlaku',array('widgetOptions'=>array(
		'options'=>array(
			'format'=>'yyyy-mm-dd',
			'startView'=>0,
			'minViewMode'=>0,
			'autoclose'=>true,
			'todayHighlight'=>true,
			'beforeShowYear'=> 'js:function (date){
              if (date.getFullYear() < '.$rku->tahun_mulai.') {
                return false;
              }
              if(date.getFullYear() >= '.$rku->tahun_sampai.') {
                return false;
              }
            }',
		),
		'htmlOptions'=>array('class'=>'span5')), 'append'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>

	<?php echo $form->datePickerGroup($model,'akhir_berlaku',array('widgetOptions'=>array(
		'options'=>array(
			'format'=>'yyyy-mm-dd',
			'startView'=>0,
			'minViewMode'=>0,
			'autoclose'=>true,
			'todayHighlight'=>true,
			'beforeShowYear'=> 'js:function (date){
				if (date.getFullYear() < '.$rku->tahun_mulai.') {
					return false;
				}
				if(date.getFullYear() >= '.$rku->tahun_sampai.') {
					return false;
				}
            }',
            
		),
		'events'=>array(
			'change'=>'js:function(date){
				var mulai = $("#Rkt_mulai_berlaku").val();
				if(mulai !== "") {
					var sampai = new Date(this.value);
					var mulai = new Date(mulai);
						// alert(sampai);

					if(sampai <= mulai) {
						alert("Tanggal akhir berlaku tidak boleh kurang atau sama dengan tanggal awal berlaku");
						$("#Rkt_akhir_berlaku").datepicker("update","");
						$("#Rkt_akhir_berlaku").datepicker("hide");
						$("#Rkt_akhir_berlaku").focus();
						$("#Rkt_akhir_berlaku").datepicker("show");
					}
					// alert(mulai);
				} else {
					alert("Silahkan pilih tanggal mulai berlaku terlebih dahulu");
					$("#Rkt_mulai_berlaku").focus();
				}
				// var now = new Date(this.value);
				// // alert(now.toSource());
				// $("#Rkt_tahun_sampai").val(now.getFullYear()+1);
			}',
		),
		'htmlOptions'=>array('class'=>'span5')), 'append'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
	<?php echo $form->textFieldGroup($model,'nomor_sk',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	<?php echo $form->datePickerGroup($model,'tanggal_sk',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd','autoclose'=>true,'todayHighlight'=>true),'htmlOptions'=>array('class'=>'span5')), 'append'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File SK (PDF)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="pdf_sk" type="file">
        </div>
                    <i>Ukuran File Maksimal 2 Mb</i>
        <br>
        <?php
                if(!is_null($model->file_doc)) {
//                    $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                    $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                    $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                    echo "File SK RKT: <a href='".Yii::app()->createUrl('/').$model->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                }
        ?>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File Peta (SHP)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="shp_map" type="file">
        </div>
        <i>Ukuran File Maksimal 20 Mb</i>
        <br>
        <?php
                if(!is_null($model->file_shp)) {
//                    $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                    $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                    $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                    echo "File SHP: <a href='".Yii::app()->createUrl('/').$model->file_shp."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                                        
                }
        ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'id'=>'nipzz',
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Simpan' : 'Simpan',
		)); 
		echo ' ';
	    $this->widget('booster.widgets.TbButton', array(
	        'buttonType' => 'reset',
	        'context' => 'danger',
	        'size' => 'medium',
	        'htmlOptions' => array('class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
	        'label' => Yii::t('app', 'Batal'),
	    ));
		?>
    </div>
</div>

<?php $this->endWidget(); ?>