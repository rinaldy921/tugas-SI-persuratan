<?php
$this->breadcrumbs=array(
	'Data Spasial RKU'=>array('index'),
	'Manage',
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
            <?php require_once dirname(__FILE__) . '/../layouts/data_perusahaan_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Spasial RKU</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary'));?><?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'template' => '{items}{summary}{pager}',
'columns'=>array(
		'id',
		'id_rku',
		'id_perusahaan',
		'file_name',
		'file_path',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
</div>