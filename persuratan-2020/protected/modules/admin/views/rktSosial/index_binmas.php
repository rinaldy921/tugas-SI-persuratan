<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'binmas',
    'tabs' => array(
        array(
            'label' => 'Kerjasama Koperasi',
            'content' => $this->renderPartial('_index_kerjasama', array('model' => $modelKerjasama), true),
            'active' => true
        ),
        array(
            'label' => 'Kemitraan Usaha',
            'content' => $this->renderPartial('_index_bangunmitra', array('model' => $modelBangunMitra), true),
        ),
    )
));
?>
