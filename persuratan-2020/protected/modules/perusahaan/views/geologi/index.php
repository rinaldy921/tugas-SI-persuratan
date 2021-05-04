<?php
$this->breadcrumbs = array(
    'Geologi'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Geologi</h4>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-administasi',
        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Jenis Tanah',
                'content' => $this->renderPartial('tab-tanah', array('tanah' => $tanah), true),
                'active' => true
            ),
            array(
                'label' => 'Jenis Batuan',
                'content' => $this->renderPartial('tab-batuan', array('batuan' => $batuan), true),
            ),
        ),
    ));
    $this->endWidget();
    ?>
</div>