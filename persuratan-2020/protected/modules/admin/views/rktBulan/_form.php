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



  $select_role = AppRole::model()->findAll();
  $list_role = CHtml::listData($select_role, 'id', function($model) {
                $gabung = $model->id . " | " .
                        $model->nama_role;
                return $gabung;
            });
            
  $select_menu = Menu::model()->findAll();
  $list_menu = CHtml::listData($select_menu, 'id', function($model2) {
                $gabung2 = $model2->id . " | " .
                        $model2->title;
                return $gabung2;
            });         
            
?>


<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldGroup($model, 'id_rkt', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php //echo $form->select2Group($model, 'id_rkt', array('groupOptions' => array('id' => "id_rkt"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_role, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Unit Group User/Role...'))))); ?>        
<?php //echo $form->select2Group($model, 'id_menu', array('groupOptions' => array('id' => "id_role"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_menu, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Unit Group User/Role...'))))); ?>        
<?php //echo $form->textFieldGroup($model, 'id_role', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->textFieldGroup($model, 'bulan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
 

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


