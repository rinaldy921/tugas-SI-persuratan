<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Kayu</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Kelompok Kayu</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (M<sup>3</sup>)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi (M<sup>3</sup>)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-panenvolumesiaplahan-grid table thead').prepend(temp);
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
<center><h3>Volume Produksi Penyiapan Lahan - LOA & NON-LOA</h3></center>
<?php $this->widget('booster.widgets.BootGroupGridView',array(
    'id'=>Yii::app()->controller->id . '-panenvolumesiaplahan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelTanam->searchByRkt(),
    'enableSorting'=>false,
    'mergeColumns'=>array('id_jenis_kayu'),
    'extraRowColumns'=> array('id_jenis_kayu'),
    'extraRowTotals'=>function($data, $row, &$totals) {
         if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
         if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
         if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
         if(!isset($totals['sd_sekarang'])) $totals['sd_sekarang'] = 0;
         if(!isset($totals['sd_bulan_lalu'])) $totals['sd_bulan_lalu'] = 0;

         $totals['jumlah'] += $data['idRktPanenVolumeSiapLahan']['jumlah'];
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
        <td class=\"nipz-red\">".number_format($totals["persentase"],2,",",".")."</td>"
    ',
    'template' => '{items}',
    'columns'=>array(
        array(
            'name'=>'id_jenis_kayu',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktPanenVolumeSiapLahan->idJenisKayu->nama_kayu',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'name'=>'id_jenis_kelompok_kayu',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktPanenVolumeSiapLahan->idJenisKelompokKayu->nama_kelompok',
        ),
        array(
            'header'=>'Rencana (Ha)',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktPanenVolumeSiapLahan->jumlah) ? number_format($data->idRktPanenVolumeSiapLahan->jumlah,2,",",".") : "0"',
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
            'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPanenVolProdSiapLahan/inputJumlahTanam'),
                'success'=>'js:function(){
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-panenvolumesiaplahan-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
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