<?php
/* @var $this SertifikasiVlkController */
/* @var $model SertifikasiVlk */

$this->breadcrumbs=array(
	'',
	'Sertifikasi VLK'=>array('index'),
);

?>

<h1><?php echo Yii::t('app', 'Tambah Sertifikat VLK'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>