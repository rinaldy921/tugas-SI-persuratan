<h4 style="margin: 1em 0 0 0">Sesuai RKU</h4>
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pembibitan-grid-rku-match',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuMatch(),
    'enableSorting' => false,
//    'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        'daur',
         array(
            'name' =>'RKT Ke',
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke',
        ),
        array(
            'name' => 'Sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'Blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),
        array(
            'name' => 'Kabupaten',
            'header' => 'Kabupaten',
            'value' => '$data->idKabupaten->nama',
        ),
        array(
            'name' => 'id_jenis_produksi_lahan',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'id_jenis_lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        'jumlah_luas',
        array(
            'name' => 'realisasi_luas',
            'header' => 'Realisasi Luas',
        ),
        array(
            'name' => 'persentase_luas',
            'header' => 'Persentase Luas (%)',
        ),
        'jumlah_produksi',
        array(
            'name' => 'realisasi_produksi',
            'header' => 'Realisasi Produksi',
        ),
        array(
            'name' => 'persentase_produksi',
            'header' => 'Persentase Produksi (%)',
        ),
        /*array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktBibit/inputJumlahBibit'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("rkt-pembibitan-grid-rku-match",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
        //'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ), */
//		
//		array(
//			'header'=>'',
//			'type'=>'raw',
//			'value'=>function($data){
//				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
//					'class'=>'deleteInFunction',
//					'onclick'=>'deleteDataMatch(this)', 
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemanenan/delete",array("id"=>$data->id))
//				));
//			}
//		),
    ),
));
?>

<h4 style="margin: 1em 0 0 0">Tidak Sesuai RKU</h4>
<?php

//$model->unsetAttributes(); 

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pembibitan-grid-rku-dismatch',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuDismatch(),
    'enableSorting' => false,
//    'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        'daur',
        'rkt_ke',
        array(
            'name' => 'Sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'Blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),
         array(
            'name' => 'Kabupaten',
            'header' => 'Kabupaten',
            'value' => '$data->idKabupaten->nama',
        ),
        array(
            'name' => 'id_jenis_produksi_lahan',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'id_jenis_lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        'jumlah_luas',
        array(
            'name' => 'realisasi_luas',
            'header' => 'Realisasi Luas',
        ),
        array(
            'name' => 'persentase_luas',
            'header' => 'Persentase Luas (%)',
        ),
        'jumlah_produksi',
        array(
            'name' => 'realisasi_produksi',
            'header' => 'Realisasi Produksi',
        ),
        array(
            'name' => 'persentase_produksi',
            'header' => 'Persentase Produksi (%)',
        ),     
        //'jumlah',
        /*array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktBibit/inputJumlahBibit'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("rkt-pembibitan-grid-rku-dismatch",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
        //'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ), */
        array(
            'header' => 'Keterangan',
            'name' => 'rkumatch',
            'value' => function($data) {
                return $data->idRktFormAlasan->keterangan;
            }//'$data->idJenisTanaman->nama_tanaman'
        ),
//		array(
//			'header'=>'',
//			'type'=>'raw',
//			'value'=>function($data){
//				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
//					'class'=>'deleteInFunction',
//					'onclick'=>'deleteDataDisMatch(this)', 
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemanenan/delete",array("id"=>$data->id))
//				));
//			}
//		),
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'showAlasan(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktBibit/showAlasan",array("id"=>$data->id_rkt_form_alasan,'model'=>'RktPanenProduksi'))
				));
			}
		),
    ),
));
?>