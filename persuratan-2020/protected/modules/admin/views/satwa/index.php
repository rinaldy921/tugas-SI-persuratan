<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan);?>
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
    <!-- <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Kelompok Hutan</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-kelompok-hutan-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'enableSorting' => false,
        'dataProvider' => $pokhut->search(),
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'nama',
            'keterangan',
        )
    ));
    ?>
    <br>

    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Keadaan Lahan</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-keadaan-hutan-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $keadaan_lahan,
        'template' => '{items}',
        'columns' => array(
            array(
                'name' => 'jenis',
                'header' => 'Jenis Lahan',
            ),
            array(
                'name' => 'jml',
                'header' => 'Luas (Ha)',
                'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data["jml"])'
            ),
            array(
                'name' => 'persen',
                'header' => 'Pesentase (%)'
            ),
        )
    ));
    ?>
    <br>

    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Topografi</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $topografi,
        'htmlOptions' => array('class' => 'detail-view table-bordered'),
        'attributes' => array(
            array(
                'label' => 'Datar (0-8%)',
                'value' => $topografi->datar ? floatval($topografi->datar) . ' Ha' : null,
            ),
            array(
                'label' => 'Landai (8-15%)',
                'value' => $topografi->landai ? floatval($topografi->landai) . ' Ha' : null,
            ),
            array(
                'label' => 'Agak Curam (15-25%)',
                'value' => $topografi->agak_curam ? floatval($topografi->agak_curam) . ' Ha' : null,
            ),
            array(
                'label' => 'Curam (25-40%)',
                'value' => $topografi->curam ? floatval($topografi->curam) . ' Ha' : null,
            ),
            array(
                'label' => 'Sangat Curam (>40%)',
                'value' => $topografi->sangat_curam ? floatval($topografi->sangat_curam) . ' Ha' : null,
            ),
            array(
                'label' => 'Ketinggian Tempat (dpl)',
                'value' => $topografi->ketinggian ? floatval($topografi->ketinggian) . ' dpl' : null,
            )
        ),
    ));
    ?>
    <br>

    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Iklim</h4>
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
    <br>
 -->
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Satwa Dilindungi</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $satwa->search(),
        'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
        'template' => '{items}',
        'enableSorting' => false,
        'columns' => array(
            array(
                'name' => 'id_jenis',
                'header' => 'Jenis Hewan',
                'value' => '$data->idJenis->nama_jenis',
            ),
            array(
                'name' => 'nama_satwa',
                'header' => 'Nama Satwa',
                'value' => '$data->nama_satwa',
            ),
            array(
                'name' => 'keterangan',
                'value' => '$data->keterangan',
            ),
        )
    ));
    ?>
</div>