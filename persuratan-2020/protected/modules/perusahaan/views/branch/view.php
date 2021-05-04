<?php
$this->breadcrumbs = array(
    'Perusahaan Cabangs' => array('index'),
    $model->id_cabang,
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
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
//            'id_cabang',
            array(
                'name' => 'perusahaan_id',
                'value' => ($model->perusahaan_id) ? $model->perusahaan->nama_perusahaan : '-',
            ),
            'nama_cabang',
            'alamat',
            array(
                'name' => 'provinsi',
                'value' => ($model->provinsi) ? $model->provinsiCabang->nama : '-',
            ),
            array(
                'name' => 'kabupaten',
                'value' => ($model->kabupaten) ? $model->kabupatenCabang->nama : '-',
            ),
            'kode_pos',
            'telepon',
            // 'email',
            // 'website',
            'kontak',
            'telepon_kontak',
            'email_kontak',
        ),
    ));
    ?>
</div>