<?php
/* @var $this MasterJenisTanamanTumpangsariController */
/* @var $model MasterJenisTanamanTumpangsari */

$this->breadcrumbs=array(
	'Data',
	'Master Jenis Tanaman Tumpangsaris'=>array('index'),
);

?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>
        </div>
    </div>
</div>

<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header"><?php echo Yii::t('app', 'Update Pemanfaatan Stok Tanaman'); ?></h4>
    
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>