        <?php
        $this->widget('booster.widgets.HeaderGroupGridView', array(
            'id' => Yii::app()->controller->id . '-rekap-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider' => $model,
            'itemsCssClass' => 'nipz',
            // 'filter' => $model,
            'template' => '{items}',
            'mergeHeaders' => array(
                array(
                    'name' => 'SK Izin',
                    'start' => '5',
                    'end' => '6',
                    'rowspan' => '2'
                ),
                array(
                    'name' => 'Progres Tata Batas',
                    'start' => '7',
                    'end' => '8',
                    'rowspan' => '2'
                ), 
                array(
                    'name' => 'RKU',
                    'start' => '9',
                    'end' => '10',
                    'rowspan' => '2'
                ),                
                array(
                    'name' => 'RKT',
                    'start' => '11',
                    'end' => '18',
                    //'rowspan' => '2'
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
                    'start' => '10',
                    'end' => '11',
                    //'rowspan' => '2'
                ),                
                array(
                    'name' => 'Produksi',
                    'start' => '12',
                    'end' => '14',                    
                ),
                array(
                    'name' => 'Penanaman',
                    'start' => '15',
                    'end' => '17',                    
                ),
            ),
            'columns' => array(
                array('header' => 'No', 'value' => '$row+1'),
                array(
                    'name' => 'nama_perusahaan',
                    'header' => 'Nama Perusahaan',                                    
                    //'rowspan' => '2'
                ),                
                array(
                    'name' => 'provinsi',
                    'header' => 'Provinsi',                                    
                ),                                
                array(
                    'header' => 'Investasi',
                    'name' => 'investasi',
                    'value' => function($data){
                        return number_format($data['investasi'],0,'.', ',');
                    }                    
                ),                
                array(
                    'header' => 'Tenaga Kerja',
                    'name' => 'jml_naker'
                ),                        
                array(
                    'name' => 'no_sk_izin',
                    'header' => 'Nomor',                    
                ),                        
                array(
                    'name' => 'luas_izin',
                    'header' => 'Luas (Ha)',   
                    'value' => function($data){
                        return number_format($data['luas_izin'],2,'.', ',');
                    }
                ),                        
                array(
                    'name' => 'tanggal_tb',
                    'header' => 'Tanggal',                    
                ),
                array(
                    'name' => 'progres_tb',
                    'header' => 'Progres',                    
                ),  
                array(
                    'header' => 'Nomor',
                    'name' => 'sk_rku'
                ),
                array(
                    'header' => 'Tanggal',
                    'name' => 'tgl_sk_rku',
                    'value' => function($data){
                        return TinyHelper::dateIndo($data['tgl_sk_rku']);
                    }
                ),                                                
                array(
                    'header' => 'Nomor',
                    'name' => 'no_sk_rkt'
                ),
                array(
                    'header' => 'Tanggal',
                    'name' => 'tgl_sk_rkt',
                    'value' => function($data){
                        return TinyHelper::dateIndo($data['tgl_sk_rkt']);
                    }                    
                ),
                array(
                    'header' => 'Target',
                    'name' => 'target_produksi',
                    'value' => function($data){
                        return number_format($data['target_produksi'],0,'.', ',');
                    }                                        
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'realisasi_produksi',
                    'value' => function($data){
                        return number_format($data['realisasi_produksi'],0,'.', ',');
                    }                                                            
                ),
                array(
                    'header' => 'Persentase',
                    'name' => 'persentase',
                    'value' => function($data){
                        if($data->realisasi_produksi <> 0) return number_format((($data->realisasi_produksi/$data->target_produksi) * 100),2,'.',',')." %";
                        return 0;
                    }
                ), 
                array(
                    'header' => 'Target',
                    'name' => 'target_penanaman',
                    'value' => function($data){
                        return number_format($data['target_penanaman'],0,'.', ',');
                    }                                                            
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'realisasi_penanaman',
                    'value' => function($data){
                        return number_format($data['realisasi_penanaman'],0,'.', ',');
                    }                                                                                
                ),
                array(
                    'header' => 'Persentase',
                    'name' => 'persentase',
                    'value' => function($data){
                        if($data->realisasi_penanaman > 0) return number_format((($data->realisasi_penanaman/$data->target_penanaman) * 100),2,',','.')." %";
                        return 0;
                    }
                ),                       
                array(
                    'header' => 'Tahun',
                    'name' => 'tahun_phpl'
                ),
                array(
                    'header' => 'Predikat',
                    'name' => 'predikat_phpl'
                ),
                array(
                    'header' => 'Berakhir',
                    'name' => 'berakhir_phpl'
                ),                
                array(
                    'header' => 'Tahun',
                    'name' => 'tahun_vlk'
                ),
                array(
                    'header' => 'Predikat',
                    'name' => 'predikat_vlk'
                ),
                array(
                    'header' => 'Berakhir',
                    'name' => 'berakhir_vlk'
                ),                               
                array(
                    'header' => 'Evaluasi Kinerja',
                    'name' => 'eval',                   
                    'value' => function($data){
                        if(!empty($data['eval']['grade']))
                            return  $data['eval']['grade']." - ".$data['eval']['rekomendasi'];
                    }
                ),                                                       
            ),
        ));
        ?>