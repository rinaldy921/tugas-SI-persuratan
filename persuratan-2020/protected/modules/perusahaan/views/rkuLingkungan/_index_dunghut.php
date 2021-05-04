<?php

$this->beginWidget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'dung-hut',
    'tabs' => array(
        array(
            'label' => 'Hama dan Penyakit Tanaman',
            'content' => $this->renderPartial('_index_hamkit_', array('model' => $hamkit, 'addHamkit' => $addHamkit), true),
            'active' => true
        ),
        array(
            'label' => 'Teknik Pemadaman Kebakaran Hutan',
            'content' => $this->renderPartial('_index_tekdamkar', array('model' => $tekdam, 'addTekdam' => $addTekdam), true),
        ),
        array(
            'label' => 'Alat Pemadam Kebakaran',
            'content' => $this->renderPartial('_index_damkar', array('model' => $alatDamkar, 'addAlatDamkar' => $addAlatDamkar), true),
        ),
        array(
            'label' => 'Perambahan Hutan, Penggembalaan Liar dan Pembalakan Liar',
            'content' => $this->renderPartial('_index_perambahan', array('model' => $perambahan, 'addPerambahan' => $addPerambahan), true),
        )
    ),
));
$this->endWidget();
?>