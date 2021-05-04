<?php
$this->breadcrumbs = array(
    'IUPHHK-HTI' => array('index'),
    $perusahaan->nama_perusahaan
);
?>
<div id="page-wrapper" class="col-md-12">
    <!--<h4 class="page-header">Data Perusahaan</h4>-->
    <div class="panel panel-success">
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $perusahaan,
            'type' => array('bordered'),
//        'htmlOptions'=> array('class'=>''),
            'attributes' => array(
                'nama_perusahaan',
                'npwp',
                'telepon',
                'website',
                array(
                    'label'=>'Last Login',
                    'type'=>'raw',
                    'value'=>Logic::getLastLoginByPerusahan($perusahaan->id_perusahaan)
                )
            ),
        ));
        ?></div>
    <h4 class="page-header"></h4>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'left',
        'tabs' => array(
            array(
                'label' => 'Data Umum',
                'content' => $this->renderPartial('detail_perusahaan', array('perusahaan' => $perusahaan), true),
                'active' => true
            ),
            array(
                'label' => 'Kantor Cabang',
                'content' => $this->renderPartial('detail_cabang', array('cabang' => $cabang), true),
            ),
            array(
                'label' => 'Legalitas',
                'content' => $this->renderPartial('_index_legalitas', array('model' => $modelLegalitas), true),
            ),
            array(
                'label' => 'Kepemilikan Saham',
                'content' => $this->renderPartial('_index_saham', array('model' => $modelSaham, 'permodalan' => $permodalan), true),
            ),
            array(
                'label' => 'Data Pengurus',
                'content' => $this->renderPartial('_index_dirkom', array('komisaris' => $modelKomisaris, 'modelDireksi' => $modelDireksi), true),
            ),
            array(
                'label' => 'Data Tenaga Kerja',
                'content' => $this->renderPartial('_index_tenaker', array('teknis' => $modelTeknis, 'non_teknis' => $modelNonTeknis), true),
            ),
            array(
                'label' => 'Sertifikasi PHPL/VLK',
                'content' => $this->renderPartial('_index_sertifikat', array('modelPhpl' => $modelPhpl, 'modelVlk' => $modelVlk), true),
            ),
        ),
    ));
    $this->endWidget();
    ?>
</div>