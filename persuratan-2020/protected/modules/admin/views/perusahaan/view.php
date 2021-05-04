<?php
$this->breadcrumbs=array(
	'Perusahaans'=>array('index'),
	$model->id_perusahaan,
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
    <h4 class="page-header">Data Perusahaan</h4>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_perusahaan',
		'nama_perusahaan',
		'alamat',
		'provinsi',
		'kabupaten',
		'telepon',
		'email',
		'fax',
		'kode_pos',
		'website',
		'kontak',
		'telepon_kontak',
		'email_kontak',
),
)); ?>
</div>