<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $perusahaan,
    'type' => array('bordered', 'striped', 'condensed'),
    'attributes' => array(
//        'nama_perusahaan',
//        'npwp',
        'alamat',
        array(
            'name' => 'provinsi',
            'value' => ($perusahaan->provinsi) ? $perusahaan->provinsiFk->nama : '-',
        ),
        array(
            'name' => 'kabupaten',
            'value' => ($perusahaan->kabupaten) ? $perusahaan->kabupatenFk->nama : '-',
        ),
//        'telepon',
//        'email',
        'fax',
        'kode_pos',
//        'website',
        'kontak',
        'telepon_kontak',
        'email_kontak',
    ),
));
?>