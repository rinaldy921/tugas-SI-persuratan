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
                <div class="panel-title">Kelestarian Fungsi Produksi</div>
            </div>
        </div>
          
      <div class="panel-body">
          
          <div class="form-group">
              <div class="col-sm-3" style="text-align: left">
                  <h3>Pengadaan Bibit</h3>
              </div>
          </div>    
         
          
      <?php
    
      
    $this->widget('booster.widgets.BootGroupGridView', array(
                'id'=>'rkt-pembenihan-grid',
                //'id' => 'pembibitan-grid',
                'type' => 'bordered condensed striped',
                'responsiveTable' => true,
                'dataProvider' => $modelbibit,
                'template' => '{items}{pager}',
             //   'mergeColumns'=>array('bulan'),
                'enableSorting' => false,
            
                'columns' => array(
                    array(
                        'header' => 'Daur',
                        'name' => 'daur',
                        'value'=> '$data["daur"]',
                    ),
                     array(
                        'header' => 'Unit Kelestarian',
                        'name' => 'sektor',
                        'value'=>'$data["sektor"]',
                    ),
                    array(
                        'header' => 'Petak Kerja',
                        'name' => 'blok',
                        'value'=>'$data["blok"]',
                    ),
                    array(
                        'header' => 'Jenis Lahan',
                        'name' => 'jenislahan',
                         'value'=>'$data["jenislahan"]',
                    ),
                     array(
                        'header' => 'Jenis Tanaman',
                        'name' => 'jenistanaman',
                         'value'=>'$data["jenistanaman"]',
                    ),
                    array(
                        'header' => 'Rencana (Btg)',
                        'name' => 'target',
                         'value'=>'$data["target"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi(Btg)',
                        'name' => 'realisasi',
                         'value'=>'$data["realisasi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasi"]/$data["target"] * 100',
                    ),
                    
                                  
                )
            ));
