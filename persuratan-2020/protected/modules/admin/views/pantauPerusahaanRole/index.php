<?php
$this->breadcrumbs=array(
	'Beranda'=>array('index'),
	'Wilayah Monitoring Perusahaan',
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
    <h4 class="page-header">Wilayah Monitoring Perusahaan</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Menu Baru'), array('create'), array('class' => 'btn btn-primary'));?>
        <?php $this->widget('booster.widgets.TbGridView',array(
            'id'=>Yii::app()->controller->id . '-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template' => '{items}{summary}{pager}',
            'columns'=>array(
                             'id',
                             array(
                                'header' => 'Role User',
                                'name'  => 'role_id',
                                'value' => '$data->idRole->nama_role',
                             ),
                            array(
                                'header' => 'Objek Monitor',
                                'name'  => 'id_perusahaan',
                                'value' => '$data->idPerusahaan->nama_perusahaan',
                             ),
                           // '$data->idRole->nama_role',
                           // '$data->idPerusahaan->nama_perusahaan',
                            'keterangan',

            array(
                'class'=>'booster.widgets.TbButtonColumn',
                                ),
                                ),
            )); 
        ?>
</div>