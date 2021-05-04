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
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Data Administrasi Pemerintahan</h4>
    <br>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-administasi',
        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Pemerintahan',
                'content' => $this->renderPartial('tab-pemerintahan', array('admPemerintahan' => $admPemerintahan), true),
                'active' => true
            ),
            array(
                'label' => 'Pemangkuan Hutan',
                'content' => $this->renderPartial('tab-pemangkuan', array('admPemangkuan' => $admPemangkuan), true),
            ),
        ),
    ));
    $this->endWidget();
    ?>


<!--     <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Administrasi Pemerintahan</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $admPemerintahan->search(),
//    'filter' => $model,
        'enableSorting' => FALSE,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'name' => 'provisi',
                'value' => '$data->provinsi0->nama'
            ),
            array(
                'name' => 'kabupaten',
                'value' => 'isset($data->kabupaten) ? $data->kabupaten0->nama : null'
            ),
            array(
                'name' => 'kecamatan',
                'value' => 'isset($data->kecamatan) ? $data->kecamatan0->nama : null'
            ),
//        array(
//            'class' => 'booster.widgets.TbButtonColumn',
//            'template' => '{update} {delete}'
//        ),
        ),
    ));
    ?>
<h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Pemangkuan Hutan</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $admPemangkuan->search(),
//    'filter' => $model,
        'enableSorting' => FALSE,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'name' => 'dinhut_prov',
                'header' => 'Dishut Provinsi',
                'value' => '$data->dinhutProv->nama',
            ),
            array(
                'name' => 'dinhut_kab',
                'header' => 'Dishut Kabupaten',
                'value' => '$data->dinhutKab->nama',
            ),
            array(
                'name' => 'id_kph',
                'header' => 'KPH',
                'value' => '$data->idKph->nama_kph',
            ),
            array(
                'name' => 'bkph',
            ),
            array(
                'name' => 'rph',
            ),
        ),
    ));
    ?> -->
</div>