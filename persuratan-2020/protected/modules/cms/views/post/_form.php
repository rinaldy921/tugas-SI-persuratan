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
<?php echo $form->textAreaGroup($model, 'Deskripsi', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'rows' => '5')))); ?>
<?php
echo $form->redactorGroup($model, 'Isi', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('editorOptions' => array(
            'minHeight' => '300',
            'imageUpload' => Yii::app()->createUrl('/site/editorImageUpload'),
            'imageGetJson' => Yii::app()->createUrl('/site/editorImageThumb'),
            'buttons' => array('html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'table', 'link', '|', 'alignment', 'horizontalrule'),), 'htmlOptions' => array('class' => 'form-control form-cascade-control', 'rows' => 6, 'cols' => 50))));
?>
<?php echo $form->fileFieldGroup($model, 'Cover', array('hint' => !empty($model->Cover) ? Yii::t('view', 'Berkas sampul saat ini: ') . $model->Cover : '', 'wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'maxlength' => 255)))); ?>
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
<?php (Yii::app()->booster) ? Yii::app()->booster->registerYiiCss() : null; ?>