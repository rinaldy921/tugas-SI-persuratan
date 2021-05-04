<?php
$this->breadcrumbs = array(
    'RKU'=>array('index'),
    'View Revisi'
);
?>
<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/perusahaan/rku') ?>">&laquo; Kembali</a>
    <h4 class="text-center">Data RKU Pra-Revisi</h4>
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
                    <td><?= $this->getDateMonth($model->tgl_sk) ?></td>
                    <th>Telepon</th>
                    <td><?= $model->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Periode Tahun RKU</th>
                    <td><?= $model->tahun_mulai.' - '.$model->tahun_sampai ?></td>
                    <th>Alamat</th>
                    <td><?= $model->idPerusahaan->alamat ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../../layouts/menu_rku_revisi.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Kelestarian Fungsi Produksi</h4>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-kelestarian',
        'tabs' => array(
            array(
                'label' => 'Pengadaan Bibit',
                'content' => $this->renderPartial('produksi/_index_bibit', array('model' => $modelBibit), true),
                'active' => true
            ),
            array(
                'label' => 'Penyiapan Lahan',
                'content' => $this->renderPartial('produksi/_index_siap_lahan', array('model' => $siapLahan), true),
            ),
            array(
                'label' => 'Penanaman',
                'content' => $this->renderPartial('produksi/_index_penanaman', array('model' => $penanaman), true),
            ),
            array(
                'label' => 'Pemeliharaan',
                'content' => $this->renderPartial('produksi/_index_pemeliharaan', array('model' => $pemeliharaan), true),
            ),
            array(
                'label' => 'Pemanenan',
                'content' => $this->renderPartial('produksi/_index_pemanenan', array(
                    'panen' => $panen, 
                    'hhbk' => $hhbk, 
                ), 
                true),
            ),
            array(
                'label' => 'Pemasaran',
                'content' => $this->renderPartial('produksi/_index_pemasaran', array(
                    'pasar' => $pasar,
                    'pasarHhbk' =>$pasarHhbk,                        
                ), 
                true),
            )
        ),
    ));
    $this->endWidget();
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rku_periode').datepicker({
    format: { /* Say our UI should display a week ahead, but textbox should store the actual date. This is useful if we need UI to select local dates, but store in UTC */ 
        toDisplay: function (date, format, language) { 
            var d = new Date(date); 
            d = d.getFullYear() + ' - '+ (d.getFullYear() + 9); 
            return d;
        }, 
        toValue: function (date, format, language) { 
            var d = new Date(date); 
            d.setDate(d.getDate() + 7); 
            return new Date(d); 
        }
    },
    'startView':'decade',
    'minViewMode':2,
    'autoclose':true,
    'language':'id'
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);