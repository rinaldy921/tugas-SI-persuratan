<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Stok Awal Tanaman',
            'url' => array('/perusahaan/stoktanaman/index'),
            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        array(
            'label' => 'Rencana Kerja Umum (RKU)',
            'url' => array('/perusahaan/rku/index')
        ),
        // array(
        // )
        array(
            'label' => Yii::t('app', 'Rencana Kerja Tahunan (RKT)'),
            'url' => array('/perusahaan/rkt/index'),
        ),
        array(
            'label' => Yii::t('app', 'Realisasi RKT'),
            'url' => array('/perusahaan/realprasyarat/index'),
        ),
        array(
            'label' => Yii::t('app', 'Rekapitulasi'),
            'url' => 'javascript:{}',
            // 'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'Prasyarat',
                    'url' => array('/perusahaan/rekapPrasyarat'),
                    'active' => (Yii::app()->controller->id == 'rekapPrasyarat') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Produksi',
                    'url' => array('/perusahaan/rekapProduksi'),
                    'active' => (Yii::app()->controller->id == 'rekapProduksi') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Lingkungan',
                    'url' => array('/perusahaan/rekapLingkungan'),
                    'active' => (Yii::app()->controller->id == 'rekapLingkungan') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Sosial',
                    'url' => array('/perusahaan/rekapSosial'),
                    'active' => (Yii::app()->controller->id == 'rekapSosial') ? true : false
                ),
                
            )
        ),
    ),
));
