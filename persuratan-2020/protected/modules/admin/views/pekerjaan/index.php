<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan);?>
<?php
$this->breadcrumbs = array(
    'IUPHHK-HTI' => array('//admin/iuphhk/index'),
    $iup->idPerusahaan->nama_perusahaan
);
?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iup->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iup->nama_perusahaan ?></td>
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_admin_data_pokok_sosial_ekonomi.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-pekerjaan"></i> Mata Pencaharian</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $modelPekerjaan,
        'attributes' => array(
            // 'tipe_iklim',
            array(
                'label' => 'Bertani',
                'value' => $modelPekerjaan->bertani ? floatval($modelPekerjaan->bertani) . ' (%)' : null,
            ),
            array(
                'label' => 'Berdagang',
                'value' => $modelPekerjaan->berdagang ? floatval($modelPekerjaan->berdagang) . ' (%)' : null,
            ),
            array(
                'label' => 'PNS',
                'value' => $modelPekerjaan->pns ? floatval($modelPekerjaan->pns) . ' (%)' : null,
            ),
            array(
                'label' => 'Lainnya',
                'value' => $modelPekerjaan->lainnya ? floatval($modelPekerjaan->lainnya) . ' (%)' : null,
            )
        ),
    ));
    ?>
</div>