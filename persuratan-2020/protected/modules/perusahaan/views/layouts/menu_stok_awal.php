<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav '.Yii::app()->controller->id),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Stok Awal Tanaman',
            'url' => array('/perusahaan/stoktanaman'),
            'items' => array(
                array(
                    'label' => 'Stok Tanaman',
                    'url' => array('/perusahaan/stoktanaman'),
                    'active' => (Yii::app()->controller->id == 'stoktanaman') ? true : false
                ),
                array(
                    'label' => 'Pemanfaatan Stok Tanaman',
                    'url' => array('/perusahaan/pemanfaatanstoktanaman'),
                    'active' => (Yii::app()->controller->id == 'pemanfaatanstoktanaman') ? true : false
                ),               
            )
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
            'active' => (Yii::app()->controller->id == 'realisasi') ? true : false          
        ),
        array(
            'label' => 'Rekapitulasi',
            'url' => array('/perusahaan/rekapPrasyarat/index'),
            'active' => (Yii::app()->controller->id == 'rekapPrasyarat') ? true : false
        ),

    ),
));
