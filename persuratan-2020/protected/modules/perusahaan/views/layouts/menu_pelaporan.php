<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Laporan Bulanan',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        array(
            'label' => 'Laporan Tahunan',
            'url' => array('#'),
//            'active' => (Yii::app()->controller->id == 'rkt') ? true : false
        )
    ),
));
?>