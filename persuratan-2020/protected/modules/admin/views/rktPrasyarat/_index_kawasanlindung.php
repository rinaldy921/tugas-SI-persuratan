<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kawasanlindung-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'template' => "{items}",
    'columns' => array(
        array(
            'name' => 'id_kawasan_lindung',
            'header' => 'Kawasan Lindung',
            'value' => '$data->idKawasanLindung->nama_jenis',
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Rencana',
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
