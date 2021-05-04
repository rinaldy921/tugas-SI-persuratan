<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-areal-non-produktif-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
//        array(
//            'name' => 'id_blok',
//            'value' => '$data->idBlok->idBlok->nama_blok',
//            'footer' => '<strong>Total</strong>'
//        ),
        array(
            'name' => 'jumlah',
            'type' => 'raw',
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'header' => 'Realisasi',
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