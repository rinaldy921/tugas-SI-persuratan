<?php $baseUrl = Yii::app()->request->baseUrl;
Yii::app()->booster->cs->registerPackage('bootstrap.css');
Yii::app()->clientScript->registerCssFile($baseUrl.'/statics/css/print.css');

//     print_r("<pre>");
//        print_r($modelblok);
//        print_r("</pre>"); exit(1);
?>


<style media="screen">
/* grid border */
.grid-view table.items th, .grid-view table.items td {
border: 1px solid gray !important;
}

/* disable selected for merged cells */
.grid-view td.merge {
background: none repeat scroll 0 0 #F8F8F8;
}
</style>


<?php if($status == '1'){ ?>
<div id="page-wrapper" class="col-md-9">

    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Data UPHHK-HTI</div>
            </div>
        </div>

        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
    //            'id_rku',
                array(
                    'name' => 'Nama Perusahaan',
                    'header' => 'Nama Perusahaan',
                    'value' => $perusahaan->nama_perusahaan,
                    
                ),
               
                'nomor_sk',
                'tgl_sk',
                array(
                    'name' => "Tahun",
                    'value' => function($data) {
                        $awal = $data->tahun_mulai;
                        $akhir = $data->tahun_sampai;
                        return $awal .' s/d '.$akhir;
                    }
                ),
                array(
                    'name' => "Berlaku",
                    'value' => function($data) {
                        $awal = isset($data->mulai_berlaku) ? Yii::app()->controller->getDateMonth($data->mulai_berlaku) : "-";
                        $akhir = isset($data->akhir_berlaku) ? Yii::app()->controller->getDateMonth($data->akhir_berlaku) : "-";
                        return $awal .' s/d '.$akhir;
                    }
                ),
            ),
        ));
                
                
        ?>

        
        </div>
    
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Unit Kelestarian dan Petak Kerja</div>
            </div>
        </div>  
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => Yii::app()->controller->id . '-form',
            'type' => 'bordered condensed striped',
           
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="panel-body">
           
      
            <?php
//                    print_r("<pre>");
//                    print_r($model);
//                    print_r("<pre>");
            ?>
            
            
            
     <?php 
          $this->widget('booster.widgets.BootGroupGridView', array(
          'id' => 'grid1',
          'dataProvider' => $modelblok,
          'mergeColumns' => 'Unit Kelestarian',
          'type' => 'bordered condensed striped',
          'columns' => array(
            array(
              'name'=>'Unit Kelestarian',
              'value' => function($data) {
                  return $data['nama_sektor'];
              }
            ),
            array(
              'name' => 'Petak Kerja',
              'value' => function($data) {
                  return $data['nama_blok'];
              }
            ),
            
          ),
        ));
        ?>
          
        </div>
        <div class="panel-footer">
         
        </div>
       <?php $this->endWidget(); ?>   

