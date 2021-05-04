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
    $select_penerbit = MasterPenerbit::model()->findAll();
    $list_penerbit = CHtml::listData($select_penerbit, 'id_penerbit', 'penerbit');

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
    <?php echo $form->textFieldGroup($model, 'nomor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('format' => 'yyyy-mm-dd', 'autoclose' => true), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Masa Berlaku <span style="color:red">*</span> </label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-6" style="margin-left:-75px">
<?php echo $form->datePickerGroup($model, 'tanggal_mulai', array('widgetOptions' => array('options' => array('format' => 'yyyy-mm-dd', 'autoclose' => true), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'label' => false)); ?>
                </div>
                <div class="col-md-6">
<?php echo $form->datePickerGroup($model, 'tanggal_berakhir', array('widgetOptions' => array('options' => array('format' => 'yyyy-mm-dd', 'autoclose' => true), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'label' => false)) ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo $form->dropDownListGroup($model, 'predikat', array('widgetOptions' => array('data' => array("Baik" => "Baik", "Sedang" => "Sedang", "Buruk" => "Buruk"), 'htmlOptions' => array('class' => 'input-large')))); ?>
<?php echo $form->select2Group($model, 'id_penerbit', array('groupOptions' => array('id' => "penerbit"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_penerbit, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Penerbit'))))); ?>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">Upload Sertifikat (PDF) </label>
        <div class="col-sm-9">
            <div class="input-group">
                <input name="pdf_sertifikat_phpl" type="file">
            </div>
            <i>Ukuran File Maksimal 2 Mb</i>
            <br>
            <?php
                {
                    if(!is_null($model->file_doc)) {
                        echo "File Sertifikat: <a href='".Yii::app()->createUrl("/").$model->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    }
                }
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
