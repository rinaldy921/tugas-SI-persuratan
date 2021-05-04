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
    <h4 class="page-header">Prasyarat</h4>
    <?php 
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'rootwizard',
        'tabs' => array(
            array(
                'label' => 'Organisasi & Tenaga Kerja',
                'content' => $this->renderPartial('test/index_ganis', array('model' => $ganis), true),
                'active' => true
            ),
            array(
                'label' => 'Penataan Batas Blok',
                'content' => $this->renderPartial('test/index_tatabatas', array('model' => $tatabatas), true),
            ),
            array(
                'label' => 'Penataan Ruang',
                'content' => $this->renderPartial('test/index_tataruang', array(
                    'bloksektor'=>$bloksektor, 
                    'model_kawasan_lindung' => $tataruang, 
                    'idRkt'=>$idRkt,
                    'model_areal_produktif'=>$arealProduktif, 
                    'model_areal_non_produktif'=>$arealNonProduktif,
                ), 
                true),
            ),
            array(
                'label' => 'Penataan Areal Kerja',
                'content' => $this->renderPartial('test/_index_areal_kerja', array('model' => $arealKerja), true),
            ),
            array(
                'label' => 'Pembukaan Wilayah Hutan',
                'content' => $this->renderPartial('test/_index_pwh', array('model' => $pwh), true),
            ),
            array(
                'label' => 'Pemasukan dan Penggunaan Peralatan',
                'content' => $this->renderPartial('test/_index_masukgunaalat', array('model' => $masukGunaAlat), true),
            ),
            array(
                'label' => 'Pembangunan Sarana Prasarana',
                'content' => $this->renderPartial('test/_index_bangunsarpras', array('model' => $bangunSarpras), true),
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
    $(\"#".Yii::app()->controller->id."-filtertahun-form\").submit();
});
", CClientScript::POS_END);