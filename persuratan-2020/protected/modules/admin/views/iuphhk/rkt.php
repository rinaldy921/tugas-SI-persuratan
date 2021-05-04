<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        array(
            'name' => 'id_rku',
            'header' => 'Nomor SK RKU',
            'value' => 'isset($data->id_rku) ? $data->idRku->nomor_sk : null
                            '
        ),
        'nomor_sk',
        'tanggal_sk',
        'tahun',
        array(
            'name' => 'status',
            'value' => '($data->status==1) ? "Aktif" : (($data->status==2) ? "Tidak Aktif" : "Ada Revisi")
                            '
        )
    ),
));
?>