<?php
$this->breadcrumbs=array(
	'RKU'=>array('index'),
    'View Revisi'
);
?>
<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/perusahaan/rku') ?>">&laquo; Kembali</a>
    <h3 class="text-center">Data RKU Pra-revisi</h3>
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
    <h4 class="page-header">Prasyarat</h4>
    <?php 
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'rootwizard',
        'tabs' => array(
            array(
                'label' => 'Organisasi & Tenaga Kerja',
                'content' => $this->renderPartial('prasyarat/index_ganis', array('model' => $ganis), true),
                'active' => true
            ),
            array(
                'label' => 'Tata Batas',
                'content' => $this->renderPartial('prasyarat/index_tatabatas', array('model' => $tatabatas), true),
            ),
            array(
                'label' => 'Penataan Ruang',
                'content' => $this->renderPartial('prasyarat/index_tataruang', array(
                    'modelKawasan' => $tataruang, 
                    'produktif'=>$arealProduktif, 
                    'non_produktif'=>$arealNonProduktif,
                ), 
                true),
            ),
            array(
                'label' => 'Penataan Areal Kerja',
                'content' => $this->renderPartial('prasyarat/index_areal_kerja', array('model' => $arealKerja), true),
            ),
            array(
                'label' => 'Pemasukan & Penggunaan Peralatan',
                'content' => $this->renderPartial('prasyarat/index_peralatan', array('model' => $peralatan), true),
            ),
            array(
                'label' => 'Pengadaan Sarpras',
                'content' => $this->renderPartial('prasyarat/index_sarpras', array('model' => $sarpras), true),
            ),
            array(
                'label' => 'Pembukaan Wilayah Hutan',
                'content' => $this->renderPartial('prasyarat/index_pwh', array('model' => $pwh), true),
            ),
        )
    ));
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