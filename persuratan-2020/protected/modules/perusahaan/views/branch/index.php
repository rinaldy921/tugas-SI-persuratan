<?php
$this->breadcrumbs = array(
    'Perusahaan Cabangs' => array('index'),
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Cabang Perusahaan</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?><?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
//            'id_cabang',
//            'perusahaan_id',
            'nama_cabang',
            'alamat',
            'telepon',
//            'provinsi',
//            'kabupaten',
            /*
              'kode_pos',
              'email',
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