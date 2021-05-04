<!-- <div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
        <div class="navbar-default sidebar-nav">
            <?php //require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>
    </div>
</div> -->
<div class="panel panel-info">
<!-- <div id="page-wrapper" class="col-md-9"> -->
    <?php
    $select_tenaga = MasterJenisGanis::model()->findAll();
    $list_tenaga = CHtml::listData($select_tenaga, 'id', 'nama_jenis');

    $select_kualifikasi = MasterKualifikasi::model()->findAll();
    $list_kualifikasi = CHtml::listData($select_kualifikasi, 'id_kualifikasi', 'kualifikasi');

    $select_pendidikan = MasterPendidikan::model()->findAll();
    $list_pendidikan = CHtml::listData($select_pendidikan, 'id_pendidikan', 'pendidikan');

    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => Yii::app()->controller->id . '-form',
        'type' => 'horizontal',
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'enableAjaxValidation' => false,
    ));
    ?>
<div class="panel-body">
    <p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->textFieldGroup($model, 'id_perusahaan', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => Yii::app()->user->idPerusahaan())))); ?>
    <?php echo $form->textFieldGroup($model,'nama',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    <?php echo $form->textFieldGroup($model,'ktp',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php echo $form->textFieldGroup($model,'alamat',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php //echo $form->textFieldGroup($model,'tempat_lahir',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php echo $form->datePickerGroup($model,'tgl_lahir',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd', 'autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
	<?php //echo $form->textFieldGroup($model,'no_reg',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php echo $form->select2Group($model, 'id_pendidikan', array('groupOptions' => array('id' => "pendidikan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_pendidikan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Pendidikan'))))); ?>
        <?php echo $form->select2Group($model, 'id_jenis_tenaga_kerja', array('groupOptions' => array('id' => "nama_jenis"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_tenaga, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Jenis Tenaga Kerja'))))); ?>
	<?php echo $form->textFieldGroup($model,'no_sertifikat',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
<!--    <div class="form-group">
        <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Masa Berlaku <span style="color:red">*</span> </label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-6" style="margin-left:-75px">
                    <?php //echo $form->datePickerGroup($model,'tgl_awal_sertifikat',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd', 'autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>','label'=>false)); ?>
                </div>
                <div class="col-md-6">
                    <?php //echo $form->datePickerGroup($model,'tgl_akhir_sertifikat',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd','autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>','label'=>false)) ?>
                </div>
            </div>
        </div>
    </div>-->
	<?php //echo $form->datePickerGroup($model,'tgl_awal_sertifikat',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd', 'autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
	<?php //echo $form->datePickerGroup($model,'tgl_akhir_sertifikat',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd', 'autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>

	<?php //echo $form->select2Group($model, 'id_kualifikasi', array('groupOptions' => array('id' => "kualifikasi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_kualifikasi, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Kualifikasi'))))); ?>
	<?php echo $form->datePickerGroup($model,'tgl_sertifikat',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd', 'autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
        <?php echo $form->dropDownListGroup($model,'is_aktif', array('widgetOptions'=>array('data'=>array("1"=>"Masih Bekerja","0"=>"Sudah Keluar"), 'htmlOptions'=>array('class'=>'input-large','id'=>"select_is_aktif")))); ?>
	<div id="tgl_keluar" style="display:none">
		<?php echo $form->datePickerGroup($model,'tgl_keluar',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd', 'autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>

	</div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Upload Sertifikat </label>
        <div class="col-sm-9">
            <div class="input-group">
                <input name="pdf_sertifikat_ganis" type="file">
            </div>
            <i>Ukuran File Maksimal 2 Mb</i>
            <br>
            <?php
                //{
                    if(!is_null($model->file_doc)) {
//                        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                        echo "File Sertifikat Ganis: <a href='".Yii::app()->createUrl("/").$model->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    }
                //}
            ?>
        </div>
    </div>
</div>
    <div class="panel-footer">
<!--     <div class="form-group"> 
        <div class="col-sm-3"></div>
        <div class="col-sm-9"> -->
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'context' => 'primary',
                'label' => 'Simpan',
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
        <!-- </div> -->
<!--     </div> -->
</div>

<?php $this->endWidget(); ?>
</div>
<!-- </div> -->
<script type="text/javascript">
	$("#select_is_aktif").on('change',function () {
		var v = $("#select_is_aktif").val();
		if(v == 1) {
			$("#tgl_keluar").hide();
		} else {
			$("#tgl_keluar").show();
		}
	});
</script>
