<?php
$this->breadcrumbs = array(
    'Kabupatens' => array('index'),
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
    <h4 class="page-header">Data Kabupaten</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?><?php
    $prov = CHtml::listData(Provinsi::model()->findAll(array('select' => 'id_provinsi, nama')), 'id_provinsi', 'nama');
    $prov[""] = Yii::t('app', 'Pilih Provinsi...');
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
//        'mergeColumns' => array('provinsi_id'),
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            // 'id_kabupaten',
            array(
                'header' => 'No.',
                'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
            array(
                'name' => 'provinsi_id',
                'filter' => CHtml::dropDownList(get_class($model) . '[provinsi_id]', $model->provinsi_id, $prov, array('class' => 'form-control')),
                'value' => '($data->provinsi_id) ? $data->kabupatenProvinsi->nama : "-"',
            ),
            'nama',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    ));
    ?>
</div>