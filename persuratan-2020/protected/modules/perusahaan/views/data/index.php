<?php
$this->breadcrumbs = array(
    'Profil Perusahaan'
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
    <h4 class="page-header">Data Umum Perusahaan</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
//            'id_perusahaan',
            'nama_perusahaan',
            'npwp',
            'alamat',
            array(
                'name' => 'provinsi',
                'value' => ($model->provinsi) ? $model->provinsiFk->nama : '-',
            ),
            array(
                'name' => 'kabupaten',
                'value' => ($model->kabupaten) ? $model->kabupatenFk->nama : '-',
            ),
            'kode_pos',
            'telepon',
            'email',
            'fax',
            'website',
            'kontak',
            'telepon_kontak',
            'email_kontak',
        ),
    ));
    ?>
    <br>
    <?php echo CHtml::link("<i class='fa fa-pencil-square-o'></i> Edit", array('update'), array('class' => 'btn btn-primary btn-sm')); ?>
</div>