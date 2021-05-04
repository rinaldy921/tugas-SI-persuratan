<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Rencana Kerja Umum (RKU)',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        array(
            'label' => 'Rencana Kerja Tahunan (RKT)',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        ),
        array(
            'label' => 'Realisasi Bulanan',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        ),
        array(
            'label' => 'Realisasi Tahunan',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        ),
        array(
            'label' => 'Tata Batas Areal Kerja',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        ),
        array(
            'label' => 'Sertifikat PHPL/VLK',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        )
    ),
));
?>