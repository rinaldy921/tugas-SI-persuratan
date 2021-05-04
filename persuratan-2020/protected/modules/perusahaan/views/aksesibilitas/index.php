<?php
$this->breadcrumbs = array(
    'Aksesibilitas',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_aksesibilitas.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Aksesibilitas</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Rute'), array('create'), array('class' => 'btn btn-primary')); ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        // 'filter' => $model,
        'enableSorting'=>false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'rute',
            'keterangan',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    ));
    ?>
</div>
