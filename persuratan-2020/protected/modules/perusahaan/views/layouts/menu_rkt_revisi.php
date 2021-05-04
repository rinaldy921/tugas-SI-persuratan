<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id' => 'side-menu', 'class' => 'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Prasyarat',
            'url' => array('/perusahaan/rkt/indexRev/id/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->action->id == 'indexRev') ? true : false
        ),
        array(
            'label' => 'Kelestarian Fungsi Produksi',
            'url' => array('/perusahaan/rkt/revProduksi/id/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->action->id == 'revProduksi') ? true : false
        ),
        array(
            'label' => 'Kelestarian Fungsi Lingkungan',
            'url' => array('/perusahaan/rkt/revLingkungan/id/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->action->id == 'revLingkungan') ? true : false
        ),
        array(
            'label' => 'Kelestarian Fungsi Sosial',
            'url' => array('/perusahaan/rkt/revSosial/id/' . Yii::app()->request->getQuery('id')),
            'active' => (Yii::app()->controller->action->id == 'revSosial') ? true : false
        ),
        // array(
        //     'label' => 'Pemantauan dan Evaluasi',
        //     'url' => array('/admin/rktEvaluasi/' . Yii::app()->request->getQuery('id')),
        //     'active' => (Yii::app()->controller->id == 'rktEvaluasi') ? true : false
        // )
    ),
));
