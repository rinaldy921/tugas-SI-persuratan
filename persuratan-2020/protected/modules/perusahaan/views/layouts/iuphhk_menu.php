<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(

        array(
            'label' => 'Kelompok Hutan',
            'url' => array('/perusahaan/hutan/index'),
            'active' => (Yii::app()->controller->id == 'hutan') ? true : false
        ),
        array(
            'label' => 'Data Administrasi',
            'url' => array('/perusahaan/administrasi/index'),
            'active' => (Yii::app()->controller->id == 'administrasi') ? true : false
        ),
        array(
            'label' => 'Keadaan Lahan',
            'url' => array('/perusahaan/lahan/index'),
            'active' => (Yii::app()->controller->id == 'lahan') ? true : false
        ),
        array(
            'label' => 'Keadaan Hutan',
            'url' => array('/perusahaan/iuphhkTutupLahan/index'),
            'active' => (Yii::app()->controller->id == 'iuphhkTutupLahan') ? true : false
        ),
        array(
            'label' => 'Topografi',
            'url' => array('/perusahaan/topografi/index'),
            'active' => (Yii::app()->controller->id == 'topografi') ? true : false
        ),
        array(
            'label' => 'Geologi',
            'url' => array('/perusahaan/geologi/index'),
            'active' => (Yii::app()->controller->id == 'geologi') ? true : false
        ),
        array(
            'label' => 'Iklim',
            'url' => array('/perusahaan/iklim/index'),
            'active' => (Yii::app()->controller->id == 'iklim') ? true : false
        ),
        array(
            'label' => 'Hidrologi',
            'url' => array('/perusahaan/hidrologi/index'),
            'active' => (Yii::app()->controller->id == 'hidrologi') ? true : false
        ),
        array(
            'label' => 'Data Jumlah Penduduk',
            'url' => array('/perusahaan/iuphhkDataPenduduk/'),
            'active' => (Yii::app()->controller->id == 'iuphhkDataPenduduk') ? true : false
        ),
        array(
            'label' => 'Data Agama & Kepercayaan Penduduk',
            'url' => array('/perusahaan/iuphhkAgama/'),
            'active' => (Yii::app()->controller->id == 'iuphhkAgama') ? true : false
        ),
        array(
            'label' => 'Data Mata Pencaharian Penduduk',
            'url' => array('/perusahaan/iuphhkPekerjaanPenduduk/'),
            'active' => (Yii::app()->controller->id == 'iuphhkPekerjaanPenduduk') ? true : false
        ),
        array(
            'label' => 'Data Fasilitas Tempat Pendidikan',
            'url' => array('/perusahaan/iuphhkTempatPendidikan/'),
            'active' => (Yii::app()->controller->id == 'iuphhkTempatPendidikan') ? true : false
        ),
        array(
            'label' => 'Data Fasilitas Tempat Ibadah',
            'url' => array('/perusahaan/iuphhkTempatIbadah/'),
            'active' => (Yii::app()->controller->id == 'iuphhkTempatIbadah') ? true : false
        ),
        array(
            'label' => 'Data Satwa Dilindungi',
            'url' => array('/perusahaan/iuphhkSatwa/'),
            'active' => (Yii::app()->controller->id == 'iuphhkSatwa') ? true : false
        ),
        array(
            'label' => 'Progres Tata Batas',
            'visible'=> (Rkt::model()->find(array('condition'=>'id_perusahaan='.Yii::app()->user->idPerusahaan()))) ? true : false,
            'url' => array('/perusahaan/progresTataBatas/index'),
            'active' => (Yii::app()->controller->id == 'progresTataBatas') ? true : false
        )
    ),
));
?>
