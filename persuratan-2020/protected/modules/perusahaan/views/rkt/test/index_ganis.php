<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'ganis-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'name' => 'id_ganis',
            'value' => '$data->idGanis->nama_jenis',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'name' => 'jumlah',
            'value' => 'isset($data->jumlah) ? number_format($data->jumlah,0) : "" ',
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'name' => 'realisasi',
            'type' => 'raw',
            'value' => 'isset($data->realisasi) ? number_format($data->realisasi,0) : "" ',
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