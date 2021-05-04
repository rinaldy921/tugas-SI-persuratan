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
            'url' => array('/perusahaan/rku/index'),
            'active' => (Yii::app()->controller->id == 'rku') ? true : false
        ),
        // array(
        // )
        array(
            'label' => Yii::t('app', 'Rencana Kerja Tahunan (RKT)'),
            'url' => 'javascript:{}',
            // 'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'Legalitas',
                    'url' => array('/perusahaan/rkt'),
                    'active' => (Yii::app()->controller->id == 'rkt') ? true : false,                    
                    ),
                array(
                    'label' => 'Prasyarat',
                    'url' => array('/perusahaan/rktGanis'),
                    'active' => (Yii::app()->controller->id == 'rktGanis') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Produksi',
                    'url' => array('/perusahaan/rktBibit'),
                    'active' => (Yii::app()->controller->id == 'rktBibit') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Lingkungan',
                    'url' => array('/perusahaan/rktLingkunganDungtan'),
                    'active' => (Yii::app()->controller->id == 'rktLingkunganDungtan') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Sosial',
                    'url' => array('/perusahaan/rktInfraMukim'),
                    'active' => (Yii::app()->controller->id == 'rktInfraMukim') ? true : false
                ),                
                    // 'submenuOptions' => array(''),
                    /*'items' => array(
                        // array(
                        //     'label' => 'Pemantauan dan Evaluasi',
                        //     'url' => array('/perusahaan/rktEvaluasiPantauOperasional'),
                        //     'active' => (Yii::app()->controller->id == 'rktEvaluasiPantauOperasional') ? true : false
                        // )
                    )
                     * 
                     */
                
            )
        ),
        array(
            'label' => Yii::t('app', 'Realisasi RKT'),
            'url' => array('/perusahaan/realprasyarat'),
        ),
        array(
            'label' => 'Rekapitulasi',
            'url' => array('/perusahaan/rekapPrasyarat/index'),
            'active' => (Yii::app()->controller->id == 'rekapPrasyarat') ? true : false
        ),        
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