<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Dashboard',
);
$iup = Iuphhk::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
?>
<h1>Selamat Datang  </h1>
<?php if(empty($iup)) : ?>
	<p>Untuk memulai, silahkan lengkapi data IUPHHK terlebih dahulu atau <a href="<?php echo Yii::app()->createUrl('//perusahaan/iuphhk');?>">Klik disini</a>.</p>
<?php endif; ?>
