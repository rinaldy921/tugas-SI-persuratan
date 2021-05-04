<?php
$this->breadcrumbs = array(
    'Rekapitulasi Kinerja'
);


?>
<input type="hidden" id="thn-report" value="<?=$_tahun;?>" />
<input type="hidden" id="prov-report" value="<?=$_provinsi;?>" />
<div id="page-wrapper" class="col-md-12">
        <h3>Data Rekapitulasi Kinerja Per Tahun</h3>
        <h4>Di Provinsi : <?= $propinsi; ?></h4>
        <h4>Tahun : <?=$tahun; ?></h4>
        <h4>&nbsp</h4>
        
        
        
    <div id="data" style="width: 100%; height: 100%; overflow: auto; alignment-adjust: central">
        <?php
        $this->widget('booster.widgets.HeaderGroupGridView', array(
            'id' => 'rekap-rekap-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider' => $model,
            'itemsCssClass' => 'nipz',
            // 'filter' => $model,
            'template' => '{items}',
            'mergeHeaders' => array(
                array(
                    'name' => 'SK Izin',
                    'start' => '2',
                    'end' => '3',
                    'rowspan' => '2',
                ),
                array(
                    'name' => 'Progres Tata Batas',
                    'start' => '4',
                    'end' => '5',
                    'rowspan' => '2'
                ), 
                array(
                    'name' => 'RKU',
                    'start' => '6',
                    'end' => '7',
                    'rowspan' => '2'
                ),                
                array(
                    'name' => 'RKT',
                    'start' => '8',
                    'end' => '15',
                    //'rowspan' => '2'
                ),               
                array(
                    'name' => 'Penanaman 5 Tahun Terkahir',
                    'start' => '16',
                    'end' => '18',
                    'rowspan' => '2'
                ),
                
                array(
                    'name' => 'Sertifikasi PHPL',
                    'start' => '19',
                    'end' => '21',
                    'rowspan' => '2'
                ),                
                array(
                    'name' => 'Sertifikasi VLK',
                    'start' => '22',
                    'end' => '24',
                    'rowspan' => '2'
                ),                                
            ),
            'subHeaders' => array(
                array(
                    'name' => 'SK',
                    'start' => '8',
                    'end' => '9',
                    //'rowspan' => '2'
                ),                
                array(
                    'name' => 'Produksi',
                    'start' => '10',
                    'end' => '12',                    
                ),
                array(
                    'name' => 'Penanaman',
                    'start' => '13',
                    'end' => '15',                    
                ),
            ),
            'columns' => array(
                array(
                    'header' => 'No', 
                    'value' => '$row+1',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    ),
                array(
                    'name' => 'nama_perusahaan',
                    'header' => 'Nama Perusahaan',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'footer' => '<strong>'.'Total'.'</strong>',
                    'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),                
//                array(
//                    'name' => 'provinsi',
//                    'header' => 'Provinsi',
//                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//                ),                                
//                array(
//                    'header' => 'Investasi',
//                    'name' => 'investasi',
//                    'value' => function($data){
//                        return number_format($data['investasi'],0,'.', ',');
//                    }                    
//                ),                
//                array(
//                    'header' => 'Tenaga Kerja',
//                    'name' => 'jml_naker'
//                ),                        
                array(
                    'name' => 'no_sk_izin',
                    'header' => 'Nomor',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),                    
                ),                        
                array(
                    'name' => 'luas_izin',
                    'header' => 'Luas (Ha)',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                        return number_format($data['luas_izin'],2,'.', ',');
                    }
                ),                        
                array(
                    'name' => 'tanggal_tb',
                    'header' => 'Tanggal',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),
                array(
                    'name' => 'progres_tb',
                    'header' => 'Progres',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),    
                ),  
                array(
                    'header' => 'Nomor',
                    'name' => 'sk_rku',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),
                array(
                    'header' => 'Tanggal',
                    'name' => 'tgl_sk_rku',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'value' => function($data){
                        return TinyHelper::dateIndo($data['tgl_sk_rku']);
                    }
                ),                                                
                array(
                    'header' => 'Nomor',
                    'name' => 'no_sk_rkt',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),
                array(
                    'header' => 'Tanggal',
                    'name' => 'tgl_sk_rkt',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'value' => function($data){
                        return TinyHelper::dateIndo($data['tgl_sk_rkt']);
                    }                    
                ),
                array(
                    'header' => 'Target',
                    'name' => 'target_produksi',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                        return number_format($data['target_produksi'],0,'.', ',');
                    }                                        
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'realisasi_produksi',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                        return number_format($data['realisasi_produksi'],0,'.', ',');
                    }                                                            
                ),
                array(
                    'header' => 'Persentase',
                    'name' => 'persentase',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                        if($data->realisasi_produksi <> 0) return number_format((($data->realisasi_produksi/$data->target_produksi) * 100),2,'.',',')." %";
                        return 0;
                    }
                ), 
                array(
                    'header' => 'Target',
                    'name' => 'target_penanaman',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                        return number_format($data['target_penanaman'],0,'.', ',');
                    }                                                            
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'realisasi_penanaman',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                        return number_format($data['realisasi_penanaman'],0,'.', ',');
                    }                                                                                
                ),
                array(
                    'header' => 'Persentase',
                    'name' => 'persentase',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                        if($data->realisasi_penanaman > 0) return number_format((($data->realisasi_penanaman/$data->target_penanaman) * 100),2,',','.')." %";
                        return 0;
                    }
                ),  
                        
                                        array(
                    'header' => 'Target',
                    'name' => 'penanaman_rencana',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                      //  print_r($data);
                        
                            return $data['penanaman_rencana'];
                    }                                                            
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'penanaman_realisasi',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                      //  print_r($data);
                        
                            return $data['penanaman_realisasi'];
                    }                                                                                
                ),
                array(
                    'header' => 'Persentase',
                    'name' => 'penanaman_persentase',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'htmlOptions' => array('style' => 'text-align:right'),
                    'value' => function($data){
                      //  print_r($data);
                        
                            return $data['penanaman_persentase'];
                    }
                ),  
                        
                        
                array(
                    'name' => 'ganis_kriteria',
                    'header' => 'Persentase Realisasi Ganis PHPL',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),  
                    'value' => function($data){
                      //  print_r($data);
                        
                            return $data['ganis_kriteria'];
                      
                        
                    }
                    
                    ,
                                                                           
                ),  
                array(
                    'header' => 'Tahun',
                    'name' => 'tahun_phpl',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),
                array(
                    'header' => 'Predikat',
                    'name' => 'predikat_phpl',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),
                array(
                    'header' => 'Berakhir',
                    'name' => 'berakhir_phpl',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),                
                array(
                    'header' => 'Tahun',
                    'name' => 'tahun_vlk',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),
                array(
                    'header' => 'Predikat',
                    'name' => 'predikat_vlk',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),
                array(
                    'header' => 'Berakhir',
                    'name' => 'berakhir_vlk',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),                               
                array(
                    'header' => 'Kriteria',
                    'name' => 'eval',   
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                    'value' => function($data){
                        if(!empty($data['eval']['grade']))
                            return  $data['eval']['grade']." - ".$data['eval']['rekomendasi'];
                    }
                ),
                array(
                    'header' => 'Status Operasional',
                    'name' => '-',
                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                ),  
            ),
        ));
        ?>
        <div>&nbsp;</div>
        <div align="right">Tanggal Cetak : <?php echo(Yii::app()->controller->getDateMonth(date("Y/m/d") )); ?></div>
        <h5 style="font-style: italic">http://sehati.menlhk.go.id</h5>
    </div>
</div>
