
<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'tataruang',
    'tabs' => array(
        array(
            'label' => 'Kawasan Lindung',
            'content' => $this->renderPartial('prasyarat/index_kawasanlindung', array('model' => $modelKawasan), true),
            'active' => true
        ),
        array(
            'label' => 'Areal Tidak Efektif',
            'content' => $this->renderPartial('prasyarat/index_non_produktif', array('model' => $non_produktif), true),
        ),
        array(
            'label' => 'Areal Efektif',
            'content' => $this->renderPartial('prasyarat/index_areal_produktif', array('model' => $produktif), true),
        )
    )
));
?>
