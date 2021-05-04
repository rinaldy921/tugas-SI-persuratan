<?php
$this->breadcrumbs=array(
    'Prasyarat'=>array('index'),
    'Manage',
);
$rku = Rku::model()->find('id_rku = '.$model->id_rku);
?>
<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/perusahaan/rkt') ?>">&laquo; Kembali</a>
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
            <?php require_once dirname(__FILE__) . '/../../layouts/menu_rkt_revisi.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-10">
    <h4 class="page-header">Kelestarian Fungsi Sosial</h4>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'sosial',
        'tabs' => array(
            array(
                'label' => 'Pembinaan dan Pemberdayaan Masyarakat',
                'content' => $this->renderPartial('rktSosial/index_bina', array('modelInfraMukim' => $modelInfraMukim, 'modelSdm' => $modelSdm), true),
                'active' => true
            ),
            array(
                'label' => 'Pembinaan Kelembagaan Masyarakat',
                'content' => $this->renderPartial('rktSosial/index_binmas', array('modelKerjasama' => $modelKerjasama, 'modelBangunMitra' => $modelBangunMitra), true),
            ),
            array(
                'label' => 'Penanganan Konflik Sosial',
                'content' => $this->renderPartial('rktSosial/_index_konfliksosial', array('modelKonflikSosial' => $modelKonflikSosial), true),
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
