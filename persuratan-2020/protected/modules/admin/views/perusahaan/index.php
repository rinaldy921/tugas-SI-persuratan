<?php
$this->breadcrumbs = array(
    'Perusahaans' => array('index'),
    'Manage',
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
    <h4 class="page-header">Data Perusahaan</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?><?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
//            'id_perusahaan',
            'nama_perusahaan',
            'npwp',
            'alamat',
//            'provinsi',
//            'kabupaten',
            'telepon',
            'email',
            /*
              'fax',
              'kode_pos',
              'website',
              'kontak',
              'telepon_kontak',
              'email_kontak',
             */
            array(
                'class' => 'booster.widgets.TbButtonColumn',
            ),
        ),
    ));
    ?>
</div>