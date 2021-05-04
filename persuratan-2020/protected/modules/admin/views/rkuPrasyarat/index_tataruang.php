
<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'tataruang',
    'tabs' => array(
        array(
            'label' => 'Kawasan Lindung',
            'content' => $this->renderPartial('index_kawasanlindung', array('model' => $modelKawasan), true),
            'active' => true
        ),
        array(
            'label' => 'Areal Tidak Efektif',
            'content' => $this->renderPartial('index_non_produktif', array('model' => $non_produktif), true),
        ),
        array(
            'label' => 'Areal Efektif',
            'content' => $this->renderPartial('index_areal_produktif', array('model' => $produktif), true),
        )
    )
));
?>
