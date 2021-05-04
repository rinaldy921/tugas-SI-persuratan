<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'bina',
    'tabs' => array(
        array(
            'label' => 'Pembangunan Penyaluran Infrastruktur Pemukiman',
            'content' => $this->renderPartial('_index_inframukim', array('model' => $modelInfraMukim), true),
            'active' => true
        ),
        array(
            'label' => 'Peningkatan SDM',
            'content' => $this->renderPartial('_index_sdm', array('model' => $modelSdm), true),
        ),
    )
));
?>
