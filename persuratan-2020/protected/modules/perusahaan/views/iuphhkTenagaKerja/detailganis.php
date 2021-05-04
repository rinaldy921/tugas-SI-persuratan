<?php
$this->breadcrumbs = array(
    'Ganis'
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
    <h4 class="page-header">Data Tenaga Teknis PHPL</h4>

<?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'nama',
            'ktp',
            'tgl_lahir',
            'alamat',
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
            // 'id_pendidikan',
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
            // 'is_aktif',
            // 'tgl_keluar',
        ),
    ));
?>
<br>
<br>
<button onclick="show_form_sk_ganis()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Surat Keputusan</button>
<?php //if (!$buton_hide) { ?>
    <!--<a id="buton_new" class="btn btn-primary btn-sm" href="javascript:addSertifikasi()"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Data Sertifikat Ganis</a>-->
<?php //} ?>
<?php
        $this->widget('booster.widgets.TbGridView', array(
            'id' => Yii::app()->controller->id . '-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'enableSorting' => false,
            'dataProvider' => $modelsertifikatganis->search(),
            // 'filter'=>$model,
            'template' => '{items}',
            'columns' => array(
                'no_reg',
                'no_sk',
                'tgl_sk',
                'tgl_awal_sk',
                'tgl_akhir_sk',
                // 'tgl_penetapan',
                // 'penilikan_ke',
                // //'idPenerbit.penerbit',
                // array(
                //     'name' => 'id_penerbit',
                //     'value' => '$data->idPenerbit->penerbit',
                // ),
                // // 'dinyatakan',
                // 'predikat',
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{edit} {delete} {file_1}',
                    'buttons' => array(
                        'file_1' => array(
                            'options' => array('data-toggle' => 'tooltip', 'title' => 'File Sertifikat' ),
                            'label' => '<i class="fa fa-file-pdf-o"></i>',
                            'visible' => '$data->file_doc == null ? "0" : "1"',
                            'url' => function ($data) {
                                if(!is_null($data->file_doc)) {
                                    $file = $this->createUrl('/').$data->file_doc;
                                    return $file;
                                }
                            }
                        ),
                        'edit' => array(
                            'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit'),
                            'label' => '<i class="fa fa-edit"></i>',
                            'url' => function ($data) {
                                $_url = 'javascript:addSertifikasi("' . $data->id . '")';
                                return $_url;
                            },
                        ),
                        'delete' => array(
                            'url' => function ($data) {
                                $_url = Yii::app()->createUrl("perusahaan/iuphhkTenagaKerja/deleteSertifikasi", array("id" => $data->id, 'id_setifikat' => $data->id_sertifikat_phpl));
                                return $_url;
                            },
                        )
                    )
                ),
            ),
        ));



    //echo $this->renderPartial('_index_sk_ganis', array('model' => $sk_ganis, 'addFungsos' => $addskganis), true);
?>

<script type="text/javascript">
    function show_form_sk_ganis(id = "") {
        var url = "<?php echo $this->createUrl('//perusahaan/iuphhkTenagaKerja/addSkGanis', array('id' => $model->id)); ?>?id_sk_ganis=" + id;
        var title = "Tambah Data Sertifikat Tenaga Teknis";
        showModal(url, title);
    }
  
    
</script>