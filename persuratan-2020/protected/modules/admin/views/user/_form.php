<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    // 'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
$role = CHtml::listData(AppRole::model()->findAll(),'id','nama_role');
$perusahaan = CHtml::listData(Perusahaan::model()->findAll(),'id_perusahaan','nama_perusahaan');
$bphp = CHtml::listData(MasterBphp::model()->findAll(),'id','nama_bphp');
$prop = CHtml::listData(MasterDishutprov::model()->findAll(),'id','nama');
?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->select2Group($model, 'id_role', array('groupOptions' => array('id' => "role"), 'widgetOptions' => array('data' => $role, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Role...'))))); ?>
<?php $opts  = array(
    'style' => "display:none"
);?>
<?php if(!$model->isNewRecord && strlen($model->id_bphp) > 0): ?>
    <?php $opts  = array(); ?>
<?php endif; ?>
<?php echo $form->select2Group($model, 'id_bphp', array(
    'groupOptions' =>$opts,
    'widgetOptions' => array(
        'data' => $bphp,
        'htmlOptions' => array(
            'class' => 'form-control',
            'placeholder' => Yii::t('app', 'Pilih BPHP...')
        )
    )
));?>


<?php if(!$model->isNewRecord && strlen($model->id_propinsi) > 0): ?>
    <?php $opts  = array(); ?>
<?php endif; ?>
<?php echo $form->select2Group($model, 'id_propinsi', array(
    'groupOptions' =>$opts,
    'widgetOptions' => array(
        'data' => $prop,
        'htmlOptions' => array(
            'class' => 'form-control',
            'placeholder' => Yii::t('app', 'Pilih Dishut Provinsi...')
        )
    )
));?>



<?php //echo $form->textFieldGroup($model, 'id_role', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
<?php $opts  = array(
    'id' => "perusahaan",
    'style' => "display:none"
);?>
<?php if(!$model->isNewRecord && strlen($model->id_perusahaan) > 0): ?>
    <?php $opts  = array(
        'id' => "perusahaan"
    );?>
<?php endif; ?>
<?php echo $form->select2Group($model, 'id_perusahaan', array(
    'groupOptions' => $opts,
    'widgetOptions' => array(
        'options' => array('allowClear' => true),
        'data' => $perusahaan,
        'htmlOptions' => array(
            'class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Perusahaan...'))
        )
    )
); ?>
<?php //echo $form->textFieldGroup($model, 'id_perusahaan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'nama_user', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->textFieldGroup($model, 'no_hp', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->textFieldGroup($model, 'username', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->passwordFieldGroup($model, 'password', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'value' => false)))); ?>

<?php echo $form->passwordFieldGroup($model, 'password_repeat', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Simpan' : 'Simpan',
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
<?php
Yii::app()->clientScript->registerScript("hide","
    $('#". Chtml::activeId($model, 'id_role')."').on('change', function(){
        if($(this).val() == 3){
            $('#". Chtml::activeId($model, 'id_bphp')."').parents('.form-group').fadeIn(400);
            $('#". Chtml::activeId($model, 'id_propinsi')."').parents('.form-group').fadeOut(400);
        }else  if($(this).val() == 4){
            $('#". Chtml::activeId($model, 'id_propinsi')."').parents('.form-group').fadeIn(400);
            $('#". Chtml::activeId($model, 'id_bphp')."').parents('.form-group').fadeOut(400);
        }
    })
    $('#role').on('change', function(){
        if($('#role .select2-chosen').text() != 'Perusahaan'){
            $('#perusahaan').fadeOut(400);
        } else {
            $('#perusahaan').fadeIn(400);
        }
    });
",CClientScript::POS_READY);

Yii::app()->clientScript->registerScript("cekk","
    if($('#role .select2-chosen').text() == 'Administrator') {
        $('#perusahaan').hide();
    }
", CClientScript::POS_LOAD);