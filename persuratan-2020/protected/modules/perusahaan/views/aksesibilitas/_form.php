<div class="panel panel-info">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    'enableAjaxValidation'=>false,
)); ?>

<div class="panel-body">
<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php echo $form->errorSummary($model); ?>
    <?php echo $form->textFieldGroup($model,'rute',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    <?php echo $form->textAreaGroup($model,'keterangan',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>
    <?php //echo $form->textFieldGroup($model,'total_aset',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 number')))); ?>
</div>
    <div class="panel-footer">
<!-- <div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9"> -->
    <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Simpan' : 'Simpan',
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
</div>

<?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".number").number( true, 0, ',' , '.' );
        $('.number').css('text-align', 'right');
    });
</script>
