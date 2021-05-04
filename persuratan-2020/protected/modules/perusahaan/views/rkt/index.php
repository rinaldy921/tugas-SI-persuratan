<?php
$this->breadcrumbs=array(
	'RKT'=>array('index'),
	'Manage',
);
$list = $arrays = CHtml::listData(Rkt::model()->findAll(array('select' => 'tahun_mulai', 'order' => 'tahun_mulai ASC', 'condition'=>'id_rku = '.$model->id_rku)), 'tahun_mulai', 'tahun_mulai');
// var_dump($list);die;
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Rkt</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(), 
 'enableSorting'=>false,
'filter'=>$model,
 'rowCssClassExpression'=>'($data->status==2)?"normal":"especial"',
'template' => '{items}',
'columns'=>array(
		// 'id',
		// 'id_perusahaan',
		// 'id_rku',
        array(
		  'name'=>'rkt_ke',
          'filter' => CHtml::dropDownList(get_class($model) . "[rkt_ke]", $model->rkt_ke, $list, array("empty"=>"Pilih RKT Ke ...","class" => "form-control"))
        ),
        array(
		  'name'=>'tahun_mulai',
          'filter' => CHtml::dropDownList(get_class($model) . "[tahun_mulai]", $model->tahun_mulai, $list, array("empty"=>"Pilih Tahun...","class" => "form-control"))
        ),
		'nomor_sk',
		array(
            'name'=>'tanggal_sk',
            'value'=>'isset($data->tanggal_sk) ? Yii::app()->controller->getDateMonth($data->tanggal_sk) : null',
            'filter' => CHtml::activeTextField($model, 'tanggal_sk', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Format: yyyy-mm-dd'))),
        ),
        array(
            'name'=>'mulai_berlaku',
            'value'=>'isset($data->mulai_berlaku) ? Yii::app()->controller->getDateMonth($data->mulai_berlaku) : null',
            'filter' => CHtml::activeTextField($model, 'mulai_berlaku', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Format: yyyy-mm-dd'))),
        ),
        array(
            'name'=>'akhir_berlaku',
            'value'=>'isset($data->akhir_berlaku) ? Yii::app()->controller->getDateMonth($data->akhir_berlaku) : null',
            'filter' => CHtml::activeTextField($model, 'akhir_berlaku', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Format: yyyy-mm-dd'))),
        ),
        array(
            'name'=>'status',
            'header'=>'Status',
            'value'=>'$data->cekRev($data->id_rku, $data->id)',
            'filter' => CHtml::dropDownList(get_class($model) . "[status]", $model->status, array('1'=>'Aktif','2'=>'Telah direvisi'), array("empty"=>"Pilih Status...","class" => "form-control"))
        ),
		/*
		'tahun_sampai',
		'status',
		'created_at',
		'modified_at',
		*/
	array(
        'header'=>'Aksi',
		'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{revisi} {update} {delete} {telahDirevisi} {file_1} {file_2}',
		'buttons'=>array(
			'revisi' => array(
                'label' => "<i class='glyphicon glyphicon-repeat'></i>",
                'options' => array('title' => Yii::t('app', 'Revisi'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/revisi", array("id"=>$data->id))',
            	'visible' => '$data->status == 1 ? "1" : "0"'
            ),
            'update' => array(
            	'visible' => '$data->status == 1 ? "1" : "0"'
            ),
            'delete' => array(
            	'visible' => '$data->status == 1 ? "1" : "0"'
            ),
            'telahDirevisi' => array(
            	'label' => "<i class='glyphicon glyphicon-eye-open'></i>",
            	'options' => array('title' => Yii::t('app', 'Telah Direvisi'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/indexRev", array("id"=>$data->id))',
            	'visible' => '$data->status == 2 ? "1" : "0"'
            ),
            'file_1' => array(
                'options' => array('data-toggle' => 'tooltip', 'title' => 'File SK RKT' ),
                'label' => '<i class="fa fa-file-pdf-o"></i>',
                'visible' => '$data->file_doc == null ? "0" : "1"',
                'url' => function ($data) {
                    if(!is_null($data->file_doc)) {
                        $file = $this->createUrl('/').$data->file_doc;
                        return $file;
                    }
                }
            ),
            'file_2' => array(
                'options' => array('data-toggle' => 'tooltip', 'title' => 'File SHP' ),
                'label' => '<i class="glyphicon glyphicon-file"></i>',
                'visible' => '$data->file_shp == null ? "0" : "1"',
                'url' => function ($data) {
                    if(!is_null($data->file_shp)) {
                        $file = $this->createUrl('/').$data->file_shp;
                        return $file;
                    }
                }
            ), 
		)
	),
),
)); ?>
</div>