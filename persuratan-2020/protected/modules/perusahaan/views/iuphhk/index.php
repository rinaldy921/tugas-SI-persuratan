<?php
$this->breadcrumbs = array(
    'IUPHHK'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>
        </div>
    </div>
    <!-- if(is_null($model->nama_perusahaan)) {
        $v = $model->idPerusahaan->nama_perusahaan;
    } else {
        $v = $model->nama_perusahaan;
    } -->
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data IUPHHK</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
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
                'value' => isset($model->luas)? floatval($model->luas) . " Ha": ""
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
    <?php
    if (empty($model)) {
        echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('create'), array('class' => 'btn btn-primary btn-sm'));
    } else {
        echo CHtml::link("<i class='glyphicon glyphicon-repeat'></i> " . Yii::t('app', 'Revisi'), array('iuphhk/revisi/id/' . $model->id_iuphhk), array('class' => 'btn btn-warning btn-sm'));
        echo " ";
        echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('iuphhk/update/id/' . $model->id_iuphhk), array('class' => 'btn btn-primary btn-sm'));
//        echo " ";
//        echo CHtml::link("<i class='fa fa-pencil-del-o'></i> " . Yii::t('app', 'Hapus'), array('iuphhk/delete/id/' . $model->id_iuphhk), array('class' => 'btn btn-primary btn-sm'));      
    }
    ?>
    <br><Br>
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
        'dataProvider' => $modelRevisi->searchrevisi(),
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
                'template'=>'{update} {delete} {file_1}',
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
