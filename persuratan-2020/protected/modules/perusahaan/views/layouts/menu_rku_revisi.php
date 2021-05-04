<?php
$rkt = Rkt::model()->find(array('condition'=>'status = 1 AND id_rku = '.Yii::app()->request->getQuery('id')));
if(Yii::app()->controller->action->id == 'indexRev' ||
    Yii::app()->controller->action->id == 'viewPrasyarat' ||
    Yii::app()->controller->action->id == 'viewProduksi' ||
    Yii::app()->controller->action->id == 'viewLingkungan' ||
    Yii::app()->controller->action->id == 'viewSosial'){
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
                'label' => Yii::t('app', 'Rencana Kerja Umum (RKU)'),
                'url' => 'javascript:{}',
                // 'submenuOptions' => array('style' => 'display:none'),
                'items' => array(
                    array(
                        'label' => 'Sistem Silvikultur',
                        'url' => array('/perusahaan/rku/indexRev/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'indexRev') ? true : false
                    ),
                    array(
                        'label' => 'Prasyarat',
                        'url' => array('/perusahaan/rku/viewPrasyarat/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'viewPrasyarat') ? true : false
                    ),
                    array(
                        'label' => 'Kelestarian Fungsi Produksi',
                        'url' => array('/perusahaan/rku/viewProduksi/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'viewProduksi') ? true : false
                    ),
                     array(
                        'label' => 'Kelestarian Fungsi Lingkungan',
                        'url' => array('/perusahaan/rku/viewLingkungan/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'viewLingkungan') ? true : false
                     ),
                     array(
                         'label' => 'Kelestarian Fungsi Sosial',
                         'url' => array('/perusahaan/rku/viewSosial/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'viewSosial') ? true : false
                     )
                )
            ),
            // array(
            // )
            array(
                'label' => Yii::t('app', 'Rencana Kerja Tahunan (RKT)'),
                'url' => array('/perusahaan/rku/rktIndex/id/'.Yii::app()->request->getQuery('id')),
            )
        ),
    ));
} elseif(Yii::app()->controller->action->id == 'rktIndex') {
    $this->widget('zii.widgets.CMenu', array(
        'encodeLabel' => FALSE,
        'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
        'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
        'items' => array(
            array(
                'label' => Yii::t('app', 'Rencana Kerja Umum (RKU)'),
                'url' => array('/perusahaan/rku/indexRev/id/'.Yii::app()->request->getQuery('id')),
            ),
            array(
                'label' => Yii::t('app', 'Rencana Kerja Tahunan (RKT)'),
                'url' => 'javascript:{}',
                // 'submenuOptions' => array('style' => 'display:none'),
                'items' => array(
                    array(
                        'label' => 'Data Umum',
                        'url' => array('/perusahaan/rku/rktIndex/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'rktIndex') ? true : false
                    ),
                    // array(
                    //     'label' => 'Kelestarian Fungsi Produksi',
                    //     'url' => array('/perusahaan/rku/rktProduksiRev/id/' . Yii::app()->request->getQuery('id')),
                    //     'active' => (Yii::app()->controller->action->id == 'rktProduksiRev') ? true : false
                    // ),
                    //  array(
                    //     'label' => 'Kelestarian Fungsi Lingkungan',
                    //     'url' => array('/perusahaan/rku/rktLingkunganRev/id/' . Yii::app()->request->getQuery('id')),
                    //     'active' => (Yii::app()->controller->action->id == 'rktLingkunganRev') ? true : false
                    //  ),
                    //  array(
                    //      'label' => 'Kelestarian Fungsi Sosial',
                    //      'url' => array('/perusahaan/rku/rktSosialRev/id/' . Yii::app()->request->getQuery('id')),
                    //     'active' => (Yii::app()->controller->action->id == 'rktSosialRev') ? true : false
                    //  )
                )
            ),
        ),
    ));
} else {
    $this->widget('zii.widgets.CMenu', array(
        'encodeLabel' => FALSE,
        'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
        'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
                'items' => array(
                    array(
                        'label' => 'Prasyarat',
                        'url' => array('/perusahaan/rku/rktIndexRev/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'detailRkt' || Yii::app()->controller->action->id == 'rktIndexRev' ) ? true : false,
                        'onclick'=>'js:function(){alert("yeah")}'
                    ),
                    array(
                        'label' => 'Kelestarian Fungsi Produksi',
                        'url' => array('/perusahaan/rku/rktProduksiRev/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'rktProduksiRev') ? true : false
                    ),
                     array(
                        'label' => 'Kelestarian Fungsi Lingkungan',
                        'url' => array('/perusahaan/rku/rktLingkunganRev/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'rktLingkunganRev') ? true : false
                     ),
                     array(
                         'label' => 'Kelestarian Fungsi Sosial',
                         'url' => array('/perusahaan/rku/rktSosialRev/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'rktSosialRev') ? true : false
                     )
                )
            
        
    ));
}
?>