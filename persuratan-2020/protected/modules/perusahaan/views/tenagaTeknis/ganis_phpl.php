<?php
$this->breadcrumbs = array(
    'Tenaga Teknis PHPL'
);
?>
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Tenaga Teknis PHPL</h4>

    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $modelSertifikat,
        'attributes' => array(
            'nama',
            'ktp',
            'alamat',
            array(
                'name' => "Tanggal",
                'value' => function($data) {
                    return isset($data->tgl_lahir) ? Yii::app()->controller->getDateMonth($data->tgl_lahir) : "-";
                }
            ),
            'idPendidikan.pendidikan',
            'idJenisTenagaKerja.nama_jenis',
            'no_sertifikat',
            array(
                'name' => "Tanggal Sertifikat",
                'value' => function($data) {
                    return isset($data->tgl_sertifikat) ? Yii::app()->controller->getDateMonth($data->tgl_sertifikat) : "-";
                }
            ),        
            array(
                'name' => 'is_aktif',
                'value' => function($data) {
                    if($data->is_aktif == "1") {
                        $s = "Masih Bekerja";
                    } else {
                        $s = "Sudah Keluar";
                    }
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        return "<span style='color:red'>".$s."</span>";
//                    } else {
//                        return $s;
//                    }
                },
                'type' => 'raw'
            ),
            array(
                'name' => "Tanggal Keluar Kerja",
                'value' => function($data) {
                     if($data->is_aktif ==0){
                        return Yii::app()->controller->getDateMonth($data->tgl_keluar);
                     }
                     else{
                         return "-";
                     }
                }
            ),
            array(
                'label' => 'File Sertifikat',
                'type'  => 'raw',
                'value' => function ($data) {
                    if(!is_null($data->file_doc)) {
                        $file_name = end(explode('/',$data->file_doc));
                        $file = $file_name. " <a href='".$this->createUrl('/').$data->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                        return $file;
                    }
                }
            ),
        ),
    ));
    ?>
    <br>
    <?php
    $box = $this->beginWidget(
            'booster.widgets.TbPanel', array(
        'title' => 'Daftar Surat Keputusan Tenaga Teknis',
        // 'headerIcon' => 'save',
        'padContent' => false
            )
    );

//    $modelcek = PenilikanPhpl::model()->findAllByAttributes(array('id_sertifikat_phpl' => $modelSertifikat->id));
//
//    $buton_hide = false;
//    if (count($modelcek) == 4) {
//        $buton_hide = true;
//    }
    ?>
    <!-- <br> -->
    <div style="padding:10px">
        <?php if (!$buton_hide) { ?>
            <a id="buton_new" class="btn btn-primary btn-sm" href="javascript:addGanis()"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Data Surat Keputusan</a>
        <?php } ?>

        <?php
        $this->widget('booster.widgets.TbGridView', array(
            'id' => Yii::app()->controller->id . '-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'enableSorting' => false,
            'dataProvider' => $model->search(),
            // 'filter'=>$model,
            'template' => '{items}',
            'columns' => array(
                // 'id',
                // 'id_perusahaan',
                'no_reg',
                'no_sk',
                'tgl_sk',
                array(
                'name' => "Masa Berlaku",
                'value' => function($data) {
                    $awal = isset($data->tgl_awal_sk) ? Yii::app()->controller->getDateMonth($data->tgl_awal_sk) : "-";
                    $akhir = isset($data->tgl_akhir_sk) ? Yii::app()->controller->getDateMonth($data->tgl_akhir_sk) : "-";
                    return $awal .' s/d '.$akhir;
                    }
                ),
                'idBphp.nama_bphp',
                        
            array(
                'name' => 'approval_status',
                'header' => 'Status',
                'value' => function($data) {
                    if($data->approval_status == 0) {
                        return "Menunggu Persetujuan";
                    }elseif($data->approval_status == 1) {
                        return "Disetujui";
                    }else {
                        return "Ditolak";
                    }
                },
                'type' => 'raw'
            ),    
//                        
//                array(   
//                    'name' => 'approval_status',
//                    'header' => 'Status',
//                    'value' => '$data[approval_status] == 0 ? "Belum Di Setujui" : "Di Setujui"'
//                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{edit} {delete} {file_1} {file_2}',
                    'buttons' => array(
                        'file_1' => array(
                            'options' => array('data-toggle' => 'tooltip', 'title' => 'File Sim Ganis' ),
                            'label' => '<i class="fa fa-file-pdf-o"></i>',
                            'visible' => '$data->file_reg == null ? "0" : "1"',
                            'url' => function ($data) {
                                if(!is_null($data->file_reg)) {
                                    $file = $this->createUrl('/').$data->file_reg;
                                    return $file;
                                }
                            }
                        ),
                            'file_2' => array(
                            'options' => array('data-toggle' => 'tooltip', 'title' => 'File SK Ganis' ),
                            'label' => '<i class="fa fa-file-pdf-o"></i>',
                            'visible' => '$data->file_reg == null ? "0" : "1"',
                            'url' => function ($data) {
                                if(!is_null($data->file_sk)) {
                                    $file = $this->createUrl('/').$data->file_sk;
                                    return $file;
                                }
                            }
                        ),
                        'edit' => array(
                            'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit'),
                            'label' => '<i class="fa fa-edit"></i>',
                            'url' => function ($data) {
                                $_url = 'javascript:addGanis("' . $data->id . '")';
                                return $_url;
                            },
                        ),
                        'delete' => array(
                            'url' => function ($data) {
                                $_url = Yii::app()->createUrl("perusahaan/tenagaTeknis/deleteGanisPHPL", array("id" => $data->id, 'id_setifikat' => $data->id));
                                return $_url;
                            },
                        )
                    )
                ),
            ),
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function addGanis(id = "") {
        var url = "<?php echo $this->createUrl('//perusahaan/tenagaTeknis/AddGanisPHPL', array('id' => $modelSertifikat->id)); ?>?id_ganis=" + id;
        var title = "Tambah Data Surat Keputusan";
        showModal(url, title);
    }
    
    $("#select_is_aktif").on('change',function () {
            var v = $("#select_is_aktif").val();
            if(v == 1) {
                    $("#tgl_keluar").hide();
            } else {
                    $("#tgl_keluar").show();
            }
    });
</script>
    
    
</script>
