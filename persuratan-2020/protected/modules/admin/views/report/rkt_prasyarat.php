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
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-naker-tetap-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelSerapan->searchByRkt('1'),
    'enableSorting' => false,
    'mergeColumns' => array( 'is_tenaga_kehutanan','id_jenis_kewarganegaraan'),
    'extraRowTotals' => function($data, $row, &$totals) {
        if (!isset($totals['jumlah']))
            $totals['jumlah'] = 0;
        if (!isset($totals['realisasi']))
            $totals['realisasi'] = 0;
        if (!isset($totals['persentase'])) {
            $totals['persentase'] = 0;
            $totals['pe'] = 0;
        }
        $totals['jumlah'] += $data['idRktSerapanTenagaKerja']['jumlah'];
        $totals['realisasi'] += $data['realisasi'];
        $totals['persentase'] += $data['persentase'];
       
        $totals['pe'] += 1;
    },
    'extraRowPos' => 'below',
    'extraNipzExpression' => '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red text-left\" colspan=\"3\"><strong><i>Sub Total</i></strong></td>
        <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"] > 0 ? ($totals["sd_sekarang"] / $totals["jumlah"]) * 100 : 0,2,",",".")."</td>"
    ',
    'template' => '{items}',
    'columns' => array(
        array(
            'header' => 'Jenis Tenaga Profesional',
            'name' => 'is_tenaga_kehutanan',
            'value' => function ($data) {
                if ($data->idRktSerapanTenagaKerja->is_tenaga_kehutanan == "1") {
                    return "Tenaga Profesional Bidang Kehutanan";
                } else {
                    return "Tenaga Lainnya";
                }
            },
         //   'headerHtmlOptions' => array('class' => 'hidden'),
                'footer' => '<strong>Total</strong>'
        ),
        array(
            'header' => 'Kewarganegaraan',
            'name' => 'id_jenis_kewarganegaraan',
            'value' => '$data->idRktSerapanTenagaKerja->idJenisKewarganegaraan->kewarganegaraan',
       //     'headerHtmlOptions' => array('class' => 'hidden'),
        ),
        array(
            'header' => 'Pendidikan',
            'name' => 'id_pendidikan',
            'value' => '$data->idRktSerapanTenagaKerja->idPendidikan->pendidikan',
       //     'headerHtmlOptions' => array('class' => 'hidden'),
        ),
        array(
            'header' => 'Rencana',
            'value' => 'isset($data->idRktSerapanTenagaKerja->jumlah) ? $data->idRktSerapanTenagaKerja->jumlah : "0"',
            'footer' => '<strong>'.$modelSerapan->getTotal($modelSerapan->searchByRkt('0')->getData(), 'jumlah').'</strong>',
        ),
        
       
        array(
            'header' => 'Realisasi',
            'value' => '$data->sd_sekarang',
            'footer' => '<strong>' . $modelSerapan->getTotal($modelSerapan->searchByRkt('0')->getData(), 'sd_sekarang') . '</strong>'
        ),
                    
        array(
            'header' => 'Persentase',
            'name' => 'persentase',
            'value' => 'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>' . $modelSerapan->getTotalPersen($modelSerapan->searchByRkt('1')->getData(), 'persentase') . '</strong>',
        )
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
   
    $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-bibit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelTataBatas->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
            'header'=>'Tenaga Teknis',
            'value'=>'$data->idRktTataBatas->idJenisBatas->jenis_batas',
            'footer' => '<strong>Total</strong>'
    	),
        array(
            'header'=>'Rencana (Km)',
            'value'=>'isset($data->idRktTataBatas->jumlah) ? number_format($data->idRktTataBatas->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelTataBatas->getTotal($modelTataBatas->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'Realisasi',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelTataBatas->getTotal($modelTataBatas->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'header'=>'Persentase',
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelTataBatas->getTotalPersen($modelTataBatas->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
            
            <br>
        
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Penataan Ruang</h4>
                </div>
            </div>
            
            <strong>a. Kawasan Lindung</strong>
            
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-bibit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelLindung->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
            'header' => 'Jenis Kawasan Lindung',
    		'value'=>'$data->idRktKawasanLindung->idKawasanLindung->nama_jenis',
   		'footer' => '<strong>Total</strong>'
    	),
        array(
            'header'=>'Rencana (Km)',
            'value'=>'isset($data->idRktKawasanLindung->jumlah) ? number_format($data->idRktKawasanLindung->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelLindung->getTotal($modelLindung->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'Realisasi',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelLindung->getTotal($modelLindung->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelLindung->getTotalPersen($modelLindung->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
            
            
            <br>
            <strong>b. Areal Tidak Efektif</strong>
           <?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-bibit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelArealNon->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
            'header' => 'Jenis Areal',
            'value' => '"Areal Tidak Efektif"',
         //  'headerHtmlOptions' => array('class' => 'hidden'),
    		'footer' => '<strong>Total</strong>'
    	),
        array(
            'header'=>'Rencana (Km)',
     //       'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktArealNonProduktif->jumlah) ? number_format($data->idRktArealNonProduktif->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelArealNon->getTotal($modelArealNon->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
       
        array(
            'header'=>'Realisasi',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelArealNon->getTotal($modelArealNon->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'name'=>'persentase',
      //      'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelArealNon->getTotalPersen($modelArealNon->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
            
            
            
            
            <br>
            <strong>c. Areal Efektif</strong>
            
<?php $this->widget('booster.widgets.BootGroupGridView',array(
    'id'=>Yii::app()->controller->id . '-bibit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelArealProduktif->searchByRkt(),
    'enableSorting'=>false,
    //'mergeColumns'=>array('id_blok'),
    //'extraRowColumns'=> array('id_blok'),
    'extraRowTotals'=>function($data, $row, &$totals) {
	     if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
	     if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
	     if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
	     $totals['jumlah'] += $data['idRktArealProduktif']['jumlah'];
	     $totals['realisasi'] += $data['realisasi'];
	     $totals['persentase'] += $data['persentase'];
	     $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
	     $totals['sd_sekarang'] += $data['sd_sekarang'];
	     $totals['pe'] += 1;
	 },
	'extraRowPos' => 'below',
    'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
	    <td class=\"nipz-red\"><strong><i>Sub Total</i></strong></td>
	    <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
	    <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
	    <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
	    <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
	    <td class=\"nipz-red\"></td>"
    ',
    'template' => '{items}',
    'columns'=>array(
        array(
            'header'=>'Jenis Produksi Lahan',
        //    'headerHtmlOptions' => array('class' => 'hidden'),
			'value'=>'$data->idRktArealProduktif->idJenisProduksiLahan->jenis_produksi',
			//'htmlOptions'=>array('style'=>'padding-left:30px'),
            'footer' => '<strong>Total</strong>'
		),
        array(
            'header'=>'Rencana (Km)',
        //    'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktArealProduktif->jumlah) ? number_format($data->idRktArealProduktif->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelArealProduktif->getTotal($modelArealProduktif->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        
        array(
            'header'=>'Realisasi',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelArealProduktif->getTotal($modelArealProduktif->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'name'=>'persentase',
         //   'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelArealProduktif->getTotalPersen($modelArealProduktif->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
            
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Penataan Areal Kerja</h4>
                </div>
            </div>
            
           <?php $this->widget('booster.widgets.BootGroupGridView',array(
            'id'=>Yii::app()->controller->id . '-areal-kerja-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider'=>$modelArealKerja->searchByRkt(),
            'enableSorting'=>false,
            //'mergeColumns'=>array('id_blok'),
            //'extraRowColumns'=> array('id_blok'),
            'extraRowTotals'=>function($data, $row, &$totals) {
                     if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
                     if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
                     if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
                     $totals['jumlah'] += $data['idRktArealKerja']['jumlah'];
                     $totals['realisasi'] += $data['realisasi'];
                     $totals['persentase'] += $data['persentase'];
                     $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
                     $totals['sd_sekarang'] += $data['sd_sekarang'];
                     $totals['pe'] += 1;
                 },
                'extraRowPos' => 'below',
            'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
                    <td class=\"nipz-red\"><strong><i>Sub Total</i></strong></td>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                    <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
                    <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
                    <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
                    <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
                    <td class=\"nipz-red\"></td>"
            ',
            'template' => '{items}',
            'columns'=>array(
                array(
                    'name' => 'daur',
                    'value'=>'$data->idRktArealKerja->daur',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'footer' => '<strong>Total</strong>'
                ),
                array(
                    'header'=>'Unit Kelestarian',
                    'name' => 'id_blok',
                    'value'=>'$data->idRktArealKerja->idBlok->namaSektor->nama_sektor',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'footer' => '<strong>Total</strong>'
                ),
                array(
                    'header'=>'Petak Kerja',
                    'name' => 'id_blok',
                    'value'=>'$data->idRktArealKerja->idBlok->nama_blok',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'footer' => '<strong>Total</strong>'
                ),
                array(
                    'header'=>'Jenis Produksi Lahan',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                                'value'=>'$data->idRktArealKerja->idJenisProduksiLahan->jenis_produksi',
                                'htmlOptions'=>array('style'=>'padding-left:30px'),
                        ),
                array(
                    'header'=>'Rencana (Km)',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->idRktArealKerja->jumlah) ? number_format($data->idRktArealKerja->jumlah,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelArealKerja->getTotal($modelArealKerja->searchByRkt()->getData(), 'jumlah').'</strong>',
                ),
                array(
                    'header'=>'Realisasi',
                    'value'=>'$data->sd_sekarang',
                    'footer' => '<strong>'.$modelArealKerja->getTotal($modelArealKerja->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                ),
                array(
                    'name'=>'persentase',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelArealKerja->getTotalPersen($modelArealKerja->searchByRkt()->getData(), 'persentase').'</strong>',
                )
            ),
        )); ?>
            <br>
                                 
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Pemasukan & Penggunaan Peralatan</h4>
                 </div>
            </div>
            <?php
            
            $this->widget('booster.widgets.BootGroupGridView',array(
            'id'=>Yii::app()->controller->id . '-bibit-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider'=>$modelPWH->searchByRkt(),
            'enableSorting'=>false,
            'extraRowTotals'=>function($data, $row, &$totals) {
                     if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
                     if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
                     if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
                     $totals['jumlah'] += $data['idRktPwh']['jumlah'];
                     $totals['realisasi'] += $data['realisasi'];
                     $totals['persentase'] += $data['persentase'];
                     $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
                     $totals['sd_sekarang'] += $data['sd_sekarang'];
                     $totals['pe'] += 1;
                 },
                'extraRowPos' => 'below',
            'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
                    <td class=\"nipz-red\"><strong><i>Sub Total</i></strong></td>
                    <td>&nbsp;</td>
                    <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
                    <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
                    <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
                    <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
                    <td class=\"nipz-red\"></td>"
            ',
            'template' => '{items}',
            'columns'=>array(
                array(
                    'header' => 'Jenis Pembukaan',
                    'value'=>'$data->idRktPwh->idPwh->jenis_pembukaan',
               //     'headerHtmlOptions' => array('class' => 'hidden'),
                        'footer' => '<strong>Total</strong>'
                ),
                array(
                    'header'=>'Rencana (Km)',
               //     'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->idRktPwh->jumlah) ? number_format($data->idRktPwh->jumlah,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelPWH->getTotal($modelPWH->searchByRkt()->getData(), 'jumlah').'</strong>',
                ),
               
                
                array(
                    'header'=>'Realisasi',
                    'value'=>'$data->sd_sekarang',
                    'footer' => '<strong>'.$modelPWH->getTotal($modelPWH->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                ),
                array(
                    'name'=>'persentase',
                //    'headerHtmlOptions' => array('class' => 'hidden'),
                    'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelPWH->getTotalPersen($modelPWH->searchByRkt()->getData(), 'persentase').'</strong>',
                )
            ),
        )); ?>
            <br>
                                         
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Pengadaan Sarpras</h4>
                </div>
            </div>
          <?php 
                $this->widget('booster.widgets.BootGroupGridView',array(
                'id'=>Yii::app()->controller->id . '-bibit-grid',
                'type' => 'bordered condensed striped',
                'responsiveTable' => true,
                'dataProvider'=>$modelAlat->searchByRkt(),
                'enableSorting'=>false,
                'extraRowTotals'=>function($data, $row, &$totals) {
                         if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
                         if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
                         if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
                         $totals['jumlah'] += $data['idRktMasukGunaAlat']['jumlah'];
                         $totals['realisasi'] += $data['realisasi'];
                         $totals['persentase'] += $data['persentase'];
                         $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
                         $totals['sd_sekarang'] += $data['sd_sekarang'];
                         $totals['pe'] += 1;
                     },
                    'extraRowPos' => 'below',
                'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
                        <td class=\"nipz-red\"><strong><i>Sub Total</i></strong></td>
                        <td>&nbsp;</td>
                        <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
                        <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
                        <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
                        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
                        <td class=\"nipz-red\"></td>"
                ',
                'template' => '{items}',
                'columns'=>array(
                    array(
                        'header' => 'Jenis Peralatan',
                        'value'=>'$data->idRktMasukGunaAlat->nama_peralatan',
                   //     'headerHtmlOptions' => array('class' => 'hidden'),
                            'footer' => '<strong>Total</strong>'
                    ),
                    array(
                        'header'=>'Rencana (Km)',
                    //    'headerHtmlOptions' => array('class' => 'hidden'),
                        'value'=>'isset($data->idRktMasukGunaAlat->jumlah) ? number_format($data->idRktMasukGunaAlat->jumlah,2,",",".") : "0"',
                        'footer' => '<strong>'.$modelAlat->getTotal($modelAlat->searchByRkt()->getData(), 'jumlah').'</strong>',
                    ),
                  
                    
                    array(
                        'header'=>'Realisasi',
                        'value'=>'$data->sd_sekarang',
                        'footer' => '<strong>'.$modelAlat->getTotal($modelAlat->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                    ),
                    array(
                        'name'=>'persentase',
                    //    'headerHtmlOptions' => array('class' => 'hidden'),
                        'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                        'footer' => '<strong>'.$modelAlat->getTotalPersen($modelAlat->searchByRkt()->getData(), 'persentase').'</strong>',
                    )
                ),
            )); ?>
            <br>
                                                 
            <div class="form-group">
                <div style="text-align: left">
                    <h4>Pembukaan Wilayah Hutan</h4>
                </div>
            </div>
            <?php 
            
            $this->widget('booster.widgets.BootGroupGridView',array(
            'id'=>Yii::app()->controller->id . '-bibit-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider'=>$modelSarpras->searchByRkt(),
            'enableSorting'=>false,
            'extraRowTotals'=>function($data, $row, &$totals) {
	     if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
	     if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
	     if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
	     $totals['jumlah'] += $data['idRktSarpras']['jumlah'];
	     $totals['realisasi'] += $data['realisasi'];
	     $totals['persentase'] += $data['persentase'];
	     $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
	     $totals['sd_sekarang'] += $data['sd_sekarang'];
	     $totals['pe'] += 1;
	 },
	'extraRowPos' => 'below',
    'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
	    <td class=\"nipz-red\"><strong><i>Sub Total</i></strong></td>
	    <td>&nbsp;</td>
	    <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
	    <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
	    <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
	    <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
	    <td class=\"nipz-red\"></td>"
    ',
    'template' => '{items}',
    'columns'=>array(
        array(
            'header' => 'Jenis Sarpras',
            'value'=>'$data->idRktSarpras->nama_sarpras',
       //     'headerHtmlOptions' => array('class' => 'hidden'),
    		'footer' => '<strong>Total</strong>'
    	),
        array(
            'header'=>'Rencana (Unit/Ha)',
        //    'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktSarpras->jumlah) ? number_format($data->idRktSarpras->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelSarpras->getTotal($modelSarpras->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
       
        
        array(
            'header'=>'Realisasi',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelSarpras->getTotal($modelSarpras->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'name'=>'persentase',
        //    'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelSarpras->getTotalPersen($modelSarpras->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); 
}
?>

        </div>   
    </div>
</div>
    