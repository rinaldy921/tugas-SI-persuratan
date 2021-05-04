<?php
$this->breadcrumbs = array(
    'Provinsi'
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
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Kelola Sertifikat PHPL</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary'));?>



<h1><?php echo Yii::t('app', 'Kelola Sertifikat PHPL'); ?></h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sertifikasi-phpl-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		//'id_perusahaan',
                array(
                    'name' => 'Nama Perusahaan',
                    'value' => '($data->id_perusahaan) ? $data->idPerusahaan->nama_perusahaan : "-"',
                ),
		'nomor',
		//'nilai_kinerja',
		'predikat',
		'tanggal_mulai',
		'tanggal_berakhir',
                array(
                       'name' => "Status Verifikasi",
                       'value' => function($data) {
                           if($data->is_verified == 1){
                               return "Terverifikasi";
                           }
                           else if($data->is_verified == 0){
                               return "Belum Terverifikasi";
                           }
                           else{
                               return "Sertifikasi Di Bekukan";
                           }
                       }
                   ), 
		/*
		'penerbit',
		
		'id_penerbit',
		'tanggal',
		'file_doc',
		'is_verified',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>