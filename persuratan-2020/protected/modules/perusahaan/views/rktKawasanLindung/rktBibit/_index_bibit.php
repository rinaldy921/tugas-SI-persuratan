<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-bibit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'mergeColumns' => array('id_produksi_lahan'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        // 'id',
        // 'id_rkt',
        // 'id_blok',
        // array(
        // 	'name'=>'id_blok',
        // 	'value'=>'$data->idBlok->idBlok->nama_blok'
        // ),
        array(
            'name' => 'id_produksi_lahan',
            'value' => '$data->idProduksiLahan->jenis_produksi',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'name' => 'id_jenis_tanaman',
            'value' => '$data->idJenisTanaman->nama_tanaman'
        ),
        // 'jumlah',
        array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktBibit/inputJumlahBibit'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-bibit-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        // 'realisasi',
        array(
            // 'header'=>'Realisasi',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'realisasi',
            'visible' => false,
            'type' => 'raw',
            'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktBibit/inputJumlahBibit'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-bibit-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'realisasi') . '</strong>',
        ),
        array(
            // 'header'=>'%',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
            'name' => 'persentase',
            'value' => 'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>' . $model->getTotalPersen($model->search()->getData(), 'persentase') . '</strong>',
        )
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
    ),
));
?>