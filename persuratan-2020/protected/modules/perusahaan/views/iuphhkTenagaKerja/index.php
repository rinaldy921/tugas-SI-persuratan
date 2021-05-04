<?php
$this->breadcrumbs = array(
    'Tenaga Teknis PHPL',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Tenaga Teknis PHPL</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Tenaga Teknis PHPL'), array('create'), array('class' => 'btn btn-primary')); ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        // 'filter' => $model,
        'enableSorting'=>false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            // 'nama',
            array(
                'name' => 'nama',
                'value' => function($data) {
                    $now = date("Y-m-d");
                    if($data->tgl_akhir_sertifikat < $now) {
                        return "<span style='color:red'>".$data->nama."</span>";
                    } else {
                        return $data->nama;
                    }
                },
                'type' => 'raw'
            ),
            array(
                'name' => 'ktp',
                'value' => function($data) {
                    $now = date("Y-m-d");
                    if($data->tgl_akhir_sertifikat < $now) {
                        return "<span style='color:red'>".$data->ktp."</span>";
                    } else {
                        return $data->nama;
                    }
                },
                'type' => 'raw'
            ),
            array(
                'name' => 'alamat',
                'value' => function($data) {
                    $now = date("Y-m-d");
                    if($data->tgl_akhir_sertifikat < $now) {
                        return "<span style='color:red'>".$data->alamat."</span>";
                    } else {
                        return $data->nama;
                    }
                },
                'type' => 'raw'
            ),
//            array(
//                'name' => 'id_jenis_tenaga_kerja',
//                'value' => function($data) {
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        return "<span style='color:red'>".$data->idGanis->nama_jenis."</span>";
//                    } else {
//                        return $data->idGanis->nama_jenis;
//                    }
//                },
//                'type' => 'raw'
//            ),
//            array(
//                'name' => 'no_reg',
//                'value' => function($data) {
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        return "<span style='color:red'>".$data->no_reg."</span>";
//                    } else {
//                        return $data->no_reg;
//                    }
//                },
//                'type' => 'raw'
//            ),
//            // 'no_sertifikat',
//            array(
//                'name' => 'no_sertifikat',
//                'value' => function($data) {
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        return "<span style='color:red'>".$data->no_sertifikat."</span>";
//                    } else {
//                        return $data->no_sertifikat;
//                    }
//                },
//                'type' => 'raw'
//            ),
//            // 'tgl_awal_sertifikat',
//            array(
//                'name' => "Masa Berlaku",
//                'type' => 'raw',
//                'value' => function($data) {
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        $awal=  "<span style='color:red'>".$data->tgl_awal_sertifikat." s/d </span>";
//                    } else {
//                        $awal=  $data->tgl_awal_sertifikat .' s/d ';
//                    }
//
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        $akhir =  "<span style='color:red'>".$data->tgl_akhir_sertifikat."</span>";
//                    } else {
//                        $akhir =  $data->tgl_akhir_sertifikat;
//                    }
//
//                    return $awal.$akhir;
//                }
//            ),
            // array(
            //     'name' => 'tgl_awal_sertifikat',
            //     'value' => function($data) {
            //         $now = date("Y-m-d");
            //         if($data->tgl_akhir_sertifikat < $now) {
            //             return "<span style='color:red'>".$data->tgl_awal_sertifikat."</span>";
            //         } else {
            //             return $data->tgl_awal_sertifikat;
            //         }
            //     },
            //     'type' => 'raw'
            // ),
            // array(
            //     'name' => 'tgl_akhir_sertifikat',
            //     'value' => function($data) {
            //         $now = date("Y-m-d");
            //         if($data->tgl_akhir_sertifikat < $now) {
            //             return "<span style='color:red'>".$data->tgl_akhir_sertifikat."</span>";
            //         } else {
            //             return $data->tgl_akhir_sertifikat;
            //         }
            //     },
            //     'type' => 'raw'
            // ),
            // 'idKualifikasi.kualifikasi',
            // array(
            //     'name' => 'idKualifikasi.kualifikasi',
            //     'value' => function($data) {
            //         $now = date("Y-m-d");
            //         if($data->tgl_akhir_sertifikat < $now) {
            //             return "<span style='color:red'>".$data->idKualifikasi->kualifikasi."</span>";
            //         } else {
            //             return $data->idKualifikasi->kualifikasi;
            //         }
            //     },
            //     'type' => 'raw'
            // ),
            // 'idPendidikan.pendidikan',
            array(
                'name' => 'idPendidikan.pendidikan',
                'value' => function($data) {
                    $now = date("Y-m-d");
                    if($data->tgl_akhir_sertifikat < $now) {
                        return "<span style='color:red'>".$data->idPendidikan->pendidikan."</span>";
                    } else {
                        return $data->idPendidikan->pendidikan;
                    }
                },
                'type' => 'raw'
            ),
            array(
                'name' => 'is_aktif',
                'value' => function($data) {
                    if($data->is_aktif == "1") {
                        $s = "Masih Bekerja";
                    } else {
                        $s = "Sudah Keluar";
                    }
                    $now = date("Y-m-d");
                    if($data->tgl_akhir_sertifikat < $now) {
                        return "<span style='color:red'>".$s."</span>";
                    } else {
                        return $s;
                    }
                },
                'type' => 'raw'
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{detail} {update} {delete}',
                'buttons' => array(
                        'detail' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Detail'),
                        'label' => '<i class="fa fa-table"></i>',
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/detailganis", array("id"=>$data->id))',
                    ),
                )           
            ),
        ),
    ));
    ?>
</div>
