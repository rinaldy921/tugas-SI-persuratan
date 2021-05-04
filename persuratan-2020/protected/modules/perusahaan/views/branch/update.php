<?php
$this->breadcrumbs=array(
	'Perusahaan Cabangs'=>array('index'),
	$model->id_cabang=>array('view','id'=>$model->id_cabang),
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Form Update PerusahaanCabang</h4>
    <?php echo $this->renderPartial('_form',array('model'=>$model,'data'=>$data)); ?>
</div>