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
                <div class="panel-title">Realisasi Rencana Kerja Tahunan (RKT) Tahun : <?=$tahun ;?> s/d Bulan : <?=$bulan; ?></div>
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
                array(
                    'name' => 'Nomor SK RKT',
                    'header' => 'Nomor SK RKT',
                    'value' => function($data) {
                        return $data->nomor_sk;
                    }
                ),
                array(
                    'name' => 'Tanggal SK RKT',
                    'header' => 'Tanggal SK RKT',
                    'value' => function($data) {
                        return $data->tanggal_sk;
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
                <div class="panel-title">Kelestarian Fungsi Sosial</div>
            </div>
        </div>
          
      <div class="panel-body">
          
          <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h4>Pembangunan Penyaluran Infrastruktur Pemukiman</h4>
              </div>
          </div>    
         
        <?php 
        
            $this->widget('booster.widgets.TbGridView',array(
            'id'=>Yii::app()->controller->id . '-inframukim-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider'=>$modelInfra->searchByRkt(),
            'enableSorting'=>false,
            'template' => '{items}',
            'columns'=>array(
                array(
                        'header'=>'Jenis',
                        'name'=>'id_infra_mukim',
                        'value'=>'$data->idRktInfraMukim->idInfraMukim->nama_sarana',
                    //    'headerHtmlOptions' => array('class' => 'hidden'),
                        'footer' => '<strong>Total</strong>'
                ),
                array(
                    'header'=>'Rencana (Unit)',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'$data->idRktInfraMukim->jumlah',
                    'footer' => '<strong>'.$modelInfra->getTotal($modelInfra->searchByRkt()->getData(), 'jumlah').'</strong>',
                ),
              
                array(
                    'header'=>'Realisasi (Unit)',
                    'value'=>'$data->sd_sekarang',
                    'footer' => '<strong>'.$modelInfra->getTotal($modelInfra->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                ),
                array(
                    'name'=>'persentase (%)',
                 //   'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelInfra->getTotal($modelInfra->searchByRkt()->getData(), 'persentase').'</strong>',
                )
            ),
        )); ?>  
      
          
            <br><br>
          <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h4>Peningkatan Sumber Daya Manusia</h4>
              </div>
          </div>    
         
          
      <?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-sdm-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelSDM->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
    	array(
                'header'=>'Jenis',
    		'name'=>'id_infra_mukim',
    		'value'=>'$data->idRktPeningkatanSdm->idPeningkatanSdm->nama_program',
             //   'headerHtmlOptions' => array('class' => 'hidden'),
    		'footer' => '<strong>Total</strong>'
    	),
        array(
            'header'=>'Rencana (Unit)',
        //    'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktPeningkatanSdm->jumlah',
            'footer' => '<strong>'.$modelSDM->getTotal($modelSDM->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
       
        array(
            'header'=>'Realisasi',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelSDM->getTotal($modelSDM->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
    	array(
            'name'=>'persentase (%)',
       //     'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelSDM->getTotal($modelSDM->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
          
          <br><br>
          <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h4>Kerjasama Koperasi</h4>
              </div>
          </div>    
         
          
          <?php 
            $this->widget('booster.widgets.TbGridView',array(
            'id'=>Yii::app()->controller->id . '-kerjasama-koperasi-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider'=>$modelKoperasi->searchByRkt(),
            'enableSorting'=>false,
            'template' => '{items}',
            'columns'=>array(
                array(
                    'header'=>'Rencana (Unit)',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'$data->idRktKerjasamaKoperasi->jumlah',
                    'footer' => '<strong>'.$modelKoperasi->getTotal($modelKoperasi->searchByRkt()->getData(), 'jumlah').'</strong>',
                ),
        
                array(
                    'header'=>'Realisasi',
                    'value'=>'$data->sd_sekarang',
                    'footer' => '<strong>'.$modelKoperasi->getTotal($modelKoperasi->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                ),
                array(
                    'name'=>'persentase (%)',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelKoperasi->getTotal($modelKoperasi->searchByRkt()->getData(), 'persentase').'</strong>',
                )
            ),
        )); ?>
          
          
          
          
          
          <br><br>
          <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h4>Kemitraan Usaha</h4>
              </div>
          </div>    
         
          <?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-bangun-mitra-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelMitra->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
            'header'=>'Rencana (Unit)',
          //  'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktBangunMitra->jumlah',
            'footer' => '<strong>'.$modelMitra->getTotal($modelMitra->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'Realisasi (Unit)',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelMitra->getTotal($modelMitra->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
    	array(
            'name'=>'persentase (%)',
            //'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelMitra->getTotal($modelMitra->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
          
          
          
          
          <br><br>
            <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h4>Penanganan Konflik Sosial</h4>
              </div>
          </div>    
         
          
        <div class="grid-view">
            <table class="items table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis Konflik</th>
                        <th>Penanganan</th>
                        <th>Status</th>
                        <th>Persentase (%)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                
//                        print_r("<pre>");
//                        print_r($modelRealisasi);
//                        print_r("<pre>"); die();
                        
                    if(count($modelRealisasi->search()->getData()) > 0): ?>
                    <?php 
                       
                    
                        foreach($modelRealisasi->search()->getData() as $key => $value): ?>
                        <?php
                            $modRealisasi = RealisasiRktKonflikSosial::model()->findByPk($value['id']);
                            $endpoint = Yii::app()->createUrl('//perusahaan/realisasiKonflikSosial/inputRealisasi');
                        ?>
                        <tr>
                            <td><?=$key+1;?></td>
                            <td><?=$modRealisasi->idRktKonflikSosial->jenis_konflik;?></td>
                            <td>
                                <?php $this->widget(
                                    'booster.widgets.TbEditableField',
                                    array(
                                        'type' => 'textarea',
                                        'model' => $modRealisasi,
                                        'attribute' => 'penanganan',
                                        'url' => $endpoint,
                                    )
                                );?>
                            <td>
                                <?php $this->widget(
                                    'booster.widgets.TbEditableField',
                                    array(
                                        'type' => 'text',
                                        'model' => $modRealisasi,
                                        'attribute' => 'status',
                                        'url' => $endpoint,
                                    )
                                );?>
                            </td>
                            <td>
                                <?php $this->widget(
                                    'booster.widgets.TbEditableField',
                                    array(
                                        'type' => 'text',
                                        'model' => $modRealisasi,
                                        'attribute' => 'persentase',
                                        'url' => $endpoint,
                                    )
                                );?>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
<?php }?>          
          
          
        </div>  
          
     
</div>
    
    
     
    
    
    
    
   
    
    
    


