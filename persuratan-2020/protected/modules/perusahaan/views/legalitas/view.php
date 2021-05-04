<?php
$this->breadcrumbs=array(
	'Legalitas Perusahaans'=>array('index'),
	$model->id_legalitas,
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
            <?php require_once dirname(__FILE__) . '/../layouts/data_perusahaan_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data LegalitasPerusahaan</h4>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_legalitas',
		'perusahaan_id',
		'jenis_legalitas',
		'notaris',
		'nomor',
		'tanggal',
		'perubahan_ke',
),
)); ?>
</div>