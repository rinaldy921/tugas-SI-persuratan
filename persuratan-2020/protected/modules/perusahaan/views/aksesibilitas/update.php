<?php
/* @var $this LaporanKeuanganController */
/* @var $model IuphhkLaporanKeuangan */

$this->breadcrumbs=array(
    'Data',
    'Aksesibilitas'=>array('index'),
);

?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_aksesibilitas.php'; ?>
        </div>
    </div>
</div>

<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Update Investasi</h4>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</div>
