<?php
    $iup = Iuphhk::model()->find('id_perusahaan = '.$model->id_perusahaan);
?>
<div id="header">
    <table width="100%" border="0">
        <tr>
            <td><img width="80" src="<?php echo Yii::app()->baseUrl; ?>/img/logo22.png"></td>
            <td>
                <h4>Kementerian Lingkungan Hidup dan Kehutanan</h4>
                <h5>Direktorat Bina Usaha Hutan Tanaman</h5>
            </td>
        </tr>
    </table>
</div>
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
                    <th>Tanggal Keputusan</th>
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
            </tbody>
        </table>
    </div>
</div>
