<?php
$this->breadcrumbs = array(
    'Sertifikasi PHPL'
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
    <h4 class="page-header">Data Penilikan Sertifikasi PHPL</h4>

    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $modelSertifikat,
        'attributes' => array(
            // 'id',
            // 'id_perusahaan',
            'nomor',
            //'tahun_sertifikasi',
            //'nilai_kinerja',
            // 'tanggal_mulai',
            // 'tanggal_berakhir',
            array(
                'name' => "Tanggal",
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
            ),
            array(
                'name' => "Masa Berlaku",
                'value' => function($data) {
                    $awal = isset($data->tanggal_mulai) ? Yii::app()->controller->getDateMonth($data->tanggal_mulai) : "-";
                    $akhir = isset($data->tanggal_berakhir) ? Yii::app()->controller->getDateMonth($data->tanggal_berakhir) : "-";
                    return $awal . ' s/d ' . $akhir;
                }
            ),
            'predikat',
            'idPenerbit.penerbit',
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
        'title' => 'Daftar Hasil Penilikan Sertifikat PHPL',
        // 'headerIcon' => 'save',
        'padContent' => false
            )
    );

    $modelcek = PenilikanPhpl::model()->findAllByAttributes(array('id_sertifikat_phpl' => $modelSertifikat->id));

    $buton_hide = false;
    if (count($modelcek) == 4) {
        $buton_hide = true;
    }
    ?>
    <!-- <br> -->
    <div style="padding:10px">
        <?php if (!$buton_hide) { ?>
            <a id="buton_new" class="btn btn-primary btn-sm" href="javascript:addPenilikan()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Penilikan Baru</a>
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
                'nomor',
                'tgl_penetapan',
                'penilikan_ke',
                //'idPenerbit.penerbit',
                array(
                    'name' => 'id_penerbit',
                    'value' => '$data->idPenerbit->penerbit',
                ),
                // 'dinyatakan',
                'predikat',
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
                                $_url = 'javascript:addPenilikan("' . $data->id . '")';
                                return $_url;
                            },
                        ),
                        'delete' => array(
                            'url' => function ($data) {
                                $_url = Yii::app()->createUrl("perusahaan/sertifikasiPhpl/deletePenilikanPHPL", array("id" => $data->id, 'id_setifikat' => $data->id_sertifikat_phpl));
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
    function addPenilikan(id = "") {
        var url = "<?php echo $this->createUrl('//perusahaan/sertifikasiPhpl/AddPenilikanPHPL', array('id' => $modelSertifikat->id)); ?>?id_penilikan=" + id;
        var title = "Tambah Data Penilikan";
        showModal(url, title);
    }
</script>