?>
          
       
          <div class="form-group">
              <div class="col-sm-3" style="text-align: left">
                  <h3>Penyiapan Lahan</h3>
              </div>
          </div>    
         
          
      <?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-siaplahan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
  //  'mergeColumns' => array('daur','rkt_ke', 'tahun', 'sektor','blok', 'id_tanaman_silvikultur'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_lahan', 'id_jenis_produksi_lahan','sektor','blok'),
    'dataProvider' => $modelsiaplahan,
    'mergeColumns' => array('daur', 'sektor','blok'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    
    'columns' => array(
                    array(
                        'header' => 'Daur',
                        'name' => 'daur',
                        'value'=> '$data["daur"]',
                    ),
                     array(
                        'header' => 'Unit Kelestarian',
                        'name' => 'sektor',
                        'value'=>'$data["sektor"]',
                    ),
                    array(
                        'header' => 'Petak Kerja',
                        'name' => 'blok',
                        'value'=>'$data["blok"]',
                    ),
                    array(
                        'header' => 'Tata Ruang',
                        'name' => 'jenisproduksilahan',
                         'value'=>'$data["jenisproduksilahan"]',
                    ),
                     array(
                        'header' => 'Jenis Lahan',
                        'name' => 'jenislahan',
                         'value'=>'$data["jenislahan"]',
                    ),
                    array(
                        'header' => 'Rencana (Ha)',
                        'name' => 'target',
                         'value'=>'$data["target"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi(Ha)',
                        'name' => 'realisasi',
                         'value'=>'$data["realisasi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasi"]/$data["target"] * 100',
                    ),
       
    )
));
?>
          
          
          <div class="form-group">
              <div class="col-sm-3" style="text-align: left">
                  <h3>Penanaman</h3>
              </div>
          </div>    
         
          
  <?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-penanaman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modeltanam,
    'template' => '{items}{pager}',
    'enableSorting' => false,
      'mergeColumns' => array('daur', 'sektor','blok'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_produksi_lahan','sektor','blok'),
    //'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
     'columns' => array(
                    array(
                        'header' => 'Daur',
                        'name' => 'daur',
                        'value'=> '$data["daur"]',
                    ),
                     array(
                        'header' => 'Unit Kelestarian',
                        'name' => 'sektor',
                        'value'=>'$data["sektor"]',
                    ),
                    array(
                        'header' => 'Petak Kerja',
                        'name' => 'blok',
                        'value'=>'$data["blok"]',
                    ),
                    array(
                        'header' => 'Tata Ruang',
                        'name' => 'jenisproduksilahan',
                         'value'=>'$data["jenisproduksilahan"]',
                    ),
                    array(
                        'header' => 'Jenis Lahan',
                        'name' => 'jenislahan',
                         'value'=>'$data["jenislahan"]',
                    ),
                     array(
                        'header' => 'Jenis Tanaman',
                        'name' => 'jenistanaman',
                         'value'=>'$data["jenistanaman"]',
                    ),
                    array(
                        'header' => 'Rencana (Ha)',
                        'name' => 'target',
                         'value'=>'$data["target"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi(Ha)',
                        'name' => 'realisasi',
                         'value'=>'$data["realisasi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasi"]/$data["target"] * 100',
                    ),
        
    )
));
?>
          
          <div class="form-group">
              <div class="col-sm-3" style="text-align: left">
                  <h3>Pemeliharaan</h3>
              </div>
          </div>    
         
          
 <?php
 
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' =>  Yii::app()->controller->id . '-pemeliharaan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpelihara,
//    'mergeColumns' => array('daur','rkt_ke', 'tahun', 'jenis_pemeliharaan' ,'id_jenis_lahan', 'id_jenis_produksi_lahan','sektor','blok'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
                    array(
                        'header' => 'Daur',
                        'name' => 'daur',
                        'value'=> '$data["daur"]',
                    ),
                     array(
                        'header' => 'Unit Kelestarian',
                        'name' => 'sektor',
                        'value'=>'$data["sektor"]',
                    ),
                    array(
                        'header' => 'Petak Kerja',
                        'name' => 'blok',
                        'value'=>'$data["blok"]',
                    ),
                    array(
                        'header' => 'Tata Ruang',
                        'name' => 'jenisproduksilahan',
                         'value'=>'$data["jenisproduksilahan"]',
                    ),
                     array(
                        'header' => 'Jenis Lahan',
                        'name' => 'jenislahan',
                         'value'=>'$data["jenislahan"]',
                    ),
                    array(
                        'header' => 'Jenis Pemeliharaan',
                        'name' => 'jenispelihara',
                         'value'=>'$data["jenispelihara"]',
                    ),
                    array(
                        'header' => 'Rencana (Ha)',
                        'name' => 'target',
                         'value'=>'$data["target"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi(Ha)',
                        'name' => 'realisasi',
                         'value'=>'$data["realisasi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasi"]/$data["target"] * 100',
                    ),
        
	
    )
)); 
  
?>
          

          
          <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h3>Pemanenan Kayu Bulat</h3>
              </div>
          </div>    
         
          
 <?php
    $this->widget('booster.widgets.BootGroupGridView', array(
        'id' => 'rku-pemeliharaan-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $modelpanenkayu,
    //    'mergeColumns' => array('daur','rkt_ke', 'tahun', 'jenis_pemeliharaan' ,'id_jenis_lahan', 'id_jenis_produksi_lahan','sektor','blok'),
        'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
        'template' => '{items}',
        'enableSorting' => false,
        'columns' => array(
           array(
                        'header' => 'Daur',
                        'name' => 'daur',
                        'value'=> '$data["daur"]',
                    ),
                     array(
                        'header' => 'Unit Kelestarian',
                        'name' => 'sektor',
                        'value'=>'$data["sektor"]',
                    ),
                    array(
                        'header' => 'Petak Kerja',
                        'name' => 'blok',
                        'value'=>'$data["blok"]',
                    ),
                    array(
                        'header' => 'Tata Ruang',
                        'name' => 'jenisproduksilahan',
                         'value'=>'$data["jenisproduksilahan"]',
                    ),
                     array(
                        'header' => 'Jenis Lahan',
                        'name' => 'jenislahan',
                         'value'=>'$data["jenislahan"]',
                    ),
                   
                    array(
                        'header' => 'Rencana (Ha)',
                        'name' => 'targetluas',
                         'value'=>'$data["targetluas"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi(Ha)',
                        'name' => 'realisasiluas',
                         'value'=>'$data["realisasiluas"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasiluas"]/$data["targetluas"] * 100',
                    ),
            
                    array(
                        'header' => 'Rencana (m3)',
                        'name' => 'targetproduksi',
                         'value'=>'$data["targetproduksi"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi(m3)',
                        'name' => 'realisasiproduksi',
                         'value'=>'$data["realisasiproduksi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentaseproduksi',
                         'value'=>'$data["realisasiproduksi"]/$data["targetproduksi"] * 100',
                    ),


        )
    ));
?>

          
          
          
          <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h3>Pemanenan Non Kayu (HHBK)</h3>
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
    'dataProvider' => $modelhhbk,
//    'mergeColumns' => array('tahun', 'id_hasil_hutan_nonkayu_silvikultur','nama_hhbk'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
         array(
                        'header' => 'Tata Ruang',
                        'name' => 'jenislahan',
                        'value'=> '$data["jenislahan"]',
                    ),
                    array(
                        'header' => 'Produk HHBK',
                        'name' => 'nama_hhbk',
                        'value'=> '$data["nama_hhbk"]',
                    ),
                    
                   
                    array(
                        'header' => 'Rencana',
                        'name' => 'target',
                         'value'=>'$data["target"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi',
                        'name' => 'realisasi',
                         'value'=>'$data["realisasi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasi"]/$data["target"] * 100',
                    ),
    
    )
));
?>        
          
                   <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h3>Pemasaran Kayu Bulat</h3>
              </div>
          </div>    
         
          
<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-pasar-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpasar,
//    'mergeColumns' => array('tahun', 'id_hasil_hutan_nonkayu_silvikultur','nama_hhbk'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(
                    array(
                        'header' => 'Daur',
                        'name' => 'daur',
                        'value'=> '$data["daur"]',
                    ),
                    
                    array(
                        'header' => 'Jenis Pemasaran',
                        'name' => 'jenispemasaran',
                         'value'=>'$data["jenispemasaran"]',
                    ),
                    
                   
                    array(
                        'header' => 'Rencana (M3)',
                        'name' => 'target',
                         'value'=>'$data["target"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi(M3)',
                        'name' => 'realisasi',
                         'value'=>'$data["realisasi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasi"]/$data["target"] * 100',
                    ),
            
                    
    
    )
));
?>        
          
          
               <div class="form-group">
              <div class="col-sm-9" style="text-align: left">
                  <h3>Pemasaran Non Kayu</h3>
              </div>
          </div>    
         
          
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-pasar-hhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelpasarhhbk,
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'columns' => array(

                    array(
                        'header' => 'Tata Ruang',
                        'name' => 'jenislahan',
                        'value'=> '$data["jenislahan"]',
                    ),
                    array(
                        'header' => 'Produk HHBK',
                        'name' => 'nama_hhbk',
                        'value'=> '$data["nama_hhbk"]',
                    ),
                    
                    array(
                        'header' => 'Jenis Pemasaran',
                        'name' => 'jenispemasaran',
                         'value'=>'$data["jenispemasaran"]',
                    ),
                    
                   
                    array(
                        'header' => 'Rencana',
                        'name' => 'target',
                         'value'=>'$data["target"]',
                       
                    ),
                     array(
                        'header' => 'Realisasi',
                        'name' => 'realisasi',
                         'value'=>'$data["realisasi"]',
                       
                    ),
                    array(
                        'header' => 'Persentase (%)',
                        'name' => 'persentase',
                         'value'=>'$data["realisasi"]/$data["target"] * 100',
                    ),
       
    )
));
//
//}  //end if status
//else{
?>   
  
<?php }?>          
          
          
        </div>  
          
     
</div>
    
    
     
    
    
    
    
   
    
    
    


