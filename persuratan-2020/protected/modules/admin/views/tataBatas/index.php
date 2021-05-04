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
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Progres Tata Batas</h4>
    <?php
        $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . 'progres_tata_batas-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $progrestatabatas->search(),
        // 'filter' => $model,
        'enableSorting'=>false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
            'name' => 'id_progres_tata_batas',
            'header' => 'Progres Tata Batas',
            'value' => '$data->idProgresTataBatas->nama_progres_tata_batas',
            ),
            array(
            'name' => 'id_ket_progres_tata_batas',
            'header' => 'Uraian',
            'value' => '$data->idKetProgres->nama_ket_progres',
            ),
            'nomor',
            array(
                'name' => 'tanggal',
                'value' => 'isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : null'
            ),    
            'keterangan',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{file_1}',
                'buttons' => array(
                    'file_1' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Dokumen Progres Tata Batas' ),
                        'label' => '<i class="fa fa-file-pdf-o"></i>',
                        'visible' => '$data->file_doc == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->file_doc)) {
                                $file = $this->createUrl('/').$data->file_doc;
                                return $file;
                            }
                        }
                    ),
                )
            ),
        ),
    ));
    ?>
</div>