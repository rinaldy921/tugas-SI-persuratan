<?php
if(!$model->isNewRecord) {
	$attachments = Attachment::model()->findAll("Model = 'PetaRKT' AND Model_id = :id", array(':id' => $model->id_rkt));
	// var_dump($model->id_rkt);die;
}
$spasialRkt = SpasialRkt::model()->findAll();

if(isset($spasialRkt) && !empty($spasialRkt)) {
	foreach($spasialRkt as $sprkt) {
		$id_sp[] = $sprkt->id_rkt;
	}
}

if(Yii::app()->controller->action->id == 'create' && isset($id_sp)) {
	$list = CHtml::listData(Rkt::model()->findAll('status = 1 AND id_rku = '.$id.' AND id NOT IN ('. implode(',',$id_sp).')'), 'id','nomor_sk');
	// var_dump($list);die;
} else {
	$list = CHtml::listData(Rkt::model()->findAll('status = 1 AND id_rku = '.$id), 'id','nomor_sk');
}
?>

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php //echo $form->errorSummary($model); ?>

<?php 
if($model->hasErrors()) {
	echo $form->errorSummary($model);
}
?>

	<?php echo $form->select2Group($model, 'id_rkt', array('groupOptions' => array('id' => 'id_rkt'), 'label'=>'Pilih RKT <span class="required">*</span>', 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih RKT ', 'disabled'=>empty($list) ? 'disabled' : '')))); ?>

	<?php //echo $form->textFieldGroup($model,'id_rkt',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'id_perusahaan',array('groupOptions'=>array('style'=>'display:none'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>Yii::app()->user->idPerusahaan())))); ?>

<div class="form-group">
    <label for="dokumen_peta" class="col-sm-3 control-label"><?php echo Yii::t('app', 'Berkas Spasial (Peta Digital)'); ?>  <span class="required">*</span></label>
    <div class="col-sm-9">
	    <?php
	    $this->widget('CMultiFileUpload', array(
	    	'model' => $model,
	        'name' => 'dokumen_peta',
	        'max' => 8,
	        'remove' => '[X]',
	        'accept' => 'shp|shx|qpj|prj|dbf',
	        'options' => array(
	            'afterFileAppend'=>'function(e, v, m){
	                var t = m.list.selector;
	                var c = $(t).children("div");
	                var nama = "";
	                var keep = "";
	                var konteks = ["shp","shx","prj","dbf"];

	                if(c.length > 1) {
	                    c.each(function(i) {
	                        nama = $(this).find("span").text();
	                        nama1 = nama.split(".");
	                        if(i === 0 ) {
	                            keep = nama1[0]; 
	                        }

	                        if(nama1[0] != keep) {
	                            alert("File \'"+nama1[0]+"\' tidak sama dengan \'"+keep+"\'. Pastikan nama file spasial sama semua (kecuali ekstensi).");
	                            $(this).children("a").click();
	                        }
	                    });
	                }
	            }',
	        ),
	        'htmlOptions' => array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Berkas Spasial (Peta Digital)')),
	    ));
	    if($model->hasErrors() && $model->getErrors('dokumen_peta') !== '') {
	    	echo '<div class="help-block error">'.$model->getErrors('dokumen_peta')[0].'</div>';
	    }
	    if (isset($attachments) && !empty($attachments)) {
	        echo "<div class=\"div5\"></div>";
	        echo "<strong><em>" . Yii::t('app', 'Berkas Eksisting:') . "</em></strong><br>";
	        echo "<small><i>Centang kemudian klik tombol <strong>Simpan</strong> untuk menghapus file.</i></small><br>";
	        ?>
	            <label>
	                <input type="checkbox" name="hapusSemua" onclick="javascript:hapusAll(this)"> Hapus File
	            </label>
	        <?php
	        foreach ($attachments as $att) {
	            ?>
	            <div class="MultiFile-label">
	                <input type="checkbox" name="del_file2[]" value="<?php echo $att->id; ?>" disabled="disabled">
	                <input type="hidden" name="del_file[]" value="<?php echo $att->id; ?>" >
	                <span title="<?php echo Yii::t('app', 'Hapus berkas:') . ' ' . $att->File_Name; ?>" class="MultiFile-title">
	                    <?php echo $att->File_Name; ?>
	                </span>
	            </div>
	            <?php
	        }
	    }
	    ?>
	    <p class="help-block">
	        <?php echo Yii::t('app', '* Gunakan secara berulang untuk mengunggah multiple file. <br>* Gunakan hanya berkas spasial dengan jenis <strong>shp</strong>.<br>* <strong style="color:red">Mohon diperhatikan. Pastikan proyeksi CRS shp adalah : EPSG:4326 / WGS 84 (Geographic Coordinate Systems).</strong><br>* Unggah pula berkas terkait lainnya, seperti: shx, dbf, prj, qpj dll.'); ?>
	    </p>
	</div>
</div>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'size' => 'small',
			'label'=>$model->isNewRecord ? 'Simpan' : 'Simpan',
		)); 
		echo ' ';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'default',
            'size' => 'small',
            'htmlOptions' => array('class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index','id'=>$id)) . "'"),
            'label' => Yii::t('app', 'Batal'),
        ));
		?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
Yii::app()->clientScript->registerScript("hapus", "
    function hapusAll(source) {
        checkboxes = document.getElementsByName('del_file[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }

        checkboxes1 = document.getElementsByName('del_file2[]');
        for(var i=0, n=checkboxes1.length;i<n;i++) {
            checkboxes1[i].checked = source.checked;
        }
    }
", CClientScript::POS_END);
Yii::app()->clientScript->registerScript("disable", "
    var t = document.getElementsByName('del_file[]');
    if(t.length > 1) {
        $('#dokumen_peta').attr('disabled',true);
    }
", CClientScript::POS_READY);