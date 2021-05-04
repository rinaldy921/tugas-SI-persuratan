<?php $label = Logic::getLastLoginByPerusahan($iuphhk->id_perusahaan);?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iuphhk->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iuphhk->idPerusahaan->nama_perusahaan ?></td>
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
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Legalitas Perusahaan</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $legalitas->search(),
        // 'filter' => $model,
        'enableSorting' => false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
//      'id_legalitas',
//      'perusahaan_id',
            'jenis_legalitas',
            'notaris',
            'nomor',
            // 'tanggal',
            array(
                'name' => 'tanggal',
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
                //'value' =>
            ),            
            array(
                'name' => 'perubahan_ke',
                'value' => '($data->jenis_legalitas=="Akte Perubahan") ? $data->perubahan_ke : ""'
            ),
            // array(
            //     'header' => 'File Surat Kemenkumham',
            //     'type'  => 'raw',
            //     'value' => function ($data) {
            //         if(!is_null($data->pdf_surat_kemenkumham)) {
            //             $file = " <a href='".$this->createUrl('/').$data->pdf_surat_kemenkumham."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
            //             return $file;
            //         }
            //     }
            // ),
            // array(
            //     'header' => 'File Akte',
            //     'type'  => 'raw',
                // 'value' => function ($data) {
                //     if(!is_null($data->pdf_akte_legalitas)) {
                //         $file = " <a href='".$this->createUrl('/').$data->pdf_akte_legalitas."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                //         return $file;
                //     }
            //     }
            // ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                // 'template' => '{legal} {update} {delete} {file_1} {file_2} ',
                'template' => '{file_1} {file_2} ',
                'htmlOptions' => array('style'=>'width:100px', "text-align" => "center"),
                'buttons' => array(

                    'legal' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Detail' ),
                        'label' => '<i class="fa fa-table"></i>',
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/detaillegalitas", array("id"=>$data->id_legalitas))',
                    ),

                    'file_1' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'File Surat Kemenkumham' ),
                        'label' => '<i class="fa fa-file-pdf-o"></i>',
                        'visible' => '$data->pdf_surat_kemenkumham == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->pdf_surat_kemenkumham)) {
                                $file = $this->createUrl('/').$data->pdf_surat_kemenkumham;
                                return $file;
                            }
                        }
                    ),

                    'file_2' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'File Akte' ),
                        'label' => '<i class="fa fa-file-image-o"></i>',
                        'visible' => '$data->pdf_akte_legalitas == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->pdf_akte_legalitas)) {
                                $file = $this->createUrl('/').$data->pdf_akte_legalitas;
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