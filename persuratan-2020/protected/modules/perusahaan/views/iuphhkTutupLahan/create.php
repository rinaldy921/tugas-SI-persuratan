<?php
$this->breadcrumbs = array(
    'Penutupan Lahan' => array('index'),
    'Create',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data IuphhkTutupLahan</h4>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?></div>
