<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-kerjasama-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<!-- <p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p> -->

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'id_rkt',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$idRkt)))); ?>

	<?php echo $form->textFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php //echo $form->textFieldGroup($model,'realisasi',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<div class="form-group">
		<label class="col-sm-3 control-label">Realisasi (%)</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<?php
					if(isset($model->jumlah) && $model->jumlah > 0 && isset($model->realisasi) && $model->realisasi > 0) {
						echo round(($model->realisasi / $model->jumlah) * 100, 2). ' %';
					} else {
						echo '-';
					}
				?>
			</p>
		</div>
	</div>
<?php $this->endWidget(); ?>