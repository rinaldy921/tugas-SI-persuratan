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
    <h4 class="page-header">Data Sertifikasi PHPL</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        // 'filter'=>$model,
        'enableSorting' => false,
        'template' => '{items}',
        'columns' => array(
            'nomor',
            //'tanggal',
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
            'idPenerbit.penerbit',
            'predikat',
            array(
                'name' => "Status Verifikasi",
                'value' => function($data) {
                    if($data->is_verified == 1){
                        return "Terverifikasi";
                    }
                    else if($data->is_verified == 0){
                        return "Belum Terverifikasi";
                    }
                     else {
                        return "Sertifikat Telah Di Bekukan";
                    }
                }
            ),  
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
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/penilikanphpl", array("id"=>$data->id))',
                    ),
                )
            ),
        ),
    ));
    ?>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Sertifikasi VLK</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createVlk'), array('class' => 'btn btn-primary')); ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-vlk-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $modelVlk->search(),
        // 'filter'=>$model,
        'enableSorting' => false,
        'template' => '{items}',
        'columns' => array(
            'nomor',
            //'tanggal',
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
            'idPenerbit.penerbit',
            'predikat',
            array(
                'name' => "Status Verifikasi",
                'value' => function($data) {
                     if($data->is_verified == 1){
                        return "Terverifikasi";
                    }
                    else if($data->is_verified == 0){
                        return "Belum Terverifikasi";
                    }
                     else {
                        return "Sertifikat Telah Di Bekukan";
                    }
                }
            ),        
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
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/penilikanvlk", array("id"=>$data->id))',
                    ),
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("//perusahaan/sertifikasiPhpl/deleteVlk",array("id"=>$data->id))',
                    ),
                    'update' => array(
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updateVlk", array("id"=>$data->id))',
                    ),
                )
            ),
        ),
    ));
    ?>
</div>
