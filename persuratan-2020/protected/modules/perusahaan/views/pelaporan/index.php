<?php
$this->breadcrumbs = array(
    'Kinerja'
);
?>
<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Pelaporan</h4>
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

    <?php echo $form->textFieldGroup($model, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'col-md-8', 'value' => Yii::app()->user->idIuphhk())))); ?>

    <?php echo $form->textFieldGroup($model, 'id_rkt', array('groupOptions' => array('class' => 'hidden'),'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textFieldGroup($model, 'aspek_1', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textFieldGroup($model, 'aspek_2', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textFieldGroup($model, 'aspek_3', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textFieldGroup($model, 'aspek_4', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textFieldGroup($model, 'aspek_5', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

    <?php echo $form->textFieldGroup($model, 'aspek_6', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'context' => 'primary',
                'label' => 'Update',
            ));
            ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>