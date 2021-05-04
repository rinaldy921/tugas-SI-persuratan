<?php
$this->breadcrumbs=array(
	'Tata Batas'=>array('index'),
	'Create',
);

?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Create Tata Batas</h4>
    <?php echo $this->renderPartial('_form_tata_batas', array('model'=>$model)); ?></div>
