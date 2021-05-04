<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id' => 'side-menu', 'class' => 'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Data IUPHHK',
            'url' => array('/admin/dataiuphhk/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'iuphhk') ? true : false
        ),
        array(
            'label' => 'Adendum SK',
            'url' => array('/admin/adendum/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'adendum') ? true : false
        ),
        array(
            'label' => 'Data Administrasi',
            'url' => array('/admin/administrasi/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'administrasi') ? true : false
        ),
        array(
            'label' => 'Data Umum Areal IUPHHK-HTI',
            'url' => array('/admin/dataUmum/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'dataUmum') ? true : false
        ),
        array(
            'label' => 'Data Keadaan Hutan',
            'url' => array('/admin/keadaanHutan/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'keadaanHutan') ? true : false
        ),
        array(
            'label' => 'Data Hidrologi',
            'url' => array('/admin/hidrologi/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'hidrologi') ? true : false
        ),
        array(
            'label' => 'Data Geologi',
            'url' => array('/admin/geologi/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'geologi') ? true : false
        ),
        array(
            'label' => 'Data Fasilitas',
            'url' => array('/admin/fasilitas/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'fasilitas') ? true : false
        ),
        array(
            'label' => 'Data Penduduk',
            'url' => array('/admin/penduduk/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'penduduk') ? true : false
        ),
        array(
            'label' => 'Rencana Kerja Umum (RKU)',
            'url' => array('/admin/rku/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        array(
            'label' => 'Rencana Kerja Tahunan (RKT)',
            'url' => array('/admin/rkt/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        ),
        array(
            'label' => 'Rekapitulasi RKT',
            'url' => array('/admin/rekapPrasyarat/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'rekapPrasyarat') ? true : false
        ),
        array(
            'label' => 'Laporan Kinerja',
            'url' => array('/admin/laporan/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'laporan') ? true : false
        ),
    ),
));
