<?
$this->pageTitle = Yii::t('view', 'Kirim Pesan Baru');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="panel-title">
        <i class="fa fa-envelope-o"></i> 
        <?php echo $this->pageTitle; ?>
    </h3>
</div>
<div class="modal-body">
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => Yii::app()->controller->id . '-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'type' => 'horizontal',
    ));
    echo $form->errorSummary($model);
    echo $form->textFieldGroup($model, 'user_tujuan', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('value' => $username, 'class' => 'form-control form-cascade-control', 'disabled' => true))));
    echo $form->textFieldGroup($model, 'judul', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'maxlength' => 255))));
    echo $form->textAreaGroup($model, 'pesan', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'rows' => 4, 'cols' => 50))));
    echo $form->hiddenField($model, 'user_tujuan');
    ?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9 col-md-offset-2 col-md-10">
            <button type="reset" data-dismiss="modal" class="btn btn-danger">
                <?php echo Yii::t('view', 'Batal'); ?>
            </button> 
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'context' => 'primary',
                'label' => Yii::t('app', 'Kirim'),
            ));
            ?>            
        </div>
    </div>    
    <?php $this->endWidget(); ?>
</div>
<?php (Yii::app()->booster) ? Yii::app()->booster->registerYiiCss() : null; ?>