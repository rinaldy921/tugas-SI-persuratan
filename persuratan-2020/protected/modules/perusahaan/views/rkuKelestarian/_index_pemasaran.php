<?php
$this->beginWidget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'root-kelestarian-pasar',
//        'justified' => true,
    'tabs' => array(
        array(
            'label' => 'Hasil Kayu',
            'content' => $this->renderPartial('_index_pemasaran_kayu', array('model' => $pasar, 'rku' => $rku), true),
            'active' => true
        ),
        array(
            'label' => 'Hasil Non Kayu',
            'content' => $this->renderPartial('_index_pemasaran_nonkayu', array('model' => $pasarhhbk,'rku'=>$rku), true),
        )
    ),
));
$this->endWidget();
?>
