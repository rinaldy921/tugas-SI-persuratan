<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => Yii::app()->controller->id . '-potensi-produksi-form',
            'type' => 'horizontal',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'enableAjaxValidation' => false,
                ));
        ?>
        <?php // echo $form->errorSummary($potensi_produksi); ?>
        <?php echo $form->textFieldGroup($potensi_produksi, 'id_rku', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->textFieldGroup($potensi_produksi, 'potensi_produksi', array('labelOptions' => array('label' => 'Potensi Rata-rata'),'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)), 'append' => ' m3/Ha ')); ?>
        <p class="help-block">Penulisan koma gunakan titik (.)</p>
        <?php $this->endWidget(); ?>
        <div class="form-group">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'id' => 'subm',
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'size' => 'small',
                    'label' => 'Simpan',
                ));
                ?>
                <div id="load">
                    <img src="<?php echo Yii::app()->baseUrl.'/img/ajax-loader.gif';?>"/>
                    <p class="help-block" style="color:green"> Tersimpan</p>
                </div>
            </div>
        </div>
    </div>
</div>