</div>
    
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="panel-title">Sistem Silvikultur</div>
        </div>
    </div>

    <div class="panel-body">
          <div class="form-group">
              <div class="col-sm-3" style="text-align: left">
                  <!--<h4>Pengadaan Bibit</h4>-->
              </div>
          </div>    
                <?php
                    $this->widget('booster.widgets.TbDetailView', array(
                    'data' => $modelsilvikultur,
                    'attributes' => array(
                    array(
                        'label' => 'Sistem Silvikultur',
                        'name' => 'status',
                        'value' => isset($modelsilvikultur->id_jenis_silvikultur) ? $modelsilvikultur->idJenisSilvikultur->jenis_silvikultur : NULL,
                        ),
                    ),
                ));
                ?>
     
   
    
 
          <div class="form-group">
              <div style="text-align: left;">
                  <h4>Jenis Tanaman</h4>
              </div>
          </div>
                    <?php
                    $this->widget('booster.widgets.BootGroupGridView', array(
                    'id' => Yii::app()->controller->id . '-tanaman-grid',
                    'type' => 'bordered condensed striped',
                    'responsiveTable' => true,
                    'enableSorting' => false,
                    'dataProvider' => $modeljenistanaman->search(),
                    //'mergeColumns' => array('id_jenis_produksi_lahan'),
                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                    'template' => '{items}{pager}',
                    // 'filter' => $model,
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                                * $this->grid->dataProvider->pagination->pageSize) + 1',
                        ),
                        array(
                            'name' => 'id_jenis_produksi_lahan',
                            'header' => 'Tata Ruang',
                            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
                        ),
                        array(
                            'name' => 'id_jenis_tanaman',
                            'header' => 'Jenis Tanaman',
                            'value' => '$data->idJenisTanaman->nama_tanaman',
                        ),
                        array(
                            'name' => 'daur',
                            'value' => '$data->daur ? $data->daur . " Tahun" : "-"',
                        ),
                        array(
                            'name' => 'jarak_tanam',
                            'value' => '$data->jarak_tanam ? $data->jarak_tanam : "-"',
                        )
                    )
                ));
                ?>
          <br>
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Jenis Hasil Hutan Bukan Kayu</h4>
              </div>
          </div>
        <?php
            //    echo '<pre>'; print_r($hhbk); echo '</pre>';
                $this->widget('booster.widgets.BootGroupGridView', array(
                'id' => Yii::app()->controller->id . '-hhbk-grid',
                'type' => 'bordered condensed striped',
                'responsiveTable' => true,
                'enableSorting' => false,
                'dataProvider' => $modeljenishhbk->search(),
                //'mergeColumns' => array('id_jenis_produksi_lahan'),
                'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                'template' => '{items}{pager}',
                // 'filter' => $model,
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                            * $this->grid->dataProvider->pagination->pageSize) + 1',
                    ),
                    array(
                        'name' => 'id_jenis_produksi_lahan',
                        'header' => 'Tata Ruang',
                        'value' => '$data->idJenisProduksiLahan->jenis_produksi',
                    ),
                    array(
                        'name' => 'id_hasil_hutan_nonkayu',
                        'header' => 'Jenis HHBK',
                        'value' => '$data->idHasilHutanNonkayu->nama_hhbk',
                    ),
                    array(
                        'name' => 'id_satuan_volume_nonkayu',
                        'header' => 'Satuan',
                        'value' => '$data->idSatuanVolumeNonkayu->satuan',
                    ),
                )
            ));
        ?>
        
        
        
        
        
        
         
        </div>   
    </div>
    
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Prasyarat</div>
            </div>
        </div>

        <div class="panel-body">
        
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Organisasi & Tenaga Kerja</h4>
                </div>
            </div>
            <?php
            
$listPendidikan = CHtml::listData(MasterPendidikan::model()->findAll(), 'id_pendidikan', 'pendidikan');
$listKewarganegaraan = CHtml::listData(MasterJenisKewarganegaraan::model()->findAll(), 'id', 'kewarganegaraan');

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'ganis-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modeltenagakerja->search(),
    'enableSorting' => false,
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'is_tenaga_kehutanan',
            'value' => function($data){
                if($data->is_tenaga_kehutanan == '1') return 'Tenaga Professional Kehutanan';
                else return 'Tenaga Professional Lainnya';
            },
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'is_tenaga_tetap',
            'value' => function($data){
                if($data->is_tenaga_tetap == '1') return 'Tenaga Tetap';
                else return 'Tenaga Tidak Tetap';
            }
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_kewarganegaraan',
            'value' => '$data->idJenisKewarganegaraan->kewarganegaraan',
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_pendidikan',
            'value' => '$data->idPendidikan->pendidikan',
        ),                
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Org)',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuSerapanTenagaKerja::model()->getTotal($modeltenagakerja->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    ),
));
?>
            <br>
        
        
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Tata Batas</h4>
                </div>
            </div>  
            <?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-tata-batas-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modeltatabatas->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                * $this->grid->dataProvider->pagination->pageSize) + 1',
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_batas',
            'header' => 'Jenis Batas',
            'value' => '$data->idJenisBatas->jenis_batas',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Km)',
            'name' => 'jumlah',            
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
//          'value' => '$data->jumlah ? $data->jumlah . " Km" : "-"',
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'value' => '$data->jumlah',
            'footer' => '<strong>' . number_format(RkuTataBatas::model()->getTotal($modeltatabatas->search()->getData(), 'jumlah'),2,",",".") . ' </strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        )
    )
));
?>
            
            <br>
        
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Penataan Ruang</h4>
                </div>
            </div>
            
            <strong>a. Kawasan Lindung</strong>
            <?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kawasan-lindung-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelkawasanlindung->search(),
    'enableSorting' => FALSE,
// 'filter'=>$model,
    'template' => '{summary}{items}{pager}',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_kawasan_lindung',
            'header' => 'Jenis Kawasan Lindung',
            'value' => '$data->idJenisKawasanLindung->nama_jenis',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuKawasanLindung::model()->getTotal($modelkawasanlindung->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    ),
));
?>
            <br>
            <strong>b. Areal Tidak Efektif</strong>
            <?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-non-produktif-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelarealnonefektif->search(),
    'enableSorting' => false,
// 'filter'=>$model,
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id',
            'header' => 'Jenis Areal',
            'value' => '"Areal Tidak Produktif"'
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    ),
));
?>
            <br>
            <strong>c. Areal Efektif</strong>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-produktif-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelarealefektif->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Jenis Areal Efektif',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuArealProduktif::model()->getTotal($modelarealefektif->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        )
    )
));
?>
            
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Penataan Areal Kerja</h4>
                </div>
            </div>
            <?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-areal-kerja-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelarealkerja->search(),
    'enableSorting' => false,
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'daur',
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'tahun',
            'header' => 'Blok Kerja Tahun',
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),        
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
            },
            'type' => 'raw',
            'footer' => '<strong>' . number_format(RkuArealKerja::model()->getTotal($modelarealkerja->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        )
    )
));
?>
            <br>
                                 
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Pemasukan & Penggunaan Peralatan</h4>
                 </div>
            </div>
            <?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-peralatan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelperalatan->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_peralatan',
            'header' => 'Nama Peralatan',
            'value' => '$data->nama_peralatan',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuPeralatan::model()->getTotal($modelperalatan->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Keterangan',
            'name' => 'keterangan',
        ),
    )
));
?>
            <br>
                                         
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Pengadaan Sarpras</h4>
                </div>
            </div>
            <?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-sarpras-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelsarpras->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => FALSE,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_sarpras',
            'header' => 'Nama Sarana dan Prasarana',
            'value' => '$data->nama_sarpras',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah',
            'name' => 'jumlah',
            'type' => 'raw',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuSarpras::model()->getTotal($modelsarpras->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Keterangan',
            'name' => 'keterangan',
        )
    )
));
?>
            <br>
                                                 
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Pembukaan Wilayah Hutan</h4>
                </div>
            </div>
            <?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-pwh-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpwh->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => FALSE,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_pwh',
            'header' => 'Jenis Pembukaan',
            'value' => '$data->idJenisPwh->jenis_pembukaan',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Km)',
            'name' => 'jumlah',
            'type' => 'raw',
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuPwh::model()->getTotal($modelpwh->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Keterangan',
            'name' => 'keterangan',
        )
    )
));
?>

        </div>   
    </div>
    
    
    
    
      <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Kelestarian Fungsi Produksi</div>
            </div>
        </div>
          
      <div class="panel-body">
          
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Pengadaan Bibit</h4>
              </div>
          </div>    
         
          
      <?php
    
      
    $this->widget('booster.widgets.BootGroupGridView', array(
                'id'=>'rku-pembenihan-grid',
                //'id' => 'pembibitan-grid',
                'type' => 'bordered condensed striped',
                'responsiveTable' => true,
                'dataProvider' => $modelbibit->search(),
                'template' => '{items}{pager}',
                'enableSorting' => false,
            
                'columns' => array(
                    array(
                        'name' => 'daur',
                        'headerHtmlOptions' => array('style' => 'text-align:center'),
                        'htmlOptions' => array('style' => 'text-align:center',),
                    ),
                    array(
                        'header' => 'Blok Kerja Tahun Ke',
                        'name' => 'rkt_ke',
                    ),
            //        array(
            //            'name' => 'rkt_ke',
            //            'header' => 'Blok Kerja Tahun Ke',
            //            'footer' => '<strong>Total</strong>',
            //        ),
                    array(
                        'name' => 'tahun',
                        'headerHtmlOptions' => array('style' => 'text-align:center'),
                        'htmlOptions' => array('style' => 'text-align:center')
                    ),
                    array(
                        'name' => 'sektor',
                        'header' => 'Unit Kelestarian',
                        'headerHtmlOptions' => array('style' => 'text-align:center'),
                        'value' => '$data->idBlok->namaSektor->nama_sektor',
                        'htmlOptions' => array('style' => 'text-align:center')
                    ),
                    array(
                        'name' => 'blok',
                        'header' => 'Petak Kerja',
                        'headerHtmlOptions' => array('style' => 'text-align:center'),
                        'value' => '$data->idBlok->nama_blok',
                        'htmlOptions' => array('style' => 'text-align:center')
                    ),        
                    array(
                        'name' => 'id_jenis_produksi_lahan',
                        'header' => 'Tata Ruang',
                        'headerHtmlOptions' => array('style' => 'text-align:center'),
                        'value' => '$data->idJenisProduksiLahan->jenis_produksi',
                        'htmlOptions' => array('style' => 'text-align:center')
                    ),        
                    array(
                        'header' => 'Jumlah (Btg)',
                        'name' => 'jumlah',
                        'value'=>'number_format($data->jumlah)',
                    ),
            

                                  
                )
            ));
?>
          
       
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Penyiapan Lahan</h4>
              </div>
          </div>    
         
          
      <?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-siaplahan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
  //  'mergeColumns' => array('daur','rkt_ke', 'tahun', 'sektor','blok', 'id_tanaman_silvikultur'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_lahan', 'id_jenis_produksi_lahan','sektor','blok'),
    'dataProvider' => $modelsiaplahan->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    
    'columns' => array(
        array(
            'name' => 'daur',
        ),
         array(
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
        ),
        array(
            'name' => 'tahun',
            // 'footer' => '<strong>Total</strong>',
        ),
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),        
        array(
            'name' => 'id_tanaman_silvikultur',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
       ),
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
       ),
        array(
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
            'value'=>'number_format($data->jumlah)',
               
        ),
       
    )
));
?>
          
          
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Penanaman</h4>
              </div>
          </div>    
         
          
  <?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-penanaman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modeltanam->search(),
    'template' => '{items}{pager}',
    'enableSorting' => false,
      'mergeColumns' => array('daur','rkt_ke','tahun', 'sektor','blok'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_produksi_lahan','sektor','blok'),
    //'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    'columns' => array(
        array(
            'name' => 'daur',
        ),
       array(
          'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
        ),
        array(
            'name' => 'tahun',
        ),
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),           
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),        
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        array(
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
           'value'=>'number_format($data->jumlah)',               
        ),
        
    )
));
?>
          
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Pemeliharaan</h4>
              </div>
          </div>    
         
          
 <?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-pemeliharaan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpelihara->search(),
//    'mergeColumns' => array('daur','rkt_ke', 'tahun', 'jenis_pemeliharaan' ,'id_jenis_lahan', 'id_jenis_produksi_lahan','sektor','blok'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
       array(
            'name' => 'daur',
        ),
        array(
            'header' => 'Blok Kerja Tahun Ke',
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'rkt_ke',
        ),
         array(
            'name' => 'tahun',
        ),
        array(
            'name' => 'jenis_pemeliharaan',
            'header' => 'Jenis Pemeliharaan',
            'value' => '$data->idJenisPemeliharaan->jenis_pemeliharaan',
        ), 
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),        
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),        
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        array(
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
            'value'=>'number_format($data->jumlah)',
                
        ),
        
	
    )
));
?>
          

          
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Pemanenan Kayu Bulat</h4>
              </div>
          </div>    
         
          
 <?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-pemeliharaan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpelihara->search(),
//    'mergeColumns' => array('daur','rkt_ke', 'tahun', 'jenis_pemeliharaan' ,'id_jenis_lahan', 'id_jenis_produksi_lahan','sektor','blok'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
       array(
            'name' => 'daur',
        ),
        array(
            'header' => 'Blok Kerja Tahun Ke',
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'rkt_ke',
        ),
         array(
            'name' => 'tahun',
        ),
        array(
            'name' => 'jenis_pemeliharaan',
            'header' => 'Jenis Pemeliharaan',
            'value' => '$data->idJenisPemeliharaan->jenis_pemeliharaan',
        ), 
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),        
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),        
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        array(
            'header' => 'Jumlah (Ha)',
            'name' => 'jumlah',
            'value'=>'number_format($data->jumlah)',
                
        ),
        
	
    )
));
?>

          
          
          
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Pemanenan Non Kayu (HHBK)</h4>
              </div>
          </div>    
         
          
