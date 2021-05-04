<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-bibit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        array(
            'name' => 'id_produksi_lahan',
            'value'=>'$data->idProduksiLahan->jenis_produksi',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'header' => 'Jenis Tanaman',
            'value' => '$data->idJenisTanaman->nama_tanaman'
        ),
        array(
            'name' => 'jumlah',
            'type' => 'raw',
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'name' => 'realisasi',
            'type' => 'raw',
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'realisasi') . '</strong>',
        ),
        array(
            'name' => 'persentase',
            'value' => 'isset($data->persentase) ? $data->persentase : "0"',
            'footer' => '<strong>' . $model->getTotalPersen($model->search()->getData(), 'persentase') . '</strong>',
        )
    ),
));
?>