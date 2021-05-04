<?php
if (!$model->isNewRecord) {
    $attachments = Attachment::model()->findAll("Model = 'PetaIUP' AND Model_id = :id", array(':id' => $model->id_iup));
}
// $rku = CHtml::listData(Rku::model()->findAll(array('select' => 'id_rku, id_perusahaan, nomor_sk','condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan().' AND status = 1')), 'id_perusahaan', 'nomor_sk');
$iup = Iuphhk::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
?>

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-iup-form',
    // 'type'=>'horizontal',
    'enableClientValidation' => true,
    'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
	// 'enableAjaxValidation'=>false,
)); ?>

<?php 
if($model->hasErrors()) {
	echo $form->errorSummary($model);
}
?>
<div class="form-group">
	<label for="nomorRku">Nomor SK IUPHHK</label>
	<p class="form-control-static"><?php echo $iup->nomor; ?></p>
</div>
	<?php echo $form->textFieldGroup($model,'id_perusahaan',array('groupOptions'=>array('style'=>'display:none'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>Yii::app()->user->idPerusahaan())))); ?>
	<?php echo $form->textFieldGroup($model,'id_iup',array('groupOptions'=>array('style'=>'display:none'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$iup->id_iuphhk)))); ?>
	<?php //echo $form->textFieldGroup($model,'id_rku',array('groupOptions'=>array('style'=>'display:none'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php //echo $form->select2Group($model, 'id_rku', array('groupOptions' => array('id' => 'jenis_peralatan'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $rku, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih RKU ')))); ?>

	<?php //echo $form->textFieldGroup($model,'file_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php //echo $form->textFieldGroup($model,'file_path',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

<div class="form-group">
    <label for="dokumen_peta" class="control-label"><?php echo Yii::t('app', 'Berkas Spasial (Peta Digital)'); ?></label>
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
        <?php echo Yii::t('app', '* Gunakan secara berulang untuk mengunggah multiple file. <br>* Gunakan hanya berkas spasial dengan jenis <strong>shp</strong>.<br>* <strong style="color:red">Mohon diperhatikan. Pastikan proyeksi CRS shp adalah : EPSG:4326 / WGS 84 (Geographic Coordinate Systems).</strong><br>* Unggah pula berkas terkait lainnya, seperti: shx, dbf, prj, dll.'); ?>
    </p>
</div>
<div class="form-group">
	<div>
		<?php $this->widget('booster.widgets.TbButton', array(
            'id'=>'nipzSubmit',
            'buttonType' => 'submit',
            'context' => 'primary',
            'size' => 'small',
            'label' => Yii::t('app', 'Simpan'),
        ));
        echo ' ';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'default',
            'size' => 'small',
            'htmlOptions' => array('class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
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