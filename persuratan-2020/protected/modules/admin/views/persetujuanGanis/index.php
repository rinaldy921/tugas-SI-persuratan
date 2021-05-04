<?php
$this->breadcrumbs = array(
    'Persetujuan Ganis'
);
?>

<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Kelola Sertifikasi Ganis PHPL</h4>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-persetujuan-ganis',
        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Daftar Usulan Ganis',
                'content' => $this->renderPartial('tab-usulanGanis', array('usulanGanis' => $usulanGanis), true),
                'active' => true
            ),  
            array(
                'label' => 'Daftar Ganis Disetujui',
                'content' => $this->renderPartial('tab-ganisSetuju', array('ganisSetuju' => $ganisSetuju), true),
            ),  
            array(
                'label' => 'Daftar Ganis Ditolak',
                'content' => $this->renderPartial('tab-ganisTolak', array('ganisTolak' => $ganisTolak), true),
            ), 
        ),
    ));
    $this->endWidget();
    ?>
</div>

