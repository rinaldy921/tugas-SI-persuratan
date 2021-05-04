<?php
$this->breadcrumbs = array(
    'Master Rencana Ganises' => array('index'),
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
    <h4 class="page-header">Data Master Jenis Ganis</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?><?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'enableSorting' => false,
        'dataProvider' => $model->search(),
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
            array(
                'name' => 'nama_jenis',
                'header' => 'Jenis Ganis'
            ),
            array(
                'name' => 'val1',
                'header' => '< 25.000 Ha',
                'value' => 'isset($data->val1) ? $data->val1 : "-"'
            ),
            array(
                'name' => 'val2',
                'header' => '25.000 s.d < 50.000 Ha',
                'value' => 'isset($data->val2) ? $data->val2 : "-"'
            ),
            array(
                'name' => 'val3',
                'header' => '50.000 s.d < 100.000 Ha',
                'value' => 'isset($data->val3) ? $data->val3 : "-"'
            ),
            array(
                'name' => 'val4',
                'header' => '100.000 s.d < 200.000 Ha',
                'value' => 'isset($data->val4) ? $data->val4 : "-"'
            ),
            array(
                'name' => 'val5',
                'header' => '> 200.000 Ha',
                'value' => 'isset($data->val5) ? $data->val5 : "-"'
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    ));
    ?>
</div>