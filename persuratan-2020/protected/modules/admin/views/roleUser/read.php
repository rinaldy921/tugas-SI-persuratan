<?php
/* @var $this RoleUserController */
/* @var $model RoleUser */

$this->breadcrumbs=array(
	'Data',
	'Role Users'=>array('index'),
);

?>

<h1><?php echo Yii::t('app', 'Detail RoleUser'); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nama_role',
		'created_at',
		'modified_at',
	),
)); ?>
