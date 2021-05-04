<?php

$this->widget('booster.widgets.TbGridView', array(
'id' => Yii::app()->controller->id.'-evaluasikeberhasilan-grid',
 'type' => 'bordered condensed striped',
 'responsiveTable' => true,
        'dataProvider' => $model-> search(),
        'enableSorting' => false,
// 'filter'=>$model,
        'template' => '{items}',
        'columns' => array (
    array(
    'name' => 'id_ganis',
    'value' => '$data->idGanis->nama_jenis',
    'footer' => '<strong>Total</strong>'
    ),
    array(
        'name' => 'jumlah',
        'type' => 'raw',
        'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
        ),
        array(
        'header' => 'Realisasi',
        'name' => 'realisasi',
        'type' => 'raw',
        'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
        ),
        array(
            'name' => 'persentase',
            'value' => 'isset($data->persentase) ? $data->persentase : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
            )
            ),
            ));
       ?>