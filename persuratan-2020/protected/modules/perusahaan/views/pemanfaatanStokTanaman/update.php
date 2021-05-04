<?php
/* @var $this PemanfaatanStokTanamanController */
/* @var $model PemanfaatanStokTanaman */

$this->breadcrumbs=array(
	'Data',
	'Pemanfaatan Stok Tanamen'=>array('index'),
);

?>


<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_stok_awal.php'; ?>
        </div>
    </div>
</div>

<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header"><?php echo Yii::t('app', 'Edit Pemanfaatan Stok Tanaman'); ?></h4>
    
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>

