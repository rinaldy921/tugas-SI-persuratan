<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan);?>
<?php
$this->breadcrumbs = array(
    'Adendum',
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
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_admin_data_pokok.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Adendum SK</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
//        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'nomor_adendum',
            'tanggal',
            array(
                'name' => 'luas',
                'value' => 'isset($data->luas)? floatval($data->luas) . " Ha": "-"',
            )
        ),
    ));
    ?>
</div>