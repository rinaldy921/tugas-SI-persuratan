<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan);?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iuphhk->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iuphhk->idPerusahaan->nama_perusahaan ?></td>
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
                    <td class=""><?=$label?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_admin_data_pokok_data_izin.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Data Cabang Perusahaan</h4>
    <br>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'data' => $model,
        'attributes' => array(
           // 'id_cabang',
           //  array(
           //      'name' => 'perusahaan_id',
           //      'value' => ($model->perusahaan_id) ? $model->perusahaan->nama_perusahaan : '-',
           //  ),
            'nama_cabang',
            'alamat',
            array(
                'name' => 'provinsi',
                'value' => ($model->provinsi) ? $model->provinsiCabang->nama : '-',
            ),
            array(
                'name' => 'kabupaten',
                'value' => ($model->kabupaten) ? $model->kabupatenCabang->nama : '-',
            ),
            'kode_pos',
            'telepon',
            // 'email',
            // 'website',
            'kontak',
            'telepon_kontak',
            'email_kontak',
        ),
    ));
    ?>
</div>