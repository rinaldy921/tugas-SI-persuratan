<?php
/* @var $this PesanController */
/* @var $model Pesan */

$this->breadcrumbs=array(
	'Data',
	'Pesan'=>array('index'),
);

?>
<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Detil Pesan</h4>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subyek',
		'perusahaan_id',
		'isi',
		'status',
		'tgl_kirim',
		'tipe',
	),
)); ?>
</div>