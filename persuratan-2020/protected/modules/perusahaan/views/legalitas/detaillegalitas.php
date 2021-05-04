<?php
$this->breadcrumbs = array(
    'Legalitas Perusahaans' => array('index'),
    'Detail',
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
    <h4 class="page-header">Detail Legalitas Perusahaan</h4>

    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            // 'id_legalitas',
            // 'perusahaan_id',
            'jenis_legalitas',
            'notaris',
            'nomor',
            //'tanggal',
            array(
                'name' => 'tanggal',
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
                //'value' =>
            ),             'perubahan_ke',
            array(
                'label' => 'File Surat Kemenkumham',
                'type' => 'raw',
                'value' => function ($data) {
                    if (!is_null($data->pdf_surat_kemenkumham)) {
                        $file_name = end(explode('/', $data->pdf_surat_kemenkumham));
                        $file = $file_name . " <a href='" . $this->createUrl('/') . $data->pdf_surat_kemenkumham . "' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                        return $file;
                    }
                }
            ),
            array(
                'label' => 'File Akte',
                'type' => 'raw',
                'value' => function ($data) {
                    if (!is_null($data->pdf_akte_legalitas)) {
                        $file_name = end(explode('/', $data->pdf_akte_legalitas));
                        $file = $file_name . " <a href='" . $this->createUrl('/') . $data->pdf_akte_legalitas . "' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                        return $file;
                    }
                }
            ),
        ),
    ));
    ?>
    <br>
    <br>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'rootwizard',
        'tabs' => array(
            array(
                'label' => 'Pengurus',
                'content' => $this->renderPartial('index_pengurus', array(
                    'direksi' => $direksi,
                    'komisaris' => $komisaris,
                    'id_legalitas' => $id_legalitas
                        ), true),
                'active' => true
            ),
            array(
                'label' => 'Pemegang Saham',
                'content' => $this->renderPartial('index_saham', array(
                    'model' => $model_saham,
                    'modal' => $modal_saham,
                    'id_legalitas' => $id_legalitas
                        ), true),
            // 'active' => true
            ),
        // array(
        //     'label' => 'Komisaris',
        //     'content' => $this->renderPartial('index_pengurus', array('model' => $pengurus), true),
        // ),
        )
    ));
    ?>


</div>