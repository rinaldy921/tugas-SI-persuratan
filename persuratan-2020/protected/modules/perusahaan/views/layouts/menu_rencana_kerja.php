<?php

$rkuId;
if(isset(Yii::app()->session['rku_id'])){
    $rkuId= $rkuId.' '.Yii::app()->session['rku_id'];
}
else{
    $rkuId="";
}


$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Stok Awal Tanaman',
            'url' => array('/perusahaan/stoktanaman'),
            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        array(
            'label' => Yii::t('app', 'Rencana Kerja Umum (RKU)'),
            'url' => array('/perusahaan/rku'),
            'items' =>array(
                        array(
                            'label' => 'Data Umum',
                            'url' => array('/perusahaan/rku/bloksektor/id/'.$rkuId),
                            'active' => (Yii::app()->controller->id == 'rku') ? true : false,
                        ),
						/**
                         array(
                            'label' => 'Sektor',
                            'url' => array('/perusahaan/rkuSektor'),
                            'active' => (Yii::app()->controller->id == 'rkuSektor') ? true : false
                        ),
                        array(
                            'label' => 'Blok',
                            'url' => array('/perusahaan/rkuBlok'),
                            'active' => (Yii::app()->controller->id == 'rkuBlok') ? true : false
                        ), 
                       **/
                        array(
                            'label' => 'Sistem Silvikultur',
                            'url' => array('/perusahaan/rkuSilvikultur'),
                            'active' => (Yii::app()->controller->id == 'rkuSilvikultur') ? true : false
                        ),
                        array(
                            'label' => 'Prasyarat',
                            'url' => array('/perusahaan/rkuPersyaratan'),
                            'active' => (Yii::app()->controller->id == 'rkuPersyaratan') ? true : false
                        ),
                        array(
                            'label' => 'Kelestarian Fungsi Produksi',
                            'url' => array('/perusahaan/rkuKelestarian'),
                            'active' => (Yii::app()->controller->id == 'rkuKelestarian') ? true : false
                        ),
                         array(
                             'label' => 'Kelestarian Fungsi Lingkungan',
                             'url' => array('/perusahaan/rkuLingkungan'),
                             'active' => (Yii::app()->controller->id == 'rkuLingkungan') ? true : false
                         ),
                         array(
                             'label' => 'Kelestarian Fungsi Sosial',
                             'url' => array('/perusahaan/rkuFungsos'),
                             'active' => (Yii::app()->controller->id == 'rkuFungsos') ? true : false
                         )
                    
                )
            
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
            'url' => array('/perusahaan/rekapPrasyarat/index'),
        )        
    ),
));
?>
<?php
// Yii::app()->clientScript->registerScript("load_nav_script", "
//     $('.nav').find('li.active').parents('li').addClass('active');
//     //$('.navigation').find('li').not('.active').has('ul').children('ul').addClass('hidden-ul');
//     $('.nav').find('li').has('ul').children('a').parent('li').addClass('has-ul');
//     $('.nav').find('li').has('ul').children('a').on('click', function (e) {
//         // alert($('.nav').find('li').has('ul').children('a').attr('href'));
//         if($('.nav').find('li').has('ul').children('a').attr('href') == 'javascript:{}') {
//             // alert('here');
//             e.preventDefault();
//             if ($('body').hasClass('sidebar-narrow')) {
//                 $(this).parent('li > ul li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
//                 $(this).parent('li > ul li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
//             } else {
//                 $(this).parent('li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
//                 $(this).parent('li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
//             }
//         } else {
//             return false;
//         }
//     });
//     $('.nav').find('li.active.has-ul').children('ul').show();
//     $('.nav .disabled a, .navbar-nav > .disabled > a').click(function (e) {
//         e.preventDefault();
//     });
// ");