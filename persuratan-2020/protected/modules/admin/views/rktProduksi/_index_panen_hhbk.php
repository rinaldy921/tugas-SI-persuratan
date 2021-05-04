<h4 style="margin: 1em 0 0 0">Pemanenan HHBK</h4>
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pembibitan-grid-rku-match',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuMatch(),
    'enableSorting' => false,
   // 'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
//        'daur',
         array(
            'name' =>'RKT Ke',
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke',
        ),
        'tahun',
       array(
            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
            'header' => 'Tata Ruang',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'header' => 'Jenis HHBK',
            'name'   => 'nama_hhbk',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
        ),
      
        'luas',
        array(
            'name' => 'realisasi_luas',
            'header' => 'Realisasi Luas',
        ),
        array(
            'name' => 'persentase_luas',
            'header' => 'Persentase Luas (%)',
        ),
        array(
            'header' => 'Jumlah',
            // 'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            // 'type' => 'raw',
            'value' => '(!empty($data->jumlah)) ? $data->jumlah. "(".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" : "0 (".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" ',
         ),
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
		
//		array(
//			'header'=>'',
//			'type'=>'raw',
//			'value'=>function($data){
//				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
//					'class'=>'deleteInFunction',
//					'onclick'=>'deleteDataMatch(this)', 
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemanenanHhbk/delete",array("id"=>$data->id))
//				));
//			}
//		),
    ),
));
?>
