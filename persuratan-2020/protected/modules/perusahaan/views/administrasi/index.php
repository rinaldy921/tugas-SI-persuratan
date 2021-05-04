<?php
$this->breadcrumbs = array(
    'Administrasi'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Administrasi</h4>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-administasi',
        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Pemerintahan',
                'content' => $this->renderPartial('tab-pemerintahan', array('pemerintahan' => $pemerintahan), true),
                'active' => true
            ),
            array(
                'label' => 'Pemangkuan Hutan',
                'content' => $this->renderPartial('tab-pemangkuan', array('pemangkuan' => $pemangkuan), true),
            ),
        ),
    ));
    $this->endWidget();
    ?>
</div>