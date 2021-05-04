<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Lahan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Produksi Lahan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Block</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Tanaman</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (M3)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi (M3)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-tanam-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Pemanenan',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<center><h3>Volume Produksi Hasil Tanaman</h3></center>
<?php $this->widget('booster.widgets.BootGroupGridView',array(
    'id'=>Yii::app()->controller->id . '-tanam-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelTanam->searchByRkt(),
    'enableSorting'=>false,
    'mergeColumns'=>array('id_jenis_lahan','id_produksi_lahan','id_blok'),
    'extraRowColumns'=> array('id_jenis_lahan'),
    'extraRowTotals'=>function($data, $row, &$totals) {
         if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
         if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
         if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
         $totals['jumlah'] += $data['idRktPanenVolumeTanaman']['jumlah'];
         $totals['realisasi'] += $data['realisasi'];
         $totals['persentase'] += $data['persentase'];
         $totals['sd_sekarang'] += $data['sd_sekarang'];
         $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
         $totals['pe'] += 1;
    },
    'extraRowPos' => 'below',
    'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red text-left\" colspan=\"4\"><strong><i>Sub Total</i></strong></td>
        <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["persentase"],2,",",".")."</td>"
    ',
    'template' => '{items}',
    'columns'=>array(
        array(
            'header'=>'Jenis Lahan',
            'name'=>'id_jenis_lahan',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktPanenVolumeTanaman->idJenisLahan->jenis_lahan',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'header'=>'Jenis Produksi Lahan',
            'name'=>'id_produksi_lahan',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktPanenVolumeTanaman->idProduksiLahan->jenis_produksi',
        ),
        array(
            'header'=>'Blok',
            'name'=>'id_blok',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktPanenVolumeTanaman->idBlok->idBlok->nama_blok',
        ),
        array(
            'header'=>'Jenis Tanaman',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktPanenVolumeTanaman->idJenisTanaman->nama_tanaman'
        ),
        array(
            'header'=>'Rencana (Ha)',
            'value'=>'isset($data->idRktPanenVolumeTanaman->jumlah) ? number_format($data->idRktPanenVolumeTanaman->jumlah,2,",",".") : "0"',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'footer' => '<strong>'.$modelTanam->getTotal($modelTanam->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'sd Bulan Lalu',
            'value'=>'$data->sd_bulan_lalu',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
            'footer' => '<strong>'.$modelTanam->getTotal($modelTanam->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>'
        ),
        array(
			'header'=>'Bulan Ini',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'realisasi',
			'type'=>'raw',
			'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPanenVolProdHasilTanaman/inputJumlahTanam'),
				'success'=>'js:function(){
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-tanam-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
                        setTimeout(function(){
                            generateTable();
                        }, 100)
                    }});
	            }',
	            'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
			),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
			'footer' => '<strong>'.$modelTanam->getTotal($modelTanam->searchByRkt()->getData(), 'realisasi').'</strong>',
		),
        array(
            'header'=>'sd Bulan Ini',
            'value'=>'$data->sd_sekarang',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
            'footer' => '<strong>'.$modelTanam->getTotal($modelTanam->searchByRkt()->getData(), 'sd_sekarang').'</strong>'
        ),
        array(
            'name'=>'persentase',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelTanam->getTotal($modelTanam->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
<?php $this->endWidget(); ?>