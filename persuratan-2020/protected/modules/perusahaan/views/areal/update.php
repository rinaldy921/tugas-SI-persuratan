<?php
$this->breadcrumbs=array(
	'Topografis'=>array('index'),
	$model->id_topografi=>array('view','id'=>$model->id_topografi),
	'Update',
);


?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/iuphhk_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Form Update Topografi</h4>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>