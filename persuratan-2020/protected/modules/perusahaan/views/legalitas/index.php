<?php
$this->breadcrumbs = array(
    'Legalitas Perusahaans' => array('index'),
    'Manage',
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
    <h4 class="page-header">Data LegalitasPerusahaan</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?><?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        // 'filter' => $model,
        'enableSorting' => false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
//		'id_legalitas',
//		'perusahaan_id',
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
                'template' => '{legal} {update} {delete} {file_2} {file_1} ',
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
                        'label' => '<i class="fa fa-file-pdf-o"></i>',
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
