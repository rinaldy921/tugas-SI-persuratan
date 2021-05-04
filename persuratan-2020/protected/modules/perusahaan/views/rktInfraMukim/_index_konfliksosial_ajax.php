<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-konfliksosial-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$modelKonflikSosial->search(),
'enableSorting' => false,
// 'filter'=>$model,
'template' => '{items}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
		// 'id_blok',
		// array(
		// 	'name'=>'id_blok',
		// 	'value'=>'$data->idBlok->idBlok->nama_blok'
		// ),
		// array(
		// 	'name'=>'id_jenis_sarpras',
		// 	'value'=>'$data->idJenisSarpras->jenis_sarpras'
		// ),
		'jenis_konflik',
		'penanganan',
		// array(
		// 	// // 'header'=>'Jumlah',
		// 	'class'=>'booster.widgets.TbEditableColumn',
		// 	'name'=>'penanganan',
		// 	'type'=>'raw',
		// 	// 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
		// 	'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahBangunSarpras')),
		// ),
		// 'realisasi',
		array(
			// 'header'=>'Realisasi',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'status',
			// 'type'=>'raw',
			// 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktInfraMukim/inputStatusKonflik')),
		),
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{delete}',
			'buttons' => array(
                // 'update' => array(
                //     'visible' => '(Yii::app()->user->idPerusahaan() == $data->idJenisPeralatan->id_perusahaan) ? "1" : "0" ',
                // ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/rktInfraMukim/deleteKonflik/", array("id"=>$data->id))',
                ),
            ),
		),
),
)); ?>