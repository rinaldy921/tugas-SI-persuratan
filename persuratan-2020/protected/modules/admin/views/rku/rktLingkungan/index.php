<?php
$this->breadcrumbs=array(
    'Prasyarat'=>array('index'),
    'Manage',
);
$rku = Rku::model()->find('id_rku = '.$model->id_rku);
?>
<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary" href="#" onclick="parent.jQuery.fancybox.close()">Tutup</a>
    <h4 class="text-center">Data RKT Revisi</h4>
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $model->nomor_sk ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $model->idPerusahaan->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggal Keputusan</th>
                    <td><?= $this->getDateMonth($model->tanggal_sk) ?></td>
                    <th>Telepon</th>
                    <td><?= $model->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Tahun RKT</th>
                    <td><?= $model->tahun_mulai ?></td>
                    <th>Alamat</th>
                    <td><?= $model->idPerusahaan->alamat ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-2">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../../layouts/menu_rku_revisi.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-10">
    <h4 class="page-header">Kelestarian Fungsi Lingkungan</h4>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'lingkungan',
        'tabs' => array(
            array(
                'label' => 'Perlindungan dan Pengamanan Hutan',
                'content' => $this->renderPartial('rktLingkungan/_index_dungtan', array('model' => $modelDungtan), true),
                'active' => true
            ),
            array(
                'label' => 'Pengendalian Hama dan Penyakit',
                'content' => $this->renderPartial('rktLingkungan/_index_dalmakit', array('model' => $modelDalmakit), true),
            ),
            array(
                'label' => 'Pengendalian Kebakaran',
                'content' => $this->renderPartial('rktLingkungan/_index_dalkar', array('model' => $modelDalkar), true),
            ),
            array(
                'label' => 'Pengelolaan dan Pemantauan Lingkungan',
                'content' => $this->renderPartial('rktLingkungan/_index_pantaulingkungan', array('modelPantau'=>$modelPantau), true),
            ),
        )
    ));
    ?>
</div>