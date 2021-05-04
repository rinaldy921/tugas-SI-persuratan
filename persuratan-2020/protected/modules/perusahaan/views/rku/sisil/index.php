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
                <tr>
                    <th>File SK</th>
                    <td colspan="3">
                        <?php
                        if(!is_null($model->file_doc)) {
                            $file_name = end(explode('/',$model->file_doc));
                            $file = $file_name. " <a href='".$this->createUrl('/').$model->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                            echo  $file;
                        }
                        ?>
                    </td>
                    <!-- <th>Alamat</th>
                    <td><?= $model->idPerusahaan->alamat ?></td> -->
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
    <h4 class="page-header">Sistem Silvikultur</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $silvikultur,
        'attributes' => array(
            array(
                'label' => 'Sistem Silvikultur',
                'name' => 'status',
                'value' => isset($silvikultur->id_jenis_silvikultur) ? $silvikultur->idJenisSilvikultur->jenis_silvikultur : NULL,
            ),
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $potensiProduksi,
        'attributes' => array(
            array(
                'label' => 'Potensi Rata-rata',
                'name' => 'status',
                'value' => isset($potensiProduksi->potensi_produksi) ? $potensiProduksi->potensi_produksi . ' m3/Ha ' : NULL,
            ),
        ),
    ));
    ?>
    <?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-tanaman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $tanaman->search(),
    'mergeColumns' => array('id_jenis_produksi_lahan'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'id_jenis_tanaman',
            'header' => 'Jenis Tanaman',
            'value' => '$data->idJenisTanaman->nama_tanaman',
        ),
        array(
            'name' => 'daur',
            'value' => '$data->daur ? $data->daur . " Tahun" : "-"',
        ),
        array(
            'name' => 'id_jarak_tanam',
            'value' => '$data->id_jarak_tanam ? $data->idJarakTanam->jarak_tanam : "-"',
        )
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
