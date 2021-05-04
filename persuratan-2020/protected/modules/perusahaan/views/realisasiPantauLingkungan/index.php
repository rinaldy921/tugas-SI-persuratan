<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Pengelolaan & Pemantauan Lingkungan',
        'headerIcon' => 'save'
    )
);?>
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-pemantauanlingkungan-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>
    <?php echo $form->errorSummary($modPantau); ?>
	<?php echo $form->textFieldGroup($modPantau,'id_rkt',array('groupOptions' => array('class' => 'hidden'),'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5', 'value' => $idRkt)))); ?>
	<?php echo $form->textAreaGroup($modPantau,'kegiatan',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>5)))); ?>
	<?php echo $form->textAreaGroup($modPantau,'keterangan',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>5)))); ?>
	<?php $ajaxOptions = array('dataType' => 'json',
        'type' => 'post',
        'success' => 'js:function(data) {
            if(data.status == "success"){
                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-pemantauanlingkungan-grid");
                $("#' . Yii::app()->controller->id . '-pemantauanlingkungan-form")[0].reset();
            } else {
                $.each(data, function(key, val) {
                    $("#' . Yii::app()->controller->id . '-pemantauanlingkungan-form #"+key+"_em_").text(val);
                    $("#' . Yii:: app()->controller->id . '-pemantauanlingkungan-form #"+key+"_em_").show();
                });
            }
        }'
    );?>
    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
    	<?php $this->widget('booster.widgets.TbButton', array(
    			'buttonType'=>'ajaxSubmit',
    			'context'=>'primary',
    			'ajaxOptions'=>$ajaxOptions,
    			'label'=>'Simpan'
    		)); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>

<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-pemantauanlingkungan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modPantau->searchByRkt(),
    'enableSorting' => false,
    'template' => '{items}',
    'columns'=>array(
		'kegiatan',
		'keterangan',
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{delete}',
			'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/rktLingkunganDungtan/deletePantau/", array("id"=>$data->id))',
                ),
            ),
		),
    ),
)); ?>
<?php $this->endWidget(); ?>