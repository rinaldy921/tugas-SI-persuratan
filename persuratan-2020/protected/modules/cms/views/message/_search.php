<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
        ));
?>

<?php echo $form->textFieldGroup($model, 'judul', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'maxlength' => 255)))); ?>
<?php echo $form->textAreaGroup($model, 'pesan', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'rows' => 6, 'cols' => 50)))); ?>
<?php echo $form->textFieldGroup($model, 'tanggal', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control')))); ?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 col-md-offset-2 col-md-10">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => Yii::t('app', ' Cari '),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
