<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <div class="col-sm-3" style="text-align: right">
            <?php echo CHtml::activeLabel($model,'id_sektor');?>
        </div>
        <div class="col-sm-9">
            <?php   $rkuId = Yii::app()->session['rku_id'];
                    $model['id_rku'] = $rkuId;
                    
                    echo $form->dropDownList($model,'id_sektor',
                                            CHtml::listData(RkuSektor::model()->findAllByAttributes(array('id_rku'=>$rkuId)),'id_sektor','nama_sektor'),
                                            array('empty'=>'   --- Pilih Sektor ---   ') ); ?>
            </div>
        </div>
        <?php //echo $form->textFieldGroup($model,'id_sektor',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

        <?php echo $form->hiddenField($model,'id_rku',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>


	<?php echo $form->textFieldGroup($model,'nama_blok',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>255)))); ?>

	<?php echo $form->textAreaGroup($model,'desc', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>








	
<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Tambah' : 'Ubah',
		)); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
