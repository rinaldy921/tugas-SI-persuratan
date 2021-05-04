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
                
                $this->widget('booster.widgets.TbGridView',array(
                'id'=>Yii::app()->controller->id . '-dalkar-grid',
                'type' => 'bordered condensed striped',
                'responsiveTable' => true,
                'dataProvider'=>$modelDungtan->searchByRkt(),
                'enableSorting'=>false,
                'template' => '{items}',
                'columns'=>array(
                    array(
                        'name'=>'id_dalkar',
                        'value'=>'$data->idRktLingkunganDungtan->rencana',
                    //    'headerHtmlOptions' => array('class' => 'hidden'),
                        'footer' => '<strong>Total</strong>'
                    ),
                    array(
                        'header'=>'Rencana (Btg)',
                    //    'headerHtmlOptions' => array('class' => 'hidden'),
                        'value'=>'isset($data->idRktLingkunganDungtan->jumlah) ? number_format($data->idRktLingkunganDungtan->jumlah,2,",",".") : "0"',
                        'footer' => '<strong>'.$modelDungtan->getTotal($modelDungtan->searchByRkt()->getData(), 'jumlah').'</strong>'
                    ),
                    array(
                        'header'=>'Realisasi',
                        'value'=>'$data->sd_sekarang',
                        'footer' => '<strong>'.$modelDungtan->getTotal($modelDungtan->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                    ),
                    array(
                        'name'=>'persentase',
                    //    'headerHtmlOptions' => array('class' => 'hidden'),
                        'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                        'footer' => '<strong>'.$modelDungtan->getTotalPersen($modelDungtan->searchByRkt()->getData(), 'persentase').'</strong>',
                    )
                ),
            )); ?>

          <br>
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Pengendalian Hama dan Penyakit</h4>
              </div>
          </div>
        <?php 
        
        $this->widget('booster.widgets.TbGridView',array(
        'id'=>Yii::app()->controller->id . '-dalkar-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider'=>$modelHama->searchByRkt(),
        'enableSorting'=>false,
        'template' => '{items}',
        'columns'=>array(
            array(
                'name'=>'id_dalkar',
                'value'=>'$data->idRktLingkunganDalmakit->rencana',
           //     'headerHtmlOptions' => array('class' => 'hidden'),
                'footer' => '<strong>Total</strong>'
            ),
            array(
                'header'=>'Rencana (Btg)',
            //    'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->idRktLingkunganDalmakit->jumlah) ? number_format($data->idRktLingkunganDalmakit->jumlah,2,",",".") : "0"',
                'footer' => '<strong>'.$modelHama->getTotal($modelHama->searchByRkt()->getData(), 'jumlah').'</strong>'
            ),
            array(
                'header'=>'Realisasi',
                'value'=>'$data->sd_sekarang',
                'footer' => '<strong>'.$modelHama->getTotal($modelHama->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
            ),
            array(
                'name'=>'persentase',
            //     'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                'footer' => '<strong>'.$modelHama->getTotalPersen($modelHama->searchByRkt()->getData(), 'persentase').'</strong>',
            )
        ),
    )); 
}?>
          
          
     <br>
          <div class="form-group">
              <div style="text-align: left">
                  <h4>Pengendalian Kebakaran</h4>
              </div>
          </div>      
          
          
          
          <?php 
            
            $this->widget('booster.widgets.TbGridView',array(
            'id'=>Yii::app()->controller->id . '-dalkar-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider'=>$modelBakar->searchByRkt(),
            'enableSorting'=>false,
            'template' => '{items}',
            'columns'=>array(
                array(
                    'name'=>'id_dalkar',
                    'value'=>'$data->idRktLingkunganDalkar->nama_dalkar',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'footer' => '<strong>Total</strong>'
                ),
                array(
                    'header'=>'Rencana (Btg)',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->idRktLingkunganDalkar->jumlah) ? number_format($data->idRktLingkunganDalkar->jumlah,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelBakar->getTotal($modelBakar->searchByRkt()->getData(), 'jumlah').'</strong>'
                ),
                array(
                    'header'=>'Realisasi',
                    'value'=>'$data->sd_sekarang',
                    'footer' => '<strong>'.$modelBakar->getTotal($modelBakar->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                ),
                array(
                    'name'=>'persentase',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelBakar->getTotalPersen($modelBakar->searchByRkt()->getData(), 'persentase').'</strong>',
                )
            ),
)); ?>
          
          
          
          
        </div>   
    </div>
    
    
    