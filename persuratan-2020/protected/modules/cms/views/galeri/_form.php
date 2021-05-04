<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldGroup($model, 'Judul', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'maxlength' => 255)))); ?>
<?php echo $form->textAreaGroup($model, 'Deskripsi', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'rows' => 4)))); ?>
<?php echo $form->fileFieldGroup($model, 'Cover', array('hint' => !empty($model->Cover) ? Yii::t('view', 'Berkas sampul saat ini: ') . $model->Cover : '', 'wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'maxlength' => 255)))); ?>
<div class="form-group">
    <label for="Attachment_files[]" class="col-md-2 col-sm-3 control-label"><?php echo Yii::t('view', 'Berkas Foto'); ?></label>
    <div class="col-md-10 col-sm-9">
        <?php
        $this->widget('CMultiFileUpload', array(
            'model' => new Attachment,
            'attribute' => 'File_Name',
            'name' => 'File_Name',
            'accept' => 'jpeg|jpg|png|gif|bmp',
            'options' => array(),
            'max' => 15,
        ));
        ?>
        <span class="help-block"><?php echo Yii::t('view', 'Gunakan secara berulang untuk mengunggah banyak berkas sekaligus'); ?></span>
        <?php
        $out = '';
        if (!empty($model->attachments)) {
            $i = 1;
            foreach ($model->attachments as $d) {
                $file_link = CHtml::link($d->File_Name, Yii::app()->baseUrl . $d->File_Path, array("data-lightbox" => "image-1", "title" => $d->Keterangan, "class" => "text-info"));
                $file_del = CHtml::checkBox('del_file[]', false, array('value' => $d->id, 'id' => false, 'data-title' => Yii::t('view', 'Tandai untuk dihapus'), 'data-toggle' => 'tooltip'));
                $files[] = '<label class="checkbox-inline">' . $file_del . " " . $i++ . ". " . $file_link . "</label>";
            }
            $out = implode("\n", $files);
            ?>
            <span class="help-block"><?php echo Yii::t('view', 'Berkas Foto saat ini: ') . "<br/>" . nl2br($out); ?></span>
        <?php } ?>
    </div>
</div>
<?php 
if (Yii::app()->user->isAdmin()) {
    echo $form->checkBoxGroup($model, 'published', array('label' => Yii::t('app', 'Publikasikan?'), 'wrapperHtmlOptions' => array('class' => 'col-md-10'))); 
}
?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 col-md-offset-2 col-md-10">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'danger',
            'label' => Yii::t('app', 'Batal'),
            'htmlOptions' => array('onclick' => 'history.go(-1);'),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => Yii::t('app', 'Simpan'),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/lightbox-2.6.min.js", CClientScript::POS_END);
?>
<?php (Yii::app()->booster) ? Yii::app()->booster->registerYiiCss() : null; ?>