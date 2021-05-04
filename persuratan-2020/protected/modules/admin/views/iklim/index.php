<?php $label = Logic::getLastLoginByPerusahan($iuphhk->id_perusahaan);?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iuphhk->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iuphhk->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggak Keputusan</th>
                    <td><?= $this->getDateMonth($iuphhk->tanggal) ?></td>
                    <th>Telepon</th>
                    <td><?= $iuphhk->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Luas Areal</th>
                    <td><?= floatval($iuphhk->luas) ?> Ha</td>
                    <th>Alamat</th>
                    <td><?= $iuphhk->idPerusahaan->alamat ?></td>
                </tr>
                <tr>
                    <th></th>
                    <td></td>
                    <th>Login Terakhir</th>
                    <td class=""><?=$label?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_admin_data_pokok_kondisi_areal_kerja.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Iklim</h4>
    <br>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $iklim,
        'attributes' => array(
            'tipe_iklim',
            array(
                'label' => 'Curah Hujan (mm)',
                'value' => $iklim->curah_hujan ? floatval($iklim->curah_hujan) . ' mm' : null,
            ),
            array(
                'label' => 'Curah Hujan Terendah (mm)',
                'value' => $iklim->hujan_terendah ? floatval($iklim->hujan_terendah) . ' mm' : null,
            ),
            array(
                'label' => 'Curah Hujan Tertinggi (mm)',
                'value' => $iklim->hujan_tertinggi ? floatval($iklim->hujan_tertinggi) . ' mm' : null,
            )
        ),
    ));?>
</div>