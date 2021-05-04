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
    <h4> <i class="fa fa-bars" style="cursor:pointer;" id="btn-tmpt_pdd"></i> Tempat Pendidikan</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            // 'tipe_iklim',
            array(
                'label' => 'SD',
                'value' => $model->sd ? floatval($model->sd) . ' (Buah)' : null,
            ),
            array(
                'label' => 'SLTP',
                'value' => $model->sltp ? floatval($model->sltp) . ' (Buah)' : null,
            ),
            array(
                'label' => 'SMA',
                'value' => $model->sma ? floatval($model->sma) . ' (Buah)' : null,
            ),
            array(
                'label' => 'PT',
                'value' => $model->pt ? floatval($model->pt) . ' (Buah)' : null,
            ),
            array(
                'label' => 'Lainnya',
                'value' => $model->lainnya ? floatval($model->lainnya) . ' (Buah)' : null,
            )
        ),
    ));?>
    <!-- <br>

    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-tmpt_ibadah"></i> Tempat Ibadah</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model2,
        'attributes' => array(
            array(
                'label' => 'Masjid',
                'value' => $model2->mesjid ? floatval($model2->mesjid) . ' (Unit)' : null,
            ),
            array(
                'label' => 'Gereja',
                'value' => $model2->gereja ? floatval($model2->gereja) . ' (Unit)' : null,
            ),
            array(
                'label' => 'Lainnya',
                'value' => $model2->lainnya ? floatval($model2->lainnya) . ' (Unit)' : null,
            )
        ),
    ));
    ?> -->
</div>