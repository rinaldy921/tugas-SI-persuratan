<?php
$this->breadcrumbs=array(
	'Iuphhk Data Penduduks'=>array('index'),
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_sosial_ekonomi.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data IuphhkDataPenduduk</h4>
<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'id_iuphhk',
		'anak_laki',
		'anak_perempuan',
		'produktif_laki',
		'produktif_perempuan',
		'lansia_laki',
		'lansia_perempuan',
),
)); ?>
</div>