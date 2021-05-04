<?php
$this->breadcrumbs=array(
    'Prasyarat'
);
$rku = Rku::model()->find('id_rku = '.$model->id_rku);
?>
<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary" href="#" onclick="parent.jQuery.fancybox.close()">Tutup</a>
    <h4 class="text-center">Data RKT (Berdasarkan Revisi RKU)</h4>
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
    <h4 class="page-header">Kelestarian Fungsi Produksi</h4>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'bibits',
        'tabs' => array(
            array(
                'label' => 'Pengadaan Bibit',
                'content' => $this->renderPartial('rktProduksi/_index_bibit', array('model' => $modelBibit), true),
                'active' => true
            ),
            array(
                'label' => 'Penyiapan Lahan',
                'content' => $this->renderPartial(empty($sektor) ? 'rktProduksi/_index_siaplahan' : 'rktProduksi/_index_siaplahan_sektor', array('model' => $modelSiapLahan), true),
            ),
            array(
                'label' => 'Penanaman',
                'content' => $this->renderPartial(empty($sektor) ? 'rktProduksi/_index_tanam' : 'rktProduksi/_index_tanam_sektor', array('model' => $modelTanam), true),
            ),
            array(
                'label' => 'Pemeliharaan',
                'content' => $this->renderPartial('rktProduksi/index_pemeliharaan', array('model_sulam' => $modelSulam, 'model_jarang' => $modelJarang, 'model_dangir' => $modelDangir), true),
            ),
            array(
                'label' => 'Pemanenan',
                'content' => $this->renderPartial('rktProduksi/index_panen', array('modelPanenAreal' => $modelPanenAreal, 'modelPanenTanaman' => $modelPanenTanaman, 'modelPanenSiapLahan' => $modelPanenSiapLahan), true),
            ),
            array(
                'label' => 'Pemasaran',
                'content' => $this->renderPartial('rktProduksi/_index_pasar', array('model' => $modelPasar), true),
            ),
        )
    ));
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rkt_tahun_mulai').datepicker({
    'format':'yyyy',
    'startView':'decade',
    'minViewMode':2,
    'autoclose':true,
    'language':'id',
    beforeShowYear: function (date){
        if (date.getFullYear() < ".$rku->tahun_mulai.") {
            return false;
        }
        if(date.getFullYear() > ".$rku->tahun_sampai.") {
            return false;
        }
    }
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);
