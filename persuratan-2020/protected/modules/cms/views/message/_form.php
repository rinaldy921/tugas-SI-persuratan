<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->select2Group($model, 'user_tujuan', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('asDropDownList' => false, 'options' => array('minimumInputLength' => 3, 'multiple' => true, 'ajax' => array('url' => CHtml::normalizeUrl(array('getUser')), 'data' => "js: function(term, page) { return {username: term, page: page}; }", 'results' => "js: function(data, page) { return {results: data, more: true}; }"), 'tokenSeparators' => array(',', ' ')), 'htmlOptions' => array('class' => 'form-control form-cascade-control', 'placeholder' => Yii::t('view', 'Pilih pengguna...'))))); ?>
<?php echo $form->textFieldGroup($model, 'judul', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'maxlength' => 255)))); ?>
<?php echo $form->redactorGroup($model, 'pesan', array('wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control form-cascade-control', 'rows' => 6, 'cols' => 50)))); ?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 col-md-offset-2 col-md-10">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'danger',
            'label' => Yii::t('app', 'Batal'),
            'htmlOptions' => array('onclick' => 'history.go(-1);'),
        ));
        ?>
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
<?php (Yii::app()->booster) ? Yii::app()->booster->registerYiiCss() : null; ?>