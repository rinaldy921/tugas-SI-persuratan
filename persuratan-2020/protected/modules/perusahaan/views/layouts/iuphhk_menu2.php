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
//         array(
//             'label' => 'Adendum SK',
//             'url' => array('/perusahaan/adendum/index'),
//             'active' => (Yii::app()->controller->id == 'adendum') ? true : false
//         ),
//         array(
//             'label' => 'Kelompok Hutan',
//             'url' => array('/perusahaan/hutan/index'),
//             'active' => (Yii::app()->controller->id == 'hutan') ? true : false
//         ),
//         array(
//             'label' => 'Data Administrasi',
//             'url' => array('/perusahaan/administrasi/index'),
//             'active' => (Yii::app()->controller->id == 'administrasi') ? true : false
//         ),
//         array(
//             'label' => 'Keadaan Lahan',
//             'url' => array('/perusahaan/lahan/index'),
//             'active' => (Yii::app()->controller->id == 'lahan') ? true : false
//         ),
// //        array(
// //            'label' => 'Keadaan Hutan',
// //            'url' => array('/perusahaan/keadaanHutan/index'),
// //            'active' => (Yii::app()->controller->id == 'keadaanHutan') ? true : false
// //        ),
//         array(
//             'label' => 'Topografi',
//             'url' => array('/perusahaan/topografi/index'),
//             'active' => (Yii::app()->controller->id == 'topografi') ? true : false
//         ),
//         array(
//             'label' => 'Geologi',
//             'url' => array('/perusahaan/geologi/index'),
//             'active' => (Yii::app()->controller->id == 'geologi') ? true : false
//         ),
//         array(
//             'label' => 'Iklim',
//             'url' => array('/perusahaan/iklim/index'),
//             'active' => (Yii::app()->controller->id == 'iklim') ? true : false
//         ),
//         array(
//             'label' => 'Hidrologi',
//             'url' => array('/perusahaan/hidrologi/index'),
//             'active' => (Yii::app()->controller->id == 'hidrologi') ? true : false
//         ),
    ),
));
?>