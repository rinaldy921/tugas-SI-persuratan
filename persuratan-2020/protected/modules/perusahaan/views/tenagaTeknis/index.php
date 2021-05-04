<?php
$this->breadcrumbs = array(
    'Sertifikasi PHPL'
);
?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Tenaga Kerja Ganis PHPL</h4>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-sertifikasi-ganis',
        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Daftar Ganis PHPL',
                'content' => $this->renderPartial('daftar_ganis', array('daftarGanis' => $daftarGanis), true),
                'active' => true
            ),  
            array(
                'label' => 'Ketersediaan Ganis Sesuai Persyaratan',
                'content' => $this->renderPartial('aktif_ganis', array('syaratGanis' => $syaratGanis), true),
            ),   
        ),
    ));
    $this->endWidget();
    ?>
</div>
