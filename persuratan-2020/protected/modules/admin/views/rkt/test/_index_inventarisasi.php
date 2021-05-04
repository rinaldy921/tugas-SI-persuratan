    <?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createKawasanLindung'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-inventarisasi-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(), 
 'enableSorting'=>false,
// 'filter'=>$model,
'template' => '{items}{summary}{pager}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
		// 'id_blok',
		// array(
		// 	'name'=>'id_blok',
		// 	'value'=>'$data->idBlok->idBlok->nama_blok'
		// ),
		array(
			'name'=>'id_jenis_produksi',
			'value'=>'$data->idJenisProduksi->jenis_produksi'
		),
		// 'jumlah',
		array(
			// 'header'=>'Jumlah',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'jumlah',
			'type'=>'raw',
			// 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahInventarisasi'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-inventarisasi-grid");
	            }'
			),
		),
		// 'realisasi',
		array(
			'header'=>'Realisasi',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'realisasi',
			'type'=>'raw',
			// 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahInventarisasi'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-inventarisasi-grid");
	            }'
			),
		),
		array(
            'header'=>'%',
            'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
        )
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
),
)); ?>