<?php

//debug($model); die();

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pemasaran-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
//    'mergeColumns' => array('daur', 'id_pemasaran'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        'daur',
        array(
            'name' =>'RKT Ke',
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke',
        ),
//        'tahun',
        array(
            'header' => 'Jenis Pemasaran',
            'name' => 'id_pemasaran',
            'value' => '$data->idPemasaran->nama_pemasaran',
        ),
        //'jumlah',
        array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktPemasaran/inputJumlahPemasaran'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("rkt-pemasaran-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
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
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemasaran/delete",array("id"=>$data->id))
//				));
//			}
//		),
    ),
));
?>
