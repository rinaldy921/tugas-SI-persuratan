<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs  = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
    <!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
    <link rel="stylesheet" type="text/css" href="<?=$dateCss?>" />
    <script type="text/javascript" src="<?=$dateJs?>"></script>

<?php

 $select_tenaga = MasterJenisGanis::model()->findAll();
 $list_tenaga = CHtml::listData($select_tenaga, 'id', 'nama_jenis');


$select_bphp = MasterBphp::model()->findAll();
$list_bphp = CHtml::listData($select_bphp, 'id', 'nama_bphp');

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=> 'sk-ganis-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldGroup($model,'id_perusahaan',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>Yii::app()->user->idPerusahaan())))); ?>
    <?php echo $form->textFieldGroup($model,'no_reg',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    <?php echo $form->textFieldGroup($model,'no_sk',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    <?php echo $form->datePickerGroup($model,'tgl_sk',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd','autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')) ?>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Masa Berlaku <span style="color:red">*</span> </label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-6" style="margin-left:-75px">
                    <?php echo $form->datePickerGroup($model,'tgl_awal_sk',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd', 'autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>','label'=>false)); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->datePickerGroup($model,'tgl_akhir_sk',array('widgetOptions'=>array('options'=>array('format'=>'yyyy-mm-dd','autoclose'=>true),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>','label'=>false)) ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo $form->select2Group($model, 'id_bphp', array('groupOptions' => array('id' => "nama_bphp"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_bphp, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih BPHP Penerbit SK'))))); ?>
<!--    <div class="form-group">
		<label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File Dokumen (PDF) </label>
		<div class="col-sm-9">
			<div class="input-group">
				<input name="pdf_phpl" type="file">
			</div>
            <br>
            <?php
//                if($id_penilikan != "")
//                {
//                    if(!is_null($model->file_doc)) {
//                        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
//                        echo "File Dokumen: <a href='".Yii::app()->createUrl("/files/PDF/".$p).$model->file_doc."' target='_blank'>".$model->file_doc."</a>";
//                    }
//                }
            ?>
		</div>-->
	</div>

    <button type="button" name="button" class="btn btn-primary pull-right" onclick="simpanSkGanis()">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function simpanSkGanis()
    {
        var form = new FormData($("#sk-ganis-form")[0]);
        $.ajax({
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            var url = "<?php echo $this->createUrl('//perusahaan/iuphhkTenagaKerja/addSkGanis', array('id' => $model->id)); ?>?id_sk_ganis=" + id;
            success: function(result) {
                swal(result.header, result.message, result.status).then((ok) => {
                    if(result.status == "success") {
                        $.fn.yiiGridView.update("sk-ganis-grid");
                        $("#modal").modal("hide");
                        console.log(result.buton_hide);
                        if(result.buton_hide) {
                            $("#buton_new").hide();
                        }
                    }
                });
            },
          error: function(xhr, ajaxOptions, thrownError) {
              swal("Error submiting!", xhr.responseText, "error");
          }
      });
    }
</script>
