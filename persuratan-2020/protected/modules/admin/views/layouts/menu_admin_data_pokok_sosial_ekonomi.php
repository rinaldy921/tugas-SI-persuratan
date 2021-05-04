<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id' => 'side-menu', 'class' => 'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
                array(
            'label' => Yii::t('app', 'Data Izin'),
//            'url' => 'javascript:{}',
            'url' => array('/admin/administrasi/' . Yii::app()->request->getQuery('id')),
            'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'SK Izin',
                    'url' => array('/admin/dataIzin/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'dataIzin') ? true : false          
                    ),
                array(
                    'label' => 'Data Perusahaan',
                    'url' => array('/admin/dataPerusahaan/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'dataPerusahaan') ? true : false
                    ),
                array(
                    'label' => 'Data Cabang',
                    'url' => array('/admin/dataCabang/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'dataCabang') ? true : false
                    ),
                array(
                    'label' => 'Investasi',
                    'url' => array('/admin/investasi/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'investasi') ? true : false
                    ),
                array(
                    'label' => 'Legalitas Perusahaan',
                    'url' => array('/admin/legalitas/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'legalitas') ? true : false
                    ),
                array(
                    'label' => 'Sertifikasi PHPL dan VLK',
                    'url' => array('/admin/sertifikasi/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'sertifikasi') ? true : false
                    ),
                array(
                    'label' => 'Tenaga Teknis PHPL',
                    'url' => array('/admin/ganis/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'ganis') ? true : false
                    ),
                array(
                    'label' => 'Progres Tata Batas',
                    'url' => array('/admin/tataBatas/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'tataBatas') ? true : false
                    ),
                array(
                    'label' => 'Laporan Keuangan',
                    'url' => array('/admin/laporanKeuangan/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'laporanKeuangan') ? true : false
                    ),
            )
        ),
        array(
            'label' => Yii::t('app', 'Kondisi Areal Kerja'),
            // 'url' => 'javascript:{}',
            'url' => array('/admin/administrasi/' . Yii::app()->request->getQuery('id')),
            'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                    array(
                        'label' => 'Data Administrasi',
                        'url' => array('/admin/administrasi/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'administrasi') ? true : false
                    ),
                    array(
                        'label' => 'Kelompok Hutan',
                        'url' => array('/admin/kelompokHutan/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'kelompokHutan') ? true : false
                    ),
                    array(
                        'label' => 'Keadaan Lahan',
                        'url' => array('/admin/keadaanLahan/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'keadaanLahan') ? true : false
                    ),
                    array(
                        'label' => 'Keadaan Hutan',
                        'url' => array('/admin/keadaanHutan/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'keadaanHutan') ? true : false
                    ),
                    array(
                        'label' => 'Topografi',
                        'url' => array('/admin/topografi/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'topografi') ? true : false
                    ),
                    array(
                        'label' => 'Geologi',
                        'url' => array('/admin/geologi/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'geologi') ? true : false
                    ),
                    array(
                        'label' => 'Iklim',
                        'url' => array('/admin/iklim/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'iklim') ? true : false
                    ),
                    array(
                        'label' => 'Hidrologi',
                        'url' => array('/admin/hidrologi/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'hidrologi') ? true : false
                    ),
            )
        ),    
        array(
            'label' => Yii::t('app', 'Aksesibilitas'),
            'url' => array('/admin/aksesibilitas/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'aksesibilitas') ? true : false
        ),
        array(
            'label' => Yii::t('app', 'Sosial Ekonomi'),
             'url' => 'javascript:{}',
//            'url' => array('/admin/penduduk/' . Yii::app()->request->getQuery('id')),
//            'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                    array(
                        'label' => 'Data Jumlah Penduduk',
                        'url' => array('/admin/penduduk/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'penduduk') ? true : false
                    ),
                    array(
                        'label' => 'Data Agama & Kepercayaan Penduduk',
                        'url' => array('/admin/agama/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'agama') ? true : false
                    ),
                    array(
                        'label' => 'Data Mata Pencaharian Penduduk',
                        'url' => array('/admin/pekerjaan/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'pekerjaan') ? true : false
                    ),
                    array(
                        'label' => 'Data Fasilitas Tempat Pendidikan',
                        'url' => array('/admin/tempatPendidikan/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'tempatPendidikan') ? true : false
                    ),
                    array(
                        'label' => 'Data Fasilitas Tempat Ibadah',
                        'url' => array('/admin/tempatIbadah/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'tempatIbadah') ? true : false
                    ),
                    array(
                        'label' => 'Data Satwa Dilindungi',
                        'url' => array('/admin/satwa/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->id == 'satwa') ? true : false
                    ),
            )
        ),     
        array(
            'label' => Yii::t('app', 'Rencana Kerja Umum (RKU)'),
//            'url' => 'javascript:{}',
            'url' => array('/admin/rku/' . Yii::app()->request->getQuery('id')),
            'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'Legalitas',
                    'url' => array('/admin/rku/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'rku') ? true : false,
                    'items' => array(
                        array(
                            'label' => 'Sistem Silvikultur',
                            'url' => array('/admin/sistemSilvikultur/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'sistemSilvikultur') ? true : false
                        ),
                        array(
                            'label' => 'Prasyarat',
                            'url' => array('/admin/rkuPrasyarat/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rkuPrasyarat') ? true : false
                        ),
                        array(
                            'label' => 'Kelestarian Fungsi Produksi',
                            'url' => array('/admin/rkuProduksi/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rkuProduksi') ? true : false
                        ),
                        array(
                            'label' => 'Kelestarian Fungsi Lingkungan',
                            'url' => array('/admin/rkuLingkungan/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rkuLingkungan') ? true : false
                        ),
                        array(
                            'label' => 'Kelestarian Fungsi Sosial',
                            'url' => array('/admin/rkuSosial/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rkuSosial') ? true : false
                        )
                    )
                )
            )
        ),
        array(
            'label' => Yii::t('app', 'Rencana Kerja Tahunan (RKT)'),
//            'url' => 'javascript:{}',
            'url' => array('/admin/rkt/' . Yii::app()->request->getQuery('id')),
            'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'Legalitas',
                    'url' => array('/admin/rkt/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'rkt') ? true : false,
                    // 'submenuOptions' => array(''),
                    'items' => array(
                        array(
                            'label' => 'Prasyarat',
                            'url' => array('/admin/rktPrasyarat/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rktPrasyarat') ? true : false
                        ),
                        array(
                            'label' => 'Kelestarian Fungsi Produksi',
                            'url' => array('/admin/rktProduksi/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rktProduksi') ? true : false
                        ),
                        array(
                            'label' => 'Kelestarian Fungsi Lingkungan',
                            'url' => array('/admin/rktLingkungan/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rktLingkungan') ? true : false
                        ),
                        array(
                            'label' => 'Kelestarian Fungsi Sosial',
                            'url' => array('/admin/rktSosial/' . Yii::app()->request->getQuery('id')),
                            'active' => (Yii::app()->controller->id == 'rktSosial') ? true : false
                        ),
                        // array(
                        //     'label' => 'Pemantauan dan Evaluasi',
                        //     'url' => array('/admin/rktEvaluasi/' . Yii::app()->request->getQuery('id')),
                        //     'active' => (Yii::app()->controller->id == 'rktEvaluasi') ? true : false
                        // )
                    )
                )
            )
        ),
        array(
            'label' => Yii::t('app', 'Rekapitulasi RKT'),
 //            'url' => 'javascript:{}',
            'url' => array('/admin/rekapPrasyarat/' . Yii::app()->request->getQuery('id')),
            'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'Prasyarat',
                    'url' => array('/admin/rekapPrasyarat/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'rekapPrasyarat') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Produksi',
                    'url' => array('/admin/rekapProduksi/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'rekapProduksi') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Lingkungan',
                    'url' => array('/admin/rekapLingkungan/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'rekapLingkungan') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Sosial',
                    'url' => array('/admin/rekapSosial/' . Yii::app()->request->getQuery('id')),
                    'active' => (Yii::app()->controller->id == 'rekapSosial') ? true : false
                ),                                
            )
        ), 		                
        array(
            'label' => 'Laporan Kinerja',
            'url' => array('/admin/laporan/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->id == 'laporan') ? true : false
        ),
    ),
));
