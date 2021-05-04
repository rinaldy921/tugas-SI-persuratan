<?php
$this->breadcrumbs = array(
    'Rku Sistem Silvikulturs' => array('index'),
    'Manage',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data RkuSistemSilvikultur</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary btn-sm')); ?><?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'id',
            'id_rku',
            'id_jenis_silvikultur',
            'sistem_silvikultur',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
            ),
        ),
    ));
    ?>
</div>