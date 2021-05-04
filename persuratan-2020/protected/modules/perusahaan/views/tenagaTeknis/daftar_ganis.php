<?php
$this->breadcrumbs = array(
    'Sertifikasi PHPL'
);
?>
<!--<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
        <div class="navbar-default sidebar-nav">
            <?php // require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>
    </div>
</div>-->
<!--<div id="page-wrapper" class="col-md-9">-->
<!--    <h4 class="page-header">Data Tenaga Teknis</h4>-->
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary')); ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $daftarGanis->search(),
        //'filter'=>$model,
        'enableSorting' => false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
            array(
                'name' => 'nama',
//                'value' => function($data) {
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        return "<span style='color:red'>".$data->nama."</span>";
//                    } else {
//                        return $data->nama;
//                    }
//                },
                'type' => 'raw'
            ),
            array(
                'header' => "Jenis Ganis",
                'name' => 'idJenisTenagaKerja.nama_jenis',
            ),
//            'idJenisTenagaKerja.nama_jenis',
            'no_sertifikat',
            array(
                'header' => "Tanggal Sertifikat",
                'name' => 'tgl_sertifikat',
                'value' => function($data) {
                    return isset($data->tgl_sertifikat) ? Yii::app()->controller->getDateMonth($data->tgl_sertifikat) : "-";
                }
            ),
            //'id.tgl_akhir_sk',
//            array(
//                'name' => 'ktp',
//                'value' => function($data) {
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        return "<span style='color:red'>".$data->ktp."</span>";
//                    } else {
//                        return $data->nama;
//                    }
//                },
//                'type' => 'raw'
//            ),
//            array(
//                'name' => 'alamat',
//                'value' => function($data) {
//                    $now = date("Y-m-d");
//                    if($data->tgl_akhir_sertifikat < $now) {
//                        return "<span style='color:red'>".$data->alamat."</span>";
//                    } else {
//                        return $data->nama;
//                    }
//                },
//                'type' => 'raw'
//            ),
            //'tanggal',
//            array(
//                'name' => "Tanggal",
//                'value' => function($data) {
//                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
//                }
//            ),
//            array(
//                'name' => "Masa Berlaku",
//                'value' => function($data) {
//                    $awal = isset($data->tanggal_mulai) ? Yii::app()->controller->getDateMonth($data->tanggal_mulai) : "-";
//                    $akhir = isset($data->tanggal_berakhir) ? Yii::app()->controller->getDateMonth($data->tanggal_berakhir) : "-";
//                    return $awal . ' s/d ' . $akhir;
//                }
//            ),
//            'idPenerbit.penerbit',
//            'predikat',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style'=>'width:90px', "text-align" => "center"),
                'template' => '{detail} {update} {delete} {file_1}',
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
                    'detail' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Detail'),
                        'label' => '<i class="fa fa-table"></i>',
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/ganisphpl", array("id"=>$data->id))',
                    ),
                )
            ),
        ),
    ));
    ?>
<!--</div>-->
