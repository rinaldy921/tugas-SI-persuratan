<?php $label = Logic::getLastLoginByPerusahan($iuphhk->id_perusahaan);?>
<?php
$this->breadcrumbs = array(
    'IUPHHK-HTI' => array('//admin/iuphhk/index'),
    $iuphhk->idPerusahaan->nama_perusahaan
);
?>
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
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Keadaan Hutan</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $keadaanhutan->search(),
        'enableSorting' => false,
        'template' => '{items}{pager}',
        'columns' => array(
            array(
                'name' => 'id_penutupan_lahan',
                'header' => 'Penutupan Lahan',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value' => '$data->idPenutupanLahan->jenis_penutupan'
            ),
            array(
                'name' => 'hpt',
                'type' => 'raw',
            ),
            array(
                'name' => 'hp',
                'type' => 'raw',
            ),
            array(
                'name' => 'hpk',
                'type' => 'raw',
            ),
            array(
                'name' => 'apl',
                'type' => 'raw',
            ),
            array(
                'name' => 'hl',
                'type' => 'raw',
            ),
            array(
                'name' => 'hsaw',
                'type' => 'raw',
            ),
            array(
                'name' => 'ksa',
                'type' => 'raw',
            ),
        ),
    ));
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("addTh", "
$('#" . Yii::app()->controller->id . "-grid table thead').prepend('<tr><th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Penutupan Lahan</th><th colspan=\'7\' style=\'text-align: center; vertical-align: middle\'>Fungsi Hutan</th></tr>')
", CClientScript::POS_END);