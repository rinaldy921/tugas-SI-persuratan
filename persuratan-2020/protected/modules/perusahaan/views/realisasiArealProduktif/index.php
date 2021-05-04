<style media="screen">
    #<?php echo Yii::app()->controller->id ?>-bibit-grid th{
        text-align: center;
    }
</style>

<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Produksi Lahan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (Ha)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi (Ha)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-bibit-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Penataan Ruang',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<center><h3>Areal Efektif</h3></center>


<?php 

    if($status_laporan == 0){  

                    $this->widget('booster.widgets.BootGroupGridView',array(
                    'id'=>Yii::app()->controller->id . '-bibit-grid',
                    'type' => 'bordered condensed striped',
                    'responsiveTable' => true,
                    'dataProvider'=>$modelBibit->searchByRkt(),
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
                            'headerHtmlOptions' => array('class' => 'hidden'),
                                        'value'=>'$data->idRktArealProduktif->idJenisProduksiLahan->jenis_produksi',
                                        //'htmlOptions'=>array('style'=>'padding-left:30px'),
                            'footer' => '<strong>Total</strong>'
                                ),
                        array(
                            'header'=>'Rencana (Km)',
                            'headerHtmlOptions' => array('class' => 'hidden'),
                            'value'=>'isset($data->idRktArealProduktif->jumlah) ? number_format($data->idRktArealProduktif->jumlah,2,",",".") : "0"',
                            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'jumlah').'</strong>',
                        ),
                        array(
                            'header'=>'sd Bulan Lalu',
                            'value'=>'$data->sd_bulan_lalu',
                            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>',
                        ),
                        array(
                            'header'=>'Bulan Ini',
                                'class'=>'booster.widgets.TbEditableColumn',
                                'name'=>'realisasi',
                                'type'=>'raw',
                                'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
                                'editable'=> array(
                                'url'=>$this->createUrl('//perusahaan/realisasiArealProduktif/inputJumlahRealisasi'),
                //    			'success'=>'js:function(){
                ////                            $.fn.yiiGridView.update("-bibit-grid");
                //                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-bibit-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
                //                        setTimeout(function(){
                //                            generateTable();
                //                        }, 100)
                //                    }});
                //                }'
                                ),
                                'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'realisasi').'</strong>',
                        ),
                        array(
                            'header'=>'sd Bulan Ini',
                            'value'=>'$data->sd_sekarang',
                            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                        ),
                        array(
                            'name'=>'persentase',
                            'headerHtmlOptions' => array('class' => 'hidden'),
                            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                            'footer' => '<strong>'.$modelBibit->getTotalPersen($modelBibit->searchByRkt()->getData(), 'persentase').'</strong>',
                        )
                    ),
                )); 
                         
    }else{
          echo "<h5> .: Laporan Telah Dikirimkan dan Telah di Setujui Atasan UM</h5>";
          
           $this->widget('booster.widgets.BootGroupGridView',array(
                    'id'=>Yii::app()->controller->id . '-bibit-grid',
                    'type' => 'bordered condensed striped',
                    'responsiveTable' => true,
                    'dataProvider'=>$modelBibit->searchByRkt(),
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
                            'headerHtmlOptions' => array('class' => 'hidden'),
                                        'value'=>'$data->idRktArealProduktif->idJenisProduksiLahan->jenis_produksi',
                                        //'htmlOptions'=>array('style'=>'padding-left:30px'),
                            'footer' => '<strong>Total</strong>'
                                ),
                        array(
                            'header'=>'Rencana (Km)',
                            'headerHtmlOptions' => array('class' => 'hidden'),
                            'value'=>'isset($data->idRktArealProduktif->jumlah) ? number_format($data->idRktArealProduktif->jumlah,2,",",".") : "0"',
                            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'jumlah').'</strong>',
                        ),
                        array(
                            'header'=>'sd Bulan Lalu',
                            'value'=>'$data->sd_bulan_lalu',
                            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>',
                        ),
                        array(
                            'header'=>'Bulan Ini',
                                'name'=>'realisasi',
                                'type'=>'raw',
                                'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
                                'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'realisasi').'</strong>',
                        ),
                        array(
                            'header'=>'sd Bulan Ini',
                            'value'=>'$data->sd_sekarang',
                            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
                        ),
                        array(
                            'name'=>'persentase',
                            'headerHtmlOptions' => array('class' => 'hidden'),
                            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                            'footer' => '<strong>'.$modelBibit->getTotalPersen($modelBibit->searchByRkt()->getData(), 'persentase').'</strong>',
                        )
                    ),
                )); 
    }                
                         ?>
<?php $this->endWidget(); ?>