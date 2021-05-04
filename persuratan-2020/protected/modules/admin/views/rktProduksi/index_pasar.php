<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'pemasaran',
    'tabs' => array(
        array(
            'label' => 'Pemasaran Hasil Kayu',
            'content' => $this->renderPartial('_index_pasar', array('model' => $modelPasar), true),
            'active' => true
        ),
        array(
            'label' => 'Pemasaran Hasil Non Kayu',
            'content' => $this->renderPartial('_index_pasar_hhbk', array('model' => $modelPasarHhbk), true),
        ),
    )
));
?>