<?php
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => '.modal-fancy',
    'config' => array(
        "autoSize" => false,
        "closeBtn" => true,
        // "showCloseButton" => true,
        "fitToView" => true,
        'width' => '90%',
        'openEffect' => 'none',
        'openSpeed' => 600,
        'closeEffect' => 'none',
        'nextEffect' => 'none',
        'prevEffect' => 'none',
        "helpers" => array("overlay" => array("closeClick" => true)),
        'scrolling' => 'auto',
    ),
));
?>
<?php
$this->breadcrumbs = array(
    'Data RKT',
);
?>
<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/admin/rku/'.$iup->id_iuphhk) ?>">&laquo; Kembali</a>
    <h4 class="text-center">Data RKT Revisi</h4>
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $rku->nomor_sk ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $rku->idPerusahaan->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggal Keputusan</th>
                    <td><?= $this->getDateMonth($rku->tgl_sk) ?></td>
                    <th>Telepon</th>
                    <td><?= $rku->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Periode Tahun RKU</th>
                    <td><?= $rku->tahun_mulai.' - '.$rku->tahun_sampai ?></td>
                    <th>Alamat</th>
                    <td><?= $rku->idPerusahaan->alamat ?></td>
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
    <h4 class="page-header">Data Rkt</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'enableSorting' => false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'tahun_mulai',
            'nomor_sk',
            'tanggal_sk',
            'mulai_berlaku',
            'akhir_berlaku',
            array(
                'name'=>'status',
                'value' => '$data->cekRev($data->id_rku, $data->id)'
            ),
            array(
                'header' => 'Aksi',
                'class' => 'booster.widgets.TbButtonColumn',
                'template'=>'{telahDirevisi}',
                'buttons'=>array(
                    'telahDirevisi' => array(
                        'label' => "<i class='glyphicon glyphicon-eye-open'></i>",
                        'options' => array('title' => Yii::t('app', 'Lihat Data'), 'class' => 'modal-fancy', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/indexRevRkt", array(
                            "id"=>'.$iup->id_iuphhk.',"id_rkt"=>$data->id))',
                    )
                ),
            )
        ),
    ));
    ?>
</div>