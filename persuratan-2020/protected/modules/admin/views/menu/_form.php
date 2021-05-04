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


<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldGroup($model, 'title', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'link', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->select2Group($model, 'posisi', array('groupOptions' => array('id' => "posisi"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => array('1'=>'Menu Atas','2'=>'Menu Samping'), 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', '--- Pilih Posisi Menu ---'))))); ?>
<?php echo $form->textFieldGroup($model, 'parent', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'icon', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'deskripsi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'urutan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

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


