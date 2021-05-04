<?php
$this->breadcrumbs=array(
	'Data Master Jenis Peralatan'=>array('index'),
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
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Master Jenis Peralatan</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary'));?><?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'template' => '{items}{summary}{pager}',
'columns'=>array(
		// 'id',
		// 'id_perusahaan',
                array(
                    'header' => 'No.',
                    'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                        * $this->grid->dataProvider->pagination->pageSize) + 1',
                ),		
                'jenis_peralatan',
                array(
                    // 'name' => 'id_perusahaan',
                    'header' => 'Dibuat Oleh',
                    'value' => '($data->id_perusahaan === "0") ? "Admin" : "Pengguna"'
                ),
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
</div>