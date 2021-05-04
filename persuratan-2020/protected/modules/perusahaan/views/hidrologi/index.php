<?php
$this->breadcrumbs = array(
    'Hidrologi'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Hidrologi</h4>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-hidrologi',
        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Sungai',
                'content' => $this->renderPartial('tab-sungai', array('sungai' => $sungai), true),
                'active' => true
            ),
            array(
                'label' => 'Anak Sungai',
                'content' => $this->renderPartial('tab-mata_air', array('mataAir' => $mataAir), true),
            ),
            array(
                'label' => 'Waduk/Dam',
                'content' => $this->renderPartial('tab-waduk', array('waduk' => $waduk), true),
            )
        ),
    ));
    $this->endWidget();
    ?>
</div>