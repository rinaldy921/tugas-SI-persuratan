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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_admin_data_pokok_data_izin.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Laporan Keuangan</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $laporankeuangan->search(),
        // 'filter' => $model,
        'enableSorting'=>false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'tahun',
            array(
                'name'=>'nilai_perolehan',
                'value'=>function ($data) {
                    return number_format($data->nilai_perolehan,0,',','.');
                }
            ),
            array(
                'name'=>'nilai_buku',
                'value'=>function ($data) {
                    return number_format($data->nilai_buku,0,',','.');
                }
            ),
            array(
                'name'=>'total_aset',
                'value'=>function ($data) {
                    return number_format($data->total_aset,0,',','.');
                }
            ),
            // 'nilai_perolehan',
            // '',
            // 'total_aset',
            // array(
            //     'name' => 'luas',
            //     'value' => 'isset($data->luas)? floatval($data->luas) . " Ha": "-"',
            // ),
            // array(
            //     'class' => 'booster.widgets.TbButtonColumn',
            //     'template' => '{update} {delete}'
            // ),
        ),
    ));
    ?>
</div>