<?php

// print_r("<pre>");
//        print_r($model);
//        print_r("<pre>"); exit(1);
        
        

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-hhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelhhbk->search(),
//    'mergeColumns' => array('tahun', 'id_hasil_hutan_nonkayu_silvikultur','nama_hhbk'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
         array(
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
        ),
        array(
            'name' => 'tahun',
        ),
        array(
            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
            'header' =>'Tata Ruang',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'header' => 'Jenis HHBK',
            'name'   => 'nama_hhbk',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
        ),
        array(
            'name' => 'luas',
            'value'=>'number_format($data->jumlah)',
                
        ),
        array(
            'header' => 'Jumlah',
            'name' => 'jumlah',
            'value'=>'number_format($data->jumlah)',
        ),
    
    )
));
?>        
          
                   <div class="form-group">
              <div style="text-align: left">
                  <h4>Pemasaran Kayu Bulat</h4>
              </div>
          </div>    
         
          
<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-hhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpasar->search(),
//    'mergeColumns' => array('tahun', 'id_hasil_hutan_nonkayu_silvikultur','nama_hhbk'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
         array(
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
        ),
        array(
            'name' => 'tahun',
        ),
//        array(
//            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
//            'header' => 'Tata Ruang',
//            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
//        ),
//        array(
//            'header' => 'Jenis HHBK',
//            'name'   => 'nama_hhbk',
//            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
//        ),
        array(
            'name' => 'luas',
            'value'=>'number_format($data->jumlah)',
                
        ),
        array(
            'header' => 'Jumlah',
            'name' => 'jumlah',
            'value'=>'number_format($data->jumlah)',
        ),
    
    )
));
?>        
          
          
               <div class="form-group">
              <div style="text-align: left">
                  <h4>Pemasaran Non Kayu</h4>
              </div>
          </div>    
         
          
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-pasar-hhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpasarhhbk->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
        
         array(
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
        ),
        array(
            'name' => 'tahun',
        ),
//        array(
//            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
//            'header' => 'Tata Ruang',
//            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
//        ),
//        array(
//            'header' => 'Jenis HHBK',
//            'name'   => 'nama_hhbk',
//            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
//        ),
        array(
            'name' => 'id_jenis_pasar',
            'header' => 'Pemasaran',
            'value' => '$data->idJenisPasar->nama_pemasaran',
        ),
         array(
            'header' => 'Jumlah',
            'name' => 'jumlah',
            'value'=>'number_format($data->jumlah)',
        ),
       
    )
));

}  //end if status
else{
?>   
  <div id="page-wrapper" class="col-md-9">

    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title"><?php echo($msg);?></div>
            </div>
        </div>
    </div>
  </div>
<?php }?>          
          
          
        </div>  
          
          
        <div class="panel-footer">
         
        </div> 

</div>
    
    
    
    
    <div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="panel-title">Kelestarian Fungsi Lingkungan</div>
        </div>
    </div>

    <div class="panel-body">
           <div class="form-group">
              <div style="text-align: left;">
                  <h4>Perlindungan dan Pengamanan Hutan</h4>
              </div>
          </div>
                <?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-perlindungan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelperlindungan->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'rencana',
        ),
        array(
            'name' => 'kegiatan',
        ),
        array(
            'name' => 'keterangan',
        ),
    )
));
                ?>
          <br>
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Pengelolaan dan Pemantauan Lingkungan</h4>
              </div>
          </div>
        <?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-tauling-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpemantauan->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'kegiatan',
        ),
        array(
            'name' => 'keterangan',
        ),
    )
));
        ?>
          
        </div>   
    </div>
    
    
    
        <div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="panel-title">Kelestarian Fungsi Sosial</div>
        </div>
    </div>

    <div class="panel-body">
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kelembagaan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelfungsos->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'rencana',
        ),
        array(
            'name' => 'kegiatan',
        ),
        'keterangan',
    )
));
?>       
        
        </div>   
    </div>
    
    
    


