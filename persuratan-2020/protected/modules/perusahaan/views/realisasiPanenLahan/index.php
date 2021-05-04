<style media="screen">
    #<?php echo Yii::app()->controller->id ?>-panenproduksi-grid table th{
        text-align: center;
        vertical-align: middle
    }
</style>

<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        // temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Pemeliharaan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Daur</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Sektor</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Blok</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Tata Ruang</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Lahan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Kayu</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Kelompok Kayu</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (Ha)</th>';
        temp += '<th colspan=\'4\' style=\'text-align: center; vertical-align: middle\'>Realisasi (Ha)</th>';
//        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (m3)</th>';
        temp += '<th colspan=\'4\' style=\'text-align: center; vertical-align: middle\'>Realisasi (m3)</th>';
//        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-panenproduksi-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php 
//    echo($tahun);die();

    $box = $this->beginWidget(
        'booster.widgets.TbPanel',
    array(
        'title' => 'Pemanenan Penyiapan Lahan',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<?php $this->widget('booster.widgets.BootGroupGridView',array(
    'id'=>Yii::app()->controller->id . '-panenproduksi-grid',
    'type' => 'bordered condensed',
    'responsiveTable' => true,
    'enableSorting'=>false,
    'dataProvider'=>$modelPanenProduksi->searchByRkt(),
    //'mergeColumns'=>array('id_jenis_lahan','id_blok'),
    'mergeColumns'=>array('daur'),
    //'extraRowColumns'=> array('id_jenis_lahan'),
    //'extraRowColumns'=> array('daur'),
    'extraRowTotals'=>function($data, $row, &$totals) {
        if(!isset($totals['jumlah_produksi'])) $totals['jumlah_produksi'] = 0;
        if(!isset($totals['realisasi_produksi'])) $totals['realisasi_produksi'] = 0;
        if(!isset($totals['persentase_produksi'])) {
            $totals['persentase_produksi'] = 0;$totals['pe'] = 0;
        }
        $totals['jumlah_produksi'] += $data['idRktPanenLahan']['jumlah_produksi'];
        $totals['realisasi_produksi'] += $data['realisasi_produksi'];
        $totals['persentase_produksi'] += $data['persentase_produksi'];
        $totals['sd_sekarang_produksi'] += $data['sd_sekarang_produksi'];
        $totals['sd_bulan_lalu_produksi'] += $data['sd_bulan_lalu_produksi'];
        $totals['pe'] += 1;
        
//        
//         if(!isset($totals['jumlah_luas'])) $totals['jumlah_produksi'] = 0;
        if(!isset($totals['realisasi_luas'])) $totals['realisasi_luas'] = 0;
        if(!isset($totals['persentase_luas'])) {
            $totals['persentase_luas'] = 0;$totals['pe'] = 0;
        }
        //$totals['jumlah_produksi'] += $data['idRktPanenProduksi']['jumlah_produksi'];
        $totals['realisasi_luas'] += $data['realisasi_luas'];
        $totals['persentase_luas'] += $data['persentase_luas'];
        $totals['sd_sekarang_luas'] += $data['sd_sekarang_luas'];
        $totals['sd_bulan_lalu_luas'] += $data['sd_bulan_lalu_luas'];
       // $totals['pe'] += 1;
        
        
     },
     'extraRowPos' => 'below',
    'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red text-left\" colspan=\"2\"><strong><i>Sub Total</i></strong></td>
        <td class=\"nipz-red\">".number_format($totals["jumlah_produksi"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu_produksi"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["realisasi_produksi"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang_produksi"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang_produksi"] > 0 ? ($totals["sd_sekarang_produksi"] / $totals["jumlah_produksi"]) * 100 : 0,2,",",".")."</td>
        
        <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu_luas"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["realisasi_luas"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang_luas"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang_luas"] > 0 ? ($totals["sd_sekarang_luas"] / $totals["jumlah_produksi"]) * 100 : 0,2,",",".")."</td>"
    ',
    'template' => '{items}',
    'columns'=>array(
            // array(
            //     'header' => 'Jenis Pemilaharaan',
            //     'name' => 'jenis_pemeliharaan',
            //     'value'=>'$data->idRktPanenProduksi->idJenisPemeliharaan->jenis_pemeliharaan',
            //     'headerHtmlOptions' => array('class' => 'hidden'),
            //     'footer' => '<strong>Total</strong>'
            // ),
             array(
                'header' => 'Daur',
                'name' => 'daur',
                'value'=>'$data->idRktPanenLahan->daur',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'footer' => '<strong>Total</strong>'
            ),
            array(
                'header' => 'Sektor',
                'name' => 'id_sektor',
                'value'=>'$data->idRktPanenLahan->idBlok->namaSektor->nama_sektor',
                'headerHtmlOptions' => array('class' => 'hidden'),
            ),
            array(
                'header'=>'Blok',
                'name'=>'id_blok',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'$data->idRktPanenLahan->idBlok->nama_blok',
                'htmlOptions'=>array('style'=>'padding-left:30px'),
            ),
            array(
                'header'=>'Produksi Lahan',
                'value'=>'$data->idRktPanenLahan->idJenisProduksiLahan->jenis_produksi',
                'headerHtmlOptions' => array('class' => 'hidden'),
            ),
            array(
                'header'=>'Jenis Lahan',
                'name'=>'id_jenis_lahan',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'$data->idRktPanenLahan->idJenisLahan->jenis_lahan',
            ),
            array(
                'header'=>'Jenis Kayu',
                'name'=>'id_jenis_kayu',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'$data->idRktPanenLahan->idJenisKayu->nama_kayu',
            ),
            array(
                'header'=>'Jenis Kelompok Kayu',
                'name'=>'id_jenis_kelompok_kayu',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'$data->idRktPanenLahan->idJenisKelompokKayu->nama_kelompok',
            ),
        
            array(
                'header'=>'Rencana',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->idRktPanenLahan->jumlah_luas) ? number_format($data->idRktPanenLahan->jumlah_luas,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'jumlah_luas').'</strong>',            
            ),
            array(
                'header'=>'sd Bulan Lalu',
                'value'=>'$data->sd_bulan_lalu_luas',
                'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'sd_bulan_lalu_luas').'</strong>'
            ),
            array(
                'header'=>'Bulan Ini',
                'class'=>'booster.widgets.TbEditableColumn',
                'name'=>'realisasi_luas',
                'type'=>'raw',
                'value' => '!empty($data->realisasi_luas) ? number_format($data->realisasi_luas,2,",",".") : ""',
                'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPanenLahan/inputJumlahPanenProduksi'),
//                    'success'=>'js:function(){
//                        $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-panenproduksi-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
//                            setTimeout(function(){
//                                generateTable();
//                            }, 100)
//                        }});
//                    }',
//                    'onShown' => 'js: function(e, editable) {
//                        var isi = editable.value.replace(".", "");
//                        var isi = isi.replace(",", ".");
//                        var tip = $(this).data("editableContainer").tip();
//                        tip.find("input").val(isi);
//                    }'
                ),
                'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'realisasi_luas').'</strong>',
            ),
            array(
                'header'=>'sd Bulan Ini',
                'value'=>'$data->sd_sekarang_luas',
                'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'sd_sekarang_luas').'</strong>'
            ),
            array(
                'header'=>'%',
                'name'=>'persentase_luas',
//                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->persentase_luas) ? number_format($data->persentase_luas,2,",",".") : "0"',
                'footer' => '<strong>'.$modelPanenProduksi->getTotalPersenLuas($modelPanenProduksi->searchByRkt()->getData(), 'persentase_luas').'</strong>',
            ),       
        
            array(
                'header'=>'Rencana',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->idRktPanenLahan->jumlah_produksi) ? number_format($data->idRktPanenLahan->jumlah_produksi,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'jumlah_produksi').'</strong>',            
            ),
            array(
                'header'=>'sd Bulan Lalu',
                'value'=>'$data->sd_bulan_lalu_produksi',
                'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'sd_bulan_lalu_produksi').'</strong>'
            ),
            array(
                'header'=>'Bulan Ini',
                'class'=>'booster.widgets.TbEditableColumn',
                'name'=>'realisasi_produksi',
                'type'=>'raw',
                'value' => '!empty($data->realisasi_produksi) ? number_format($data->realisasi_produksi,2,",",".") : ""',
                'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPanenLahan/inputJumlahPanenProduksi'),
//                    'success'=>'js:function(){
//                        $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-panenproduksi-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
//                            setTimeout(function(){
//                                generateTable();
//                            }, 100)
//                        }});
//                    }',
//                    'onShown' => 'js: function(e, editable) {
//                        var isi = editable.value.replace(".", "");
//                        var isi = isi.replace(",", ".");
//                        var tip = $(this).data("editableContainer").tip();
//                        tip.find("input").val(isi);
//                    }'
                ),
                'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'realisasi_produksi').'</strong>',
            ),
//            array(
//                'header'=>'Bulan Ini',
//                'class'=>'booster.widgets.TbEditableColumn',
//                'name'=>'realisasi_produksi',
//                'type'=>'raw',
//                'value' => '!empty($data->realisasi_produksi) ? number_format($data->realisasi_produksi,2,",",".") : ""',
//                'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPanenProduksi/inputJumlahPanenProduksi'),
//                    'success'=>'js:function(){
//                        $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-panenproduksi-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
//                            setTimeout(function(){
//                                generateTable();
//                            }, 100)
//                        }});
//                    }',
//                    'onShown' => 'js: function(e, editable) {
//                        var isi = editable.value.replace(".", "");
//                        var isi = isi.replace(",", ".");
//                        var tip = $(this).data("editableContainer").tip();
//                        tip.find("input").val(isi);
//                    }'
//                ),
//                'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'realisasi_produksi').'</strong>',
//            ),
            array(
                'header'=>'sd Bulan Ini',
                'value'=>'$data->sd_sekarang_produksi',
                'footer' => '<strong>'.$modelPanenProduksi->getTotal($modelPanenProduksi->searchByRkt()->getData(), 'sd_sekarang_produksi').'</strong>'
            ),
            array(
                'header'=>'%',
                'name'=>'persentase_produksi',
//                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->persentase_produksi) ? number_format($data->persentase_produksi,2,",",".") : "0"',
                'footer' => '<strong>'.$modelPanenProduksi->getTotalPersenProduksi($modelPanenProduksi->searchByRkt()->getData(), 'persentase_produksi').'</strong>',
            )      
    ),
)); ?>
<?php $this->endWidget(); ?>