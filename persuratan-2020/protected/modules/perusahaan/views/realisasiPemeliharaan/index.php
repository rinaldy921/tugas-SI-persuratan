<style media="screen">
    #<?php echo Yii::app()->controller->id ?>-pelihara-grid table th{
        text-align: center;
        vertical-align: middle
    }
</style>

<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Pemeliharaan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Daur</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Unit Kelestarian</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Petak Kerja</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Tata Ruang</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Lahan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (Ha)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi (Ha)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-pelihara-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Pemeliharaan',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<?php $this->widget('booster.widgets.BootGroupGridView',array(
    'id'=>Yii::app()->controller->id . '-pelihara-grid',
    'type' => 'bordered condensed',
    'responsiveTable' => true,
    'enableSorting'=>false,
    'dataProvider'=>$modelPelihara->searchByRkt(),
    //'mergeColumns'=>array('id_jenis_lahan','id_blok'),
    'mergeColumns'=>array('jenis_pemeliharaan','daur'),
    //'extraRowColumns'=> array('id_jenis_lahan'),
    //'extraRowColumns'=> array('daur'),
    'extraRowTotals'=>function($data, $row, &$totals) {
        if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
        if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
        if(!isset($totals['persentase'])) {
            $totals['persentase'] = 0;$totals['pe'] = 0;
        }
        $totals['jumlah'] += $data['idRktPelihara']['jumlah'];
        $totals['realisasi'] += $data['realisasi'];
        $totals['persentase'] += $data['persentase'];
        $totals['sd_sekarang'] += $data['sd_sekarang'];
        $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
        $totals['pe'] += 1;
     },
     'extraRowPos' => 'below',
    'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red text-left\" colspan=\"2\"><strong><i>Sub Total</i></strong></td>
        <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"] > 0 ? ($totals["sd_sekarang"] / $totals["jumlah"]) * 100 : 0,2,",",".")."</td>"
    ',
    'template' => '{items}',
    'columns'=>array(
            array(
                'header' => 'Jenis Pemilaharaan',
                'name' => 'jenis_pemeliharaan',
                'value'=>'$data->idRktPelihara->idJenisPemeliharaan->jenis_pemeliharaan',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'footer' => '<strong>Total</strong>'
            ),
             array(
                'header' => 'Daur',
                'name' => 'daur',
                'value'=>'$data->idRktPelihara->daur',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'footer' => '<strong>Total</strong>'
            ),
        
        
        
                array(
            'name' => 'id_blok',
            'value'=>'$data->idRktPelihara->idBlok->namaSektor->nama_sektor',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'name' => 'id_blok',
            'value'=>'$data->idRktPelihara->idBlok->nama_blok',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'footer' => '<strong>Total</strong>'
        ),
            array(
                'header'=>'Produksi Lahan',
                'value'=>'$data->idRktPelihara->idJenisProduksiLahan->jenis_produksi',
                'headerHtmlOptions' => array('class' => 'hidden'),
            ),
    		array(
    			'header'=>'Jenis Lahan',
    			'name'=>'id_jenis_lahan',
                'headerHtmlOptions' => array('class' => 'hidden'),
    			'value'=>'$data->idRktPelihara->idJenisLahan->jenis_lahan',
    		),
            array(
                'header'=>'Rencana',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->idRktPelihara->jumlah) ? number_format($data->idRktPelihara->jumlah,2,",",".") : "0"',
                    'footer' => '<strong>'.$modelPelihara->getTotal($modelPelihara->searchByRkt()->getData(), 'jumlah').'</strong>',            
            ),
            array(
                'header'=>'sd Bulan Lalu',
                'value'=>'$data->sd_bulan_lalu',
                'footer' => '<strong>'.$modelPelihara->getTotal($modelPelihara->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>'
            ),
    		array(
                'header'=>'Bulan Ini',
    			'class'=>'booster.widgets.TbEditableColumn',
    			'name'=>'realisasi',
    			'type'=>'raw',
    			'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
    			'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPemeliharaan/inputJumlahPelihara'),
//    				'success'=>'js:function(){
//                        $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-pelihara-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
//                            setTimeout(function(){
//                                generateTable();
//                            }, 100)
//                        }});
//    	            }',
//    	            'onShown' => 'js: function(e, editable) {
//                        var isi = editable.value.replace(".", "");
//                        var isi = isi.replace(",", ".");
//                        var tip = $(this).data("editableContainer").tip();
//                        tip.find("input").val(isi);
//                    }'
    			),
    			'footer' => '<strong>'.$modelPelihara->getTotal($modelPelihara->searchByRkt()->getData(), 'realisasi').'</strong>',
    		),
            array(
                'header'=>'sd Bulan Ini',
                'value'=>'$data->sd_sekarang',
                'footer' => '<strong>'.$modelPelihara->getTotal($modelPelihara->searchByRkt()->getData(), 'sd_sekarang').'</strong>'
            ),
    		array(
                'name'=>'persentase',
                'headerHtmlOptions' => array('class' => 'hidden'),
                'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
                'footer' => '<strong>'.$modelPelihara->getTotalPersen($modelPelihara->searchByRkt()->getData(), 'persentase').'</strong>',
            )
    ),
)); ?>
<?php $this->endWidget(); ?>