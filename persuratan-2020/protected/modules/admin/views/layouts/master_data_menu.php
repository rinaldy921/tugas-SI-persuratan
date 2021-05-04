<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id' => 'side-menu', 'class' => 'nav nipznav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
    'items' => array(
        array(
            'label' => 'Penerbit',
            'url' => array('/admin/penerbit/index'),
            'active' => (Yii::app()->controller->id == 'penerbit') ? true : false
        ),        
        array(
            'label' => 'Provinsi',
            'url' => array('/admin/provinsi/index'),
            'active' => (Yii::app()->controller->id == 'provinsi') ? true : false
        ),
        array(
            'label' => 'Kabupaten/Kota',
            'url' => array('/admin/kabupaten/index'),
            'active' => (Yii::app()->controller->id == 'kabupaten') ? true : false
        ),
        array(
            'label' => 'Kecamatan',
            'url' => array('/admin/kecamatan/index'),
            'active' => (Yii::app()->controller->id == 'kecamatan') ? true : false
        ),
        array(
            'label' => 'Perusahaan',
            'url' => array('/admin/perusahaan/index'),
            'active' => (Yii::app()->controller->id == 'perusahaan') ? true : false
        ),
        array(
            'label' => 'BPHP',
            'url' => array('/admin/masterBphp/index'),
            'active' => (Yii::app()->controller->id == 'masterBphp') ? true : false
        ),
        array(
            'label' => 'Dinas Kehutanan Provinsi',
            'url' => array('/admin/masterDishutprov/index'),
            'active' => (Yii::app()->controller->id == 'masterDishutprov') ? true : false
        ),
        array(
            'label' => 'User',
            'url' => array('/admin/user/index'),
            'active' => (Yii::app()->controller->id == 'user') ? true : false
        ),
         array(
            'label' => 'Group User',
            'url' => array('/admin/roleUser/index'),
            'active' => (Yii::app()->controller->id == 'roleuser') ? true : false
        ),
          array(
            'label' => 'Menu',
            'url' => array('/admin/menu/index'),
            'active' => (Yii::app()->controller->id == 'menu') ? true : false
        ),
        
          array(
            'label' => 'Group Menu',
            'url' => array('/admin/menuRole/index'),
            'active' => (Yii::app()->controller->id == 'menuRole') ? true : false
        ),
          array(
            'label' => 'Wilayah Monitoring Perusahaan',
            'url' => array('/admin/pantauPerusahaanRole/index'),
            'active' => (Yii::app()->controller->id == 'menuRole') ? true : false
        ),
        
        array(
            'label' => 'Jenis Tenaga teknis',
            'url' => array('/admin/masterGanis/index'),
            'active' => (Yii::app()->controller->id == 'masterGanis') ? true : false
        ),
        array(
            'label' => 'KPH',
            'url' => array('/admin/masterKph/index'),
            'active' => (Yii::app()->controller->id == 'masterKph') ? true : false
        ),
        // array(
        //     'label' => 'Data Master',
        //     'url' => 'javascript:{}',
        //     'submenuOptions' => array('style' => 'display:none', 'class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
        //     'items' => array(
        /*
         * array(
            'label' => 'Sektor',
            'url' => array('/admin/masterSektor'),
            'active' => (Yii::app()->controller->id == 'masterSektor') ? true : false
        ),
        
        array(
            'label' => 'Blok',
            'url' => array('/admin/masterBlok'),
            'active' => (Yii::app()->controller->id == 'masterBlok') ? true : false
        ),
         * 
         */
        array(
            'label' => 'Kategori Penduduk',
            'url' => array('/admin/masterKategoriPenduduk'),
            'active' => (Yii::app()->controller->id == 'masterKategoriPenduduk') ? true : false
        ),
        array(
            'label' => 'Jenis Batas',
            'url' => array('/admin/masterJenisBatas'),
            'active' => (Yii::app()->controller->id == 'masterJenisBatas') ? true : false
        ),
        array(
            'label' => 'Jenis Alat Pengendalian Kebakaran',
            'url' => array('/admin/masterJenisDalkar'),
            'active' => (Yii::app()->controller->id == 'masterJenisDalkar') ? true : false
        ),
        array(
            'label' => 'Jenis Infrastruktur Pemukiman',
            'url' => array('/admin/masterJenisInfraMukim'),
            'active' => (Yii::app()->controller->id == 'masterJenisInfraMukim') ? true : false
        ),
        array(
            'label' => 'Jenis Hewan',
            'url' => array('/admin/mJenisHewan'),
            'active' => (Yii::app()->controller->id == 'mJenisHewan') ? true : false
        ),
        array(
            'label' => 'Jenis Kawasan Lindung',
            'url' => array('/admin/masterJenisKawasanLindung'),
            'active' => (Yii::app()->controller->id == 'masterJenisKawasanLindung') ? true : false
        ),
        array(
            'label' => 'Jenis Tanaman',
            'url' => array('/admin/masterJenisTanaman'),
            'active' => (Yii::app()->controller->id == 'masterJenisTanaman') ? true : false
        ),
         array(
            'label' => 'Jenis Tanaman Tumpangsari',
            'url' => array('/admin/masterJenisTanamanTumpangsari'),
            'active' => (Yii::app()->controller->id == 'masterJenisTanamanTumpangsari') ? true : false
        ),
        array(
            'label' => 'Jenis Kayu',
            'url' => array('/admin/masterJenisKayu'),
            'active' => (Yii::app()->controller->id == 'masterJenisKayu') ? true : false
        ),
        array(
            'label' => 'Jenis Kelompok Kayu',
            'url' => array('/admin/masterJenisKelompokKayu'),
            'active' => (Yii::app()->controller->id == 'masterJenisKelompokKayu') ? true : false
        ),
        array(
            'label' => 'Jenis Lahan',
            'url' => array('/admin/masterJenisLahan'),
            'active' => (Yii::app()->controller->id == 'masterJenisLahan') ? true : false
        ),
        array(
            'label' => 'Jenis Pemasaran',
            'url' => array('/admin/masterJenisPemasaran'),
            'active' => (Yii::app()->controller->id == 'masterJenisPemasaran') ? true : false
        ),
        array(
            'label' => 'Jenis Peningkatan SDM',
            'url' => array('/admin/masterJenisPeningkatanSdm'),
            'active' => (Yii::app()->controller->id == 'masterJenisPeningkatanSdm') ? true : false
        ),
        array(
            'label' => 'Jenis Peralatan',
            'url' => array('/admin/masterJenisPeralatan'),
            'active' => (Yii::app()->controller->id == 'masterJenisPeralatan') ? true : false
        ),
        array(
            'label' => 'Jenis Produksi Lahan',
            'url' => array('/admin/masterJenisProduksiLahan'),
            'active' => (Yii::app()->controller->id == 'masterJenisProduksiLahan') ? true : false
        ),
        array(
            'label' => 'Jenis PWH',
            'url' => array('/admin/masterJenisPwh'),
            'active' => (Yii::app()->controller->id == 'masterJenisPwh') ? true : false
        ),
        array(
            'label' => 'Jenis Penutupan Lahan',
            'url' => array('/admin/masterJenisTutupLahan'),
            'active' => (Yii::app()->controller->id == 'masterJenisTutupLahan') ? true : false
        ),
        array(
            'label' => 'Jenis Sarana Prasarana',
            'url' => array('/admin/masterJenisSarpras'),
            'active' => (Yii::app()->controller->id == 'masterJenisSarpras') ? true : false
        ),
        array(
            'label' => 'Jenis Sistem Silvikultur',
            'url' => array('/admin/masterJenisSilvikultur'),
            'active' => (Yii::app()->controller->id == 'masterJenisSilvikultur') ? true : false
        ),
        array(
            'label' => 'Jenis Hasil Hutan Non Kayu',
            'url' => array('/admin/masterHasilHutanNonkayu'),
            'active' => (Yii::app()->controller->id == 'masterHasilHutanNonkayu') ? true : false
        ),
        array(
            'label' => 'Satuan Volume Non Kayu',
            'url' => array('/admin/satuanVolumeNonkayu'),
            'active' => (Yii::app()->controller->id == 'satuanVolumeNonkayu') ? true : false
        ),
		
	array(
            'label' => 'Jenis Pemeliharaan',
            'url' => array('/admin/jenisPemeliharaan/index'),
            'active' => (Yii::app()->controller->id == 'jenisPemeliharaan') ? true : false
        ),
       
        
        array(
            'label' => 'Kelola Sertifikat LK',
            'url' => array('/admin/sertifikasivlk/index'),
            'active' => (Yii::app()->controller->id == 'sertifikasivlk') ? true : false
        ),
        
         array(
            'label' => 'Kelola Sertifikat PHPL',
            'url' => array('/admin/sertifikasiphpl/index'),
            'active' => (Yii::app()->controller->id == 'sertifikasiphpl') ? true : false
        ),
        
        array(
            'label' => 'Rkt Bulan',
            'url' => array('/admin/rktBulan/index'),
            'active' => (Yii::app()->controller->id == 'jenisPemeliharaan') ? true : false
        ),
    ),
));
?>

