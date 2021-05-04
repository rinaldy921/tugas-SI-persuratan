<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav '.Yii::app()->controller->id),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Stok Awal Tanaman',
            'url' => array('/perusahaan/stoktanaman/index'),
            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        array(
            'label' => 'Rencana Kerja Umum (RKU)',
            'url' => array('/perusahaan/rku/index'),
            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        array(
            'label' => 'Rencana Kerja Tahunan (RKT)',
            'url' => array('/perusahaan/rkt/index'),
            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        ),
        // array(
        // )
        array(
            'label' => Yii::t('app', 'Realisasi RKT'),
            'url' => 'javascript:{}',
            // 'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'Prasyarat',
                    'url' => array('/perusahaan/realprasyarat'),
                    'active' => (Yii::app()->controller->id == 'realprasyarat') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Produksi',
                    'url' => array('/perusahaan/realproduksi'),
                    'active' => (Yii::app()->controller->id == 'realproduksi') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Lingkungan',
                    'url' => array('/perusahaan/reallingkungan'),
                    'active' => (Yii::app()->controller->id == 'reallingkungan') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Sosial',
                    'url' => array('/perusahaan/realsosial'),
                    'active' => (Yii::app()->controller->id == 'realsosial') ? true : false
                ),
                // array(
                //     'label' => 'Serapan Tenaga Kerja',
                //     'url' => array('/perusahaan/serapanTenagaKerja'),
                //     'active' => (Yii::app()->controller->id == 'serapanTenagaKerja') ? true : false
                // ),
            )
        ),
        array(
            'label' => 'Rekapitulasi',
            'url' => array('/perusahaan/rekapPrasyarat/index'),
            'active' => (Yii::app()->controller->id == 'rekapPrasyarat') ? true : false
        ),

    ),
));
