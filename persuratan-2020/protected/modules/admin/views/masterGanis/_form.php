<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'nama_jenis', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'val1', array('labelOptions' => array('label' => '< 25.000 Ha'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'val2', array('labelOptions' => array('label' => '25.000 s/d < 50.000 Ha'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
<?php echo $form->textFieldGroup($model, 'val3', array('labelOptions' => array('label' => '50.000 s/d < 100.000 Ha'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
<?php echo $form->textFieldGroup($model, 'val4', array('labelOptions' => array('label' => '100.000 s/d < 200.000 Ha'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
<?php echo $form->textFieldGroup($model, 'val5', array('labelOptions' => array('label' => '> 200.000 Ha'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
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
