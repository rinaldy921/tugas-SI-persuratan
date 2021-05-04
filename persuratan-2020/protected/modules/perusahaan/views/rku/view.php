<?php
$this->breadcrumbs = array(
    'RKU' => array('index'),
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <?php
        if(isset($bloksektor)) {
            echo '<h4 class="page-header">Input Blok Sektor</h4>';
        } else {
            echo '<h4 class="page-header">Data RKU</h4>';
        }
    ?>

    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
//            'id_rku',
//            'id_perusahaan',
            'nomor_sk',
            'tgl_sk',
            'tahun_mulai',
            'tahun_sampai',
        ),
    ));
    ?>
</div>
