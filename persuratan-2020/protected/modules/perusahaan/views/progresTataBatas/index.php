<?php
$this->breadcrumbs = array(
    'Progres Tata Batas',
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
    <h4 class="page-header">Data Progres Tata Batas</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary')); ?>
    <?php
        $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . 'progres_tata_batas-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
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
                'template' => '{update} {delete} {file_1}',
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
    <?php
    // $this->widget('booster.widgets.TbGridView', array(
    //     'id' => Yii::app()->controller->id . 'progres_tata_batas-grid',
    //     'type' => 'bordered condensed striped',
    //     'responsiveTable' => true,
    //     'dataProvider' => $model->search(),
    //     // 'filter' => $model,
    //     'enableSorting'=>false,
    //     'template' => '{items}{summary}{pager}',
    //     'columns' => array(
    //         'tahun',
    //         array(
    //             'name' => 'id_progres_tata_batas',
    //             'header' => 'Progres Tata Batas',
    //             'value' => '$data->idProgresTataBatas->nama_progres_tata_batas',
    //         ),
    //         'keterangan',
    //         array(
    //             'class' => 'booster.widgets.TbButtonColumn',
    //             'template' => '{update} {delete}'
    //         ),
    //     ),
    // ));
    ?>
</div>
