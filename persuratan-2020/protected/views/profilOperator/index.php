<?php
$this->breadcrumbs=array(
	'Profil Operator',
);
?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_operator.php'; ?>
        </div>
    </div>
</div>

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>
<div id="page-wrapper" class="col-md-9">
<h4 class="page-header">Profile Operator</h4>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>
<?php echo $form->textFieldGroup($model,'nama_user',array(
	'widgetOptions'=>array(
		'htmlOptions'=>array(
			'class'=>'span5',
			'maxlength'=>100
		)
	)
)); ?>
<?php echo $form->textFieldGroup($model,'no_hp',array(
	'widgetOptions'=>array(
		'htmlOptions'=>array(
			'class'=>'span5',
			'maxlength'=>100
		)
	)
)); ?>
<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Tambah' : 'Simpan',
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
</div>
<?php $this->endWidget(); ?>

