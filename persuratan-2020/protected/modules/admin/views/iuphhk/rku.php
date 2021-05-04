<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nomor_sk',
        array(
            'name' => 'tgl_sk',
            'value' => 'isset($data->tgl_sk) ? Yii::app()->controller->getDateMonth($data->tgl_sk) : null'
        ),
        'tahun_mulai',
        'tahun_sampai',
        array(
            'name' => 'status',
            'value' => '($data->status==1) ? "Aktif" : (($data->status==2) ? "Tidak Aktif" : "Ada Revisi")
                            '
        )
    ),
));
?>