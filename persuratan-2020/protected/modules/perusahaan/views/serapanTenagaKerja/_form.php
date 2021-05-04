<?php
$select_kualifikasi = MasterKualifikasi::model()->findAll();
$list_kualifikasi = CHtml::listData($select_kualifikasi, 'id_kualifikasi', 'kualifikasi');

$select_bulan = MasterBulan::model()->findAll();
$list_bulan = CHtml::listData($select_bulan, 'id', 'bulan');

$listRKT = CHtml::listData(
    Rkt::model()->findAll(
            array(
                'condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan(),
                'order' => 'tahun_mulai DESC'
            )
    ), 'id', 'tahun_mulai'
);

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>
<style media="screen">
    .no-spinners {
      -moz-appearance:textfield;
    }

    .no-spinners::-webkit-outer-spin-button,
    .no-spinners::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
</style>
<?php //echo $form->errorSummary($model); ?>


	<?php //echo $form->hiddenField($model, 'id_perusahaan'); ?>
	<!-- <?php
	// echo $form->select2Group($model, 'id_rkt', array(
	// 	'labelOptions' => array('label' => 'RKT', 'class' => 'span7'),
	// 	'widgetOptions' => array('options' => array('allowClear' => false, 'label' => false),
	// 		'data' => $listRKT,
	// 		'htmlOptions' => array('class' => 'span12', 'placeholder' => 'Pilih Periode RKT'))
	// 		)
	// );
	?> -->

    <?php echo $form->datePickerGroup($model,'tahun',array('widgetOptions'=>array('options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
	<?php echo $form->select2Group($model, 'id_bulan', array('groupOptions' => array('id' => "bulan"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list_bulan, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Bulan'))))); ?>
    <?php echo $form->dropDownListGroup($model,'is_tenaga_kehutanan', array('widgetOptions'=>array('data'=>array("1"=>"Tenaga Profesional Bidang Kehutanan","0"=>"Tenaga Lainnya"), 'htmlOptions'=>array('class'=>'input-large','id'=>"select_is_pro")))); ?>
    <?php echo $form->numberFieldGroup($model,'sarjana',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 no-spinners')))); ?>
	<?php echo $form->numberFieldGroup($model,'diploma',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 no-spinners')))); ?>
	<?php echo $form->numberFieldGroup($model,'menengah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 no-spinners')))); ?>
	<?php echo $form->numberFieldGroup($model,'asing',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5 no-spinners')))); ?>
    <?php echo $form->dropDownListGroup($model,'is_tenaga_tetap', array('widgetOptions'=>array('data'=>array("1"=>"Tenaga Tetap","0"=>"Tenaga Tidak Tetap"), 'htmlOptions'=>array('class'=>'input-large','id'=>"select_is_aktif")))); ?>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
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
    </div>
</div>

<?php $this->endWidget(); ?>


<!-- <script type="text/javascript">
	$("#select_is_aktif").on('change',function () {
		var v = $("#select_is_aktif").val();
		if(v == 1) {
			$("#tgl_keluar").hide();
		} else {
			$("#tgl_keluar").show();
		}
	});
</script> -->
