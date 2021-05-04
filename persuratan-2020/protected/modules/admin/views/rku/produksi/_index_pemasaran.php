<?php
$this->beginWidget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'root-kelestarian-pasar',
//        'justified' => true,
    'tabs' => array(
        array(
            'label' => 'Hasil Kayu',
            'content' => $this->renderPartial('produksi/_index_pemasaran_kayu', array('model' => $pasar), true),
            'active' => true
        ),
        array(
            'label' => 'Hasil Non Kayu',
            'content' => $this->renderPartial('produksi/_index_pemasaran_nonkayu', array('model' => $pasarHhbk), true),
        )
    ),
));
$this->endWidget();
?>