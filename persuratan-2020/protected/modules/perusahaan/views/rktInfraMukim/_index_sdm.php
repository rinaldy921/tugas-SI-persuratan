    <?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createKawasanLindung'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-sdm-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
 'enableSorting'=>false,
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
		array(
			'name'=>'id_peningkatan_sdm',
			'value'=>'$data->idPeningkatanSdm->nama_program',
			'footer' => '<strong>Total</strong>'
		),
		array(
			// 'header'=>'Jumlah',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'jumlah',
			'type'=>'raw',
			'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktInfraMukim/inputJumlahPeningkatanSdm'),
				'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-sdm-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
                }'
			),
			'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
		),
		// 'realisasi',
		array(
			// 'header'=>'Realisasi',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'realisasi',
			'visible'=>false,
			'type'=>'raw',
			'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",",".") : ""',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktInfraMukim/inputJumlahPeningkatanSdm'),
				'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-sdm-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
                }'
			),
			'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
		),
		array(
            // 'header'=>'%',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? round(($data->realisasi / $data->jumlah) * 100,2) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
        )
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
),
)); ?>