<?php
//
$this->breadcrumbs = array(
    'IUPHHK-HTI' => array('index'),
    'Data'
);
    $date1 = new DateTime("2017-09-01");
    $date2 = new DateTime("2017-05-01");
    $interval = date_diff($date1, $date2);
    echo $interval->m + ($interval->y * 12) . ' months';
?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iup->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iup->idPerusahaan->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggak Keputusan</th>
                    <td><?= $this->getDateMonth($iup->tanggal) ?></td>
                    <th>Telepon</th>
                    <td><?= $iup->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Luas Areal</th>
                    <td><?= floatval($iup->luas) ?> Ha</td>
                    <th>Alamat</th>
                    <td><?= $iup->idPerusahaan->alamat ?></td>
                </tr>
                <tr>
                    <th></th>
                    <td></td>
                    <th>Login Terakhir</th>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <h4 class="page-header"></h4>

    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'left',
        'tabs' => array(
            array(
                'label' => 'Adendum SK',
                'content' => $this->renderPartial('adendum', array('model' => $adendum), true),
                'active' => true
            ),
            array(
                'label' => 'Data Umum Areal IUPHHK-HTI',
                'content' => $this->renderPartial('index_data_umum_areal', array('pokhut' => $pokhut, 'keadaan_lahan' => $keadaan_lahan, 'topografi' => $topografi), true),
            ),
            array(
                'label' => 'Data Administrasi',
                'content' => $this->renderPartial('index_administrasi', array('admPemerintahan' => $admPemerintahan, 'admPemangkuan' => $admPemangkuan), true),
            ),
            array(
                'label' => 'RKU',
                'content' => $this->renderPartial('rku', array('model' => $rku), true),
            ),
            array(
                'label' => 'RKT',
                'content' => $this->renderPartial('rkt', array('model' => $rkt), true),
            ),
            array(
                'label' => 'Laporan Kinerja',
                'content' => $this->renderPartial('laporan', array('model' => $laporan), true),
            ),
        ),
    ));
    $this->endWidget();
    ?>
</div>