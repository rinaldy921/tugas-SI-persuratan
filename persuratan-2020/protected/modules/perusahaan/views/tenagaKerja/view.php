<?php
$this->breadcrumbs = array(
    'Tenaga Kerja'
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
            <?php require_once dirname(__FILE__) . '/../layouts/data_perusahaan_menu.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Tenaga Kerja Teknis 
        <?php
        if (empty($teknis)) {
            echo CHtml::link(" <i class='fa fa-pencil-square-o'></i>", array('createTeknis'), array('title' => 'Isi Data'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> ", $this->createUrl('update', array('id' => $teknis->id)), array('title' => 'Ubah Data'));
        }
        ?>
    </h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $teknis,
        'attributes' => array(
//            'kategori',
            'sarjana',
            'menengah',
            'asing',
            'bersertifikat',
        ),
    ));
    ?>
    <br><br>
    <h4 class="page-header">Data Tenaga Kerja Non Teknis 
        <?php
        if (empty($non_teknis)) {
            echo CHtml::link(" <i class='fa fa-pencil-square-o'></i>", array('createNonTeknis'), array('title' => 'Isi Data'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> ", $this->createUrl('update', array('id' => $non_teknis->id)), array('title' => 'Ubah Data'));
        }
        ?>
    </h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $non_teknis,
        'attributes' => array(
//            'kategori',
            'sarjana',
            'menengah',
            'asing',
            'bersertifikat',
        ),
    ));
    ?>
</div>