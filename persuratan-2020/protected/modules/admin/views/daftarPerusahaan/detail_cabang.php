<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-cabang-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $cabang->search(),
    'enableSorting' => false,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_cabang',
//        'npwp',
        'alamat',
        array(
            'name' => 'provinsi',
            'value' => '(!empty($data->provinsi)) ? $data->provinsiCabang->nama : "-"',
        ),
        array(
            'name' => 'kabupaten',
            'value' => '(!empty($data->kabupaten)) ? $data->kabupatenCabang->nama : "-"',
        ),
        'telepon',
        'email',
        'fax',
        'kode_pos',
        'website',
        'kontak',
        'telepon_kontak',
        'email_kontak',
    ),
));
?>