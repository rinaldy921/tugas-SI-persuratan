<?php
$this->breadcrumbs=array(
	'Mjenis Hewans'=>array('index'),
	$model->id_jenis_hewan,
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
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data MJenisHewan</h4>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_jenis_hewan',
		'nama_jenis',
),
)); ?>
</div>