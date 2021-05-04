<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan);?>
<?php
$this->breadcrumbs = array(
    'IUPHHK',
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
                    <td class=""><?=$label?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_admin_data_pokok.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data IUPHHK</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'nomor',
            'tanggal',
            array(
                'label' => 'Luas',
                'value' => isset($model->luas)? floatval($model->luas) . " Ha": ""
            ),
            'investasi_rupiah',
            'investasi_dolar',
            'tgl_start',
            'tgl_end',
        ),
    ));
    ?>
    <br>
    <?php
    if (empty($model)) {
        echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('create'), array('class' => 'btn btn-primary btn-sm'));
    } else {
        echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('dataiuphhk/update/id/' . $model->id_iuphhk), array('class' => 'btn btn-primary btn-sm'));
    }
    ?>
</div>
