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
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kepercayaan"></i> Agama & Kepercayaan</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $modelAgama,
        'attributes' => array(
            // 'tipe_iklim',
            array(
                'label' => 'Islam',
                'value' => $modelAgama->islam ? floatval($modelAgama->islam) . ' (%)' : null,
            ),
            array(
                'label' => 'Katolik',
                'value' => $modelAgama->katolik ? floatval($modelAgama->katolik) . ' (%)' : null,
            ),
            array(
                'label' => 'Kristen',
                'value' => $modelAgama->kristen ? floatval($modelAgama->kristen) . ' (%)' : null,
            ),
            array(
                'label' => 'Lainnya',
                'value' => $modelAgama->lainnya ? floatval($modelAgama->lainnya) . ' (%)' : null,
            )
        ),
    ));
    ?>
</div>