<?php

//debug($model); die();

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pemasaranHhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
//    'mergeColumns' => array('daur', 'id_pemasaran'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        
        array(
            'name' =>'RKT Ke',
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke',
        ),
//       'tahun',
        array(
            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
            'header' =>'Tata Ruang',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'header' => 'Jenis HHBK',
            'name'   => 'nama_hhbk',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'header' => 'Jenis Pemasaran',
            'name' => 'id_jenis_pasar',
            'value' => '$data->idJenisPasar->nama_pemasaran',
        ),
        //'jumlah',
        array(
            // 'header'=>'Jumlah',
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
//            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
//            'editable' => array('url' => $this->createUrl('//perusahaan/rktPemasaranHhbk/inputJumlahPemasaran'),
//                'success' => 'js:function() {
//	                $.fn.yiiGridView.update("rkt-pemasaranHhbk-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
//	            }'
//            ),
        //'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'name' => 'realisasi',
            'header' => 'Realisasi',
        ),
        array(
            'name' => 'persentase',
            'header' => 'Persentase (%)',
        ),
//		array(
//			'header'=>'',
//			'type'=>'raw',
//			'value'=>function($data){
//				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
//					'class'=>'deleteInFunction',
//					'onclick'=>'deleteDataMatch(this)', 
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemasaranHhbk/delete",array("id"=>$data->id))
//				));
//			}
//		),
    ),
));
?>

