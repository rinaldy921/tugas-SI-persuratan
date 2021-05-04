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
        <?php
//         $this->widget('booster.widgets.TbDetailView', array(
//             'data' => $model,
//             'type' => array('bordered'),
// //        'htmlOptions'=> array('class'=>''),
//             'attributes' => array(
//                 'nama_perusahaan',
//                 'npwp',
//                 'telepon',
//                 'website',
//                 array(
//                     'label'=>'Last Login',
//                     'type'=>'raw',
//                     'value'=>Logic::getLastLoginByPerusahan($model->id_perusahaan)
//                 )
//             ),
//         ));
        ?>
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
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> SK Izin</h4>
    <br>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $iuphhk,
        'attributes' => array(
            array(
                'label' => 'Nama Perusahaan',
                'value' => function ($data) {
                    if(is_null($data->nama_perusahaan)) {
                        $v = $data->idPerusahaan->nama_perusahaan;
                    } else {
                        $v = $data->nama_perusahaan;
                    }
                    return $v;
                }
            ),
            'nomor',
            array(
                'label' => 'Tanggal SK',
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
                //'value' =>
            ),
            //'tanggal',
            array(
                'name' => "Masa Berlaku",
                'value' => function($data) {
                    $awal = isset($data->tgl_start) ? Yii::app()->controller->getDateMonth($data->tgl_start) : "-";
                    $akhir = isset($data->tgl_end) ? Yii::app()->controller->getDateMonth($data->tgl_end) : "-";
                    return $awal .' s/d '.$akhir;
                }
            ),
            array(
                'label' => 'Luas Lahan',
                'value' => isset($iuphhk->luas)? floatval($iuphhk->luas) . " Ha": ""
            ),
            // 'investasi_rupiah',
            // 'investasi_dolar',
            array(
                'label' => 'File SK',
                'type'  => 'raw',
                'value' => function ($data) {
                    if(!is_null($data->file_doc)) {
                        $file_name = end(explode('/',$data->file_doc));
                        $file = $file_name. " <a href='".$this->createUrl('/').$data->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                        return $file;
                    }
                }
            ),
            // 'tgl_start',
            // 'tgl_end',
        ),
    ));
    ?>
    <br>
    <?php $box = $this->beginWidget(
        'booster.widgets.TbPanel',
        array(
            'title' => 'Data Revisi IUPHHK',
            // 'headerIcon' => 'save',
            'padContent' => false
        )
    );?>
    <div style="padding:10px">


    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $iuphhkRevisi->searchrevisi(),
//        'filter' => $model,
        'enableSorting' => false,
        'emptyText' => 'Tidak ada data',
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'header' => 'Nama Perusahaan',
                'value' => function ($data) {
                    if(is_null($data->nama_perusahaan)) {
                        $v = $data->idPerusahaan->nama_perusahaan;
                    } else {
                        $v = $data->nama_perusahaan;
                    }
                    return $v;
                }
            ),
            'nomor',
            array(
                'header' => 'Tanggal SK',
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
                //'value' =>
            ),
            //'tanggal',
            array(
                'name' => "Masa Berlaku",
                'value' => function($data) {
                    $awal = isset($data->tgl_start) ? Yii::app()->controller->getDateMonth($data->tgl_start) : "-";
                    $akhir = isset($data->tgl_end) ? Yii::app()->controller->getDateMonth($data->tgl_end) : "-";
                    return $awal .' s/d '.$akhir;
                }
            ),
            array(
                'header' => 'Luas Lahan',
                'value' => function ($data) {
                    return isset($data->luas)? floatval($data->luas) . " Ha": "";
                    //return number_format($data->luas,0,',','.') . "Ha": "";
                }
            ),
            // 'investasi_rupiah',
            // 'investasi_dolar',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template'=>'{delete} {file_1}',
                // 'htmlOptions' => array('style'=>'width:100px', "text-align" => "center"),
                'buttons'=>array(
                    'file_1' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'File SK' ),
                        'label' => '<i class="fa fa-file-pdf-o"></i>',
                        'visible' => '$data->file_doc == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->file_doc)) {
                                $file = $this->createUrl('/').$data->file_doc;
                                return $file;
                            }
                        }
                    ),
                ),
            ),
        ),
    ));
    ?>
    </div>
    <?php $this->endWidget(); ?>



</div>