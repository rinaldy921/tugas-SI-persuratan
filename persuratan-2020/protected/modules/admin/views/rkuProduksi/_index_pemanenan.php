<?php
$this->beginWidget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'root-kelestarian-panen',
//        'justified' => true,
    'tabs' => array(
        array(
            'label' => 'Hasil Kayu',
            'content' => $this->renderPartial('_index_pemanenan_kayu', array('model' => $panen), true),
            'active' => true
        ),
        array(
            'label' => 'Hasil Non Kayu',
            'content' => $this->renderPartial('_index_pemanenan_nonkayu', array('model' => $hhbk), true),
        )
    ),
));
$this->endWidget();
?>
