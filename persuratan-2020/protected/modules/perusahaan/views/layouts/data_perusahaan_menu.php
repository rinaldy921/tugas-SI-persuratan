<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Data IUPHHK',
            'url' => array('/perusahaan/iuphhk/index'),
            'active' => (Yii::app()->controller->id == 'iuphhk') ? true : false
        ),

        // array(
        //     'label' => 'Adendum SK',
        //     'url' => array('/perusahaan/adendum/index'),
        //     'active' => (Yii::app()->controller->id == 'adendum') ? true : false
        // ),
        array(
            'label' => 'Data Umum',
            'url' => array('/perusahaan/data/index'),
            'active' => (Yii::app()->controller->id == 'data') ? true : false
        ),
        array(
            'label' => 'Data Cabang',
            'url' => array('/perusahaan/branch/index'),
            'active' => (Yii::app()->controller->id == 'branch') ? true : false
        ),
        array(
            'label' => 'Legalitas Perusahaan',
            'url' => array('/perusahaan/legalitas/index'),
            'active' => (Yii::app()->controller->id == 'legalitas') ? true : false
        ),
        // array(
        //     'label' => 'Kepemilikan Saham',
        //     'url' => array('/perusahaan/saham/index'),
        //     'active' => (Yii::app()->controller->id == 'saham') ? true : false
        // ),
        // array(
        //     'label' => 'Data Pengurus',
        //     'url' => array('/perusahaan/dirkom/index'),
        //     'active' => (Yii::app()->controller->id == 'dirkom') ? true : false
        // ),
        // array(
        //     'label' => 'Data Tenaga Kerja',
        //     'url' => array('/perusahaan/tenagaKerja/index'),
        //     'active' => (Yii::app()->controller->id == 'tenagaKerja') ? true : false
        // ),
        array(
            'label' => 'Sertifikasi PHPL / VLK',
            'url' => array('/perusahaan/sertifikasiPhpl/'),
            'active' => (Yii::app()->controller->id == 'sertifikasiPhpl') ? true : false
        ),
        array(
            'label' => 'Tenaga Teknis PHPL',
            'url' => array('/perusahaan/IuphhkTenagaKerja/'),
            'active' => (Yii::app()->controller->id == 'IuphhkTenagaKerja') ? true : false
        ),
        //investasi
        array(
            'label' => 'Investasi',
            'url' => array('/perusahaan/investasi/'),
            'active' => (Yii::app()->controller->id == 'investasi') ? true : false
        ),
        array(
            'label' => 'Laporan Keuangan',
            'url' => array('/perusahaan/laporanKeuangan/'),
            'active' => (Yii::app()->controller->id == 'laporanKeuangan') ? true : false
        ),
        array(
            'label' => 'Peta',
            'url' => array('/perusahaan/spasialRku/'),
            'active' => (Yii::app()->controller->id == 'spasialRku') ? true : false
        ),

        //
    ),
));
?>
