<?php
$this->breadcrumbs=array(
	'Rkt Evaluasi Pantau Operasionals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Form Update RktEvaluasiPantauOperasional</h4>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>