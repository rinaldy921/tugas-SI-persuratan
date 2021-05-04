<?php
/* @var $this MasterDishutprovController */
/* @var $model MasterDishutprov */

$this->breadcrumbs=array(
	'Data',
	'Master Dishutprovs'=>array('index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Migas Nasional'), 'url'=>'javascript: {}'),
	array('label'=>Yii::t('app', 'Harga Minyak Mentah'), 'url'=>array('hargaMinyakMentahIndonesia/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Investasi Sub Sektor Migas'), 'url'=>array('rekapInvestasiSubSektorMigas/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Konsumsi BBM'), 'url'=>array('konsumsiBbm/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Penjualan BBM'), 'url'=>array('rekapPenjualanBbm/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Penjualan LPG'), 'url'=>array('penjualanLpg/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Peta Cadangan Migas'), 'url'=>array('petaCadanganMigas/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Peta Cekungan Sedimen'), 'url'=>array('petaCekungan/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Produksi Migas Indonesia'), 'url'=>array('rekapProduksiMigasIndonesia/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Explorasi dan Produksi'), 'url'=>'javascript: {}'),
	array('label'=>Yii::t('app', 'Survei Seismik 2D'), 'url'=>array('surveiSeismik2d/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Survei Seismik 3D'), 'url'=>array('surveiSeismik3d/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Pemboran Sumur Eksplorasi'), 'url'=>array('pemboranSumurEksplorasi/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Produksi dan Pemanfaatan Gas Bumi'), 'url'=>array('pengolahanNaturalGas/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Produksi Minyak Bumi dan Kondensat'), 'url'=>array('produksiMinyakMentah/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Produksi LNG'), 'url'=>array('produksiLng/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Produksi LPG'), 'url'=>array('produksiLpg/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Pengolahan Minyak Mentah'), 'url'=>'javascript: {}'),
	array('label'=>Yii::t('app', 'Pengolahan Minyak Mentah'), 'url'=>array('pengolahanMinyakMentah/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Hasil Pengolahan Minyak Mentah'), 'url'=>array('hasilPengolahanMinyakMentah/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Ekspor dan Impor'), 'url'=>'javascript: {}'),
	array('label'=>Yii::t('app', 'Ekspor Produk Kilang'), 'url'=>array('eksporImporBbm/ekspor_kilang'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Ekspor LPG'), 'url'=>array('eksporImporLpg/ekspor_lpg'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Ekspor Minyak Mentah dan Kondensat'), 'url'=>array('rekapEksporMinyakMentah/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Ekspor LNG'), 'url'=>array('eksporImporLng/index'), 'itemOptions'=>array('class'=>'indent')),
	array('label'=>Yii::t('app', 'Impor Minyak Mentah'), 'url'=>array('rekapImporMinyakMentah/index'), 'itemOptions'=>array('class'=>'indent')),
);
?>

<h1><?php echo Yii::t('app', 'Manage MasterDishutprov'); ?></h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'master-dishutprov-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nama',
		'keterangan',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
