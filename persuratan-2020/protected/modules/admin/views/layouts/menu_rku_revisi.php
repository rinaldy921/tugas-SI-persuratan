<?php
$rkt = Rkt::model()->find(array('condition'=>'status = 1 AND id_rku = '.Yii::app()->request->getQuery('id')));
if(Yii::app()->controller->action->id == 'indexRevRku' ||
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
                'label' => Yii::t('app', 'Rencana Kerja Umum (RKU)'),
                'url' => 'javascript:{}',
                // 'submenuOptions' => array('style' => 'display:none'),
                'items' => array(
                    array(
                        'label' => 'Sistem Silvikultur',
                        'url' => array('/admin/rku/indexRevRku/id/' . Yii::app()->request->getQuery('id').'/id_rku/'.Yii::app()->request->getQuery('id_rku')),
                        'active' => (Yii::app()->controller->action->id == 'indexRevRku') ? true : false
                    ),
                    array(
                        'label' => 'Prasyarat',
                        'url' => array('/admin/rku/viewPrasyarat/id/' . Yii::app()->request->getQuery('id').'/id_rku/'.Yii::app()->request->getQuery('id_rku')),
                        'active' => (Yii::app()->controller->action->id == 'viewPrasyarat') ? true : false
                    ),
                    array(
                        'label' => 'Kelestarian Fungsi Produksi',
                        'url' => array('/admin/rku/viewProduksi/id/' . Yii::app()->request->getQuery('id').'/id_rku/'.Yii::app()->request->getQuery('id_rku')),
                        'active' => (Yii::app()->controller->action->id == 'viewProduksi') ? true : false
                    ),
                     array(
                        'label' => 'Kelestarian Fungsi Lingkungan',
                        'url' => array('/admin/rku/viewLingkungan/id/' . Yii::app()->request->getQuery('id').'/id_rku/'.Yii::app()->request->getQuery('id_rku')),
                        'active' => (Yii::app()->controller->action->id == 'viewLingkungan') ? true : false
                     ),
                     array(
                         'label' => 'Kelestarian Fungsi Sosial',
                         'url' => array('/admin/rku/viewSosial/id/' . Yii::app()->request->getQuery('id').'/id_rku/'.Yii::app()->request->getQuery('id_rku')),
                        'active' => (Yii::app()->controller->action->id == 'viewSosial') ? true : false
                     )
                )
            ),
            // array(
            // )
            array(
                'label' => Yii::t('app', 'Rencana Kerja Tahunan (RKT)'),
                'url' => array('/admin/rku/rktIndex/id/' . Yii::app()->request->getQuery('id').'/id_rku/'.Yii::app()->request->getQuery('id_rku')),
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
                'url' => array('/admin/rku/indexRevRku/id/' . Yii::app()->request->getQuery('id').'/id_rku/'.Yii::app()->request->getQuery('id_rku')),
            ),
            array(
                'label' => Yii::t('app', 'Rencana Kerja Tahunan (RKT)'),
                'url' => 'javascript:{}',
                // 'submenuOptions' => array('style' => 'display:none'),
                'items' => array(
                    array(
                        'label' => 'Data Umum',
                        'url' => array('/admin/rku/rktIndex/id/' . Yii::app()->request->getQuery('id')),
                        'active' => (Yii::app()->controller->action->id == 'rktIndex') ? true : false
                    ),
                    // array(
                    //     'label' => 'Kelestarian Fungsi Produksi',
                    //     'url' => array('/admin/rku/rktProduksiRev/id/' . Yii::app()->request->getQuery('id')),
                    //     'active' => (Yii::app()->controller->action->id == 'rktProduksiRev') ? true : false
                    // ),
                    //  array(
                    //     'label' => 'Kelestarian Fungsi Lingkungan',
                    //     'url' => array('/admin/rku/rktLingkunganRev/id/' . Yii::app()->request->getQuery('id')),
                    //     'active' => (Yii::app()->controller->action->id == 'rktLingkunganRev') ? true : false
                    //  ),
                    //  array(
                    //      'label' => 'Kelestarian Fungsi Sosial',
                    //      'url' => array('/admin/rku/rktSosialRev/id/' . Yii::app()->request->getQuery('id')),
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
                        'url' => array('/admin/rkt/indexRevRkt/id/' . Yii::app()->request->getQuery('id').'/id_rkt/'.Yii::app()->request->getQuery('id_rkt')),
                        'active' => (Yii::app()->controller->action->id == 'detailRkt' || Yii::app()->controller->action->id == 'indexRevRkt' ) ? true : false,
                        'onclick'=>'js:function(){alert("yeah")}'
                    ),
                    array(
                        'label' => 'Kelestarian Fungsi Produksi',
                        'url' => array('/admin/rkt/rktProduksiRev/id/' . Yii::app()->request->getQuery('id').'/id_rkt/'.Yii::app()->request->getQuery('id_rkt')),
                        'active' => (Yii::app()->controller->action->id == 'rktProduksiRev') ? true : false
                    ),
                     array(
                        'label' => 'Kelestarian Fungsi Lingkungan',
                        'url' => array('/admin/rkt/rktLingkunganRev/id/' . Yii::app()->request->getQuery('id').'/id_rkt/'.Yii::app()->request->getQuery('id_rkt')),
                        'active' => (Yii::app()->controller->action->id == 'rktLingkunganRev') ? true : false
                     ),
                     array(
                         'label' => 'Kelestarian Fungsi Sosial',
                         'url' => array('/admin/rkt/rktSosialRev/id/' . Yii::app()->request->getQuery('id').'/id_rkt/'.Yii::app()->request->getQuery('id_rkt')),
                        'active' => (Yii::app()->controller->action->id == 'rktSosialRev') ? true : false
                     )
                )
            
        
    ));
}
?>