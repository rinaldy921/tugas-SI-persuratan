<?php
$this->breadcrumbs = array(
    'Kelestarian Fungsi Produksi'
);
?>

<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Kelola Sertifikasi Ganis PHPL</h4>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'rootwizard',
        'tabs' => array(
            array(
                'label' => 'Daftar Ganis Sudah Di Setujui',
                'content' => $this->renderPartial('kelolaSertifikat/toApprove', array('model' => $toUnApprove), true),
                'active' => true
            ),
            array(
                'label' => 'Daftar Ganis Belum Di Setujui',
                'content' => $this->renderPartial('kelolaSertifikat/toUnApprove', array('model' => $toApprove), true),
            ),            
        ),
    ));
//    $this->endWidget();
    ?>
</div>

