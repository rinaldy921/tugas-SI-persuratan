<?php
$this->breadcrumbs=array(
	'Master Bphp'=>array('index'),
	$model->id,
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
    <h4 class="page-header">Data Master Bphp</h4>
	<?php $this->widget('booster.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nama_bphp',
			'keterangan',
		),
	)); ?>
	<hr>
	<legend>Detail Propinsi</legend>
	<?php $this->widget('booster.widgets.TbGridView',array(
		'id'=>Yii::app()->controller->id . '-grid',
		'type' => 'bordered condensed striped',
		'responsiveTable' => true,
		'dataProvider'=>$wilayah->search(),
		'template' => '{items}{summary}{pager}',
		'columns'=>array(
			'id',
			array(
				'header'=>'Provinsi',
				'name'=>'id_provinsi',
				'value'=>'$data->idProvinsi->nama'
			)
		),
	)); ?>
</div>