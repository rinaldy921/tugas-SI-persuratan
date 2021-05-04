<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'pemeliharaan',
    'tabs' => array(
        array(
            'label' => 'Penyulaman',
            'content' => $this->renderPartial('_index_sulam', array('model' => $model_sulam), true),
            'active' => true
        ),
        array(
            'label' => 'Penjarangan',
            'content' => $this->renderPartial('_index_jarang', array('model' => $model_jarang), true),
        ),
        array(
            'label' => 'Pendangiran',
            'content' => $this->renderPartial('_index_dangir', array('model' => $model_dangir), true),
        ),
    )
));
?>