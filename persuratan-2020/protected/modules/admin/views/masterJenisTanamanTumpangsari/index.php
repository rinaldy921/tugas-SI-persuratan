<?php
/* @var $this MasterJenisTanamanTumpangsariController */
/* @var $model MasterJenisTanamanTumpangsari */

$this->breadcrumbs=array(
	'',
	'Master Jenis Tanaman Tumpangsaris'=>array('index'),
);

//print_r("test2");            exit(1);

?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>
        </div>
    </div>
</div>


<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header"><?php echo Yii::t('app', 'Kelola Jenis Tanaman  Tumpangsari'); ?></h4>
    
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah'), array('create'), array('class' => 'btn btn-primary'));?>
    
    
    <?php $this->widget('booster.widgets.TbGridView', array(
            'id'=>Yii::app()->controller->id . 'i-grid',
                'type' => 'bordered condensed striped',
            'dataProvider'=>$model->search(),
//            'filter'=>$model,
            'columns'=>array(
                    'id',
                    'nama',
                    array(
                            'class'=>'CButtonColumn',
                    ),
            ),
    )); ?>
</div>
