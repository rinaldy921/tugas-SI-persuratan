<?php
$this->breadcrumbs = array(
    'Sertifikasi VLK'
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
    <h4 class="page-header">Data Penilikan Sertifikasi VLK</h4>

    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $modelSertifikat,
        'attributes' => array(
            // 'id',
            // 'id_perusahaan',
            'nomor',
            //'tahun_sertifikasi',
            array(
                'name' => "Tanggal",
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
            ),
            array(
                'name' => "Masa Berlaku",
                'value' => function($data) {
                    $awal = isset($data->berlaku) ? Yii::app()->controller->getDateMonth($data->berlaku) : "-";
                    $akhir = isset($data->berakhir) ? Yii::app()->controller->getDateMonth($data->berakhir) : "-";
                    return $awal . ' s/d ' . $akhir;
                }
            ),
            // 'berlaku',
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
        'title' => 'Daftar Hasil Penilikan Sertifikat VLK',
        // 'headerIcon' => 'save',
        'padContent' => false
            )
    );

    $modelcek = PenilikanVlk::model()->findAllByAttributes(array('id_sertifikat_vlk' => $modelSertifikat->id));

    $buton_hide = false;
    if (count($modelcek) == 2) {
        $buton_hide = true;
    }
    ?>
    <!-- <br><br> -->
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
                'idPenerbit.penerbit',
                'predikat',
                // 'dinyatakan',
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
                                $_url = Yii::app()->createUrl("perusahaan/sertifikasiPhpl/deletePenilikanVLK", array("id" => $data->id, 'id_setifikat' => $data->id_sertifikat_vlk));
                                return $_url;
                            },
                        )
                    )
                ),
            ),
        ));
        ?>
    </div></div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function addPenilikan(id = "") {
        var url = "<?php echo $this->createUrl('//perusahaan/sertifikasiPhpl/addPenilikanVLK', array('id' => $modelSertifikat->id)); ?>?id_penilikan=" + id;
        var title = "Tambah Data Penilikan";
        showModal(url, title);
    }
</script>
