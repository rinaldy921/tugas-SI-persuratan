<!-- <style media="screen">
    #<?php echo Yii::app()->controller->id ?>-serapan-grid th{
        text-align: center;
    }
    #<?php echo Yii::app()->controller->id ?>-serapan-grid td{
        text-align: center;
    }
</style> -->
<script type="text/javascript">
    function generateTable() {
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Tenaga Profesional</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Kewarganegaraan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Pendidikan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?= Yii::app()->controller->id ?>-naker-notetap-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php
$box = $this->beginWidget(
        'booster.widgets.TbPanel', array(
    'title' => 'Organisasi & Tenaga Kerja',
    'headerIcon' => 'save',
    'padContent' => false
        )
);
?>

<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-naker-notetap-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelSerapan->searchByRkt('0'),
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
        $totals['sd_sekarang'] += $data['sd_sekarang'];
        $totals['sd_bulan_lalu'] += $data['sd_bulan_lalu'];
        $totals['pe'] += 1;
    },
    'extraRowPos' => 'below',
    'extraNipzExpression' => '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red text-left\" colspan=\"2\"><strong><i>Sub Total</i></strong></td>
        <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_bulan_lalu"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"],2,",",".")."</td>
        <td class=\"nipz-red\">".number_format($totals["sd_sekarang"] > 0 ? ($totals["sd_sekarang"] / $totals["jumlah"]) * 100 : 0,2,",",".")."</td>"
    ',
    'template' => '{items}',
    'columns' => array(
        array(
            'name' => 'is_tenaga_kehutanan',
            'value' => function ($data) {
                if ($data->idRktSerapanTenagaKerja->is_tenaga_kehutanan == "1") {
                    return "Tenaga Profesional Bidang Kehutanan";
                } else {
                    return "Tenaga Lainnya";
                }
            },
            'headerHtmlOptions' => array('class' => 'hidden'),
        //'footer' => '<strong>Total</strong>'
        ),
        array(
            'name' => 'id_jenis_kewarganegaraan',
            'value' => '$data->idRktSerapanTenagaKerja->idJenisKewarganegaraan->kewarganegaraan',
            'headerHtmlOptions' => array('class' => 'hidden'),
        ),
        array(
            'name' => 'id_pendidikan',
            'value' => '$data->idRktSerapanTenagaKerja->idPendidikan->pendidikan',
            'headerHtmlOptions' => array('class' => 'hidden'),
        ),
        array(
            'header' => 'Rencana',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value' => 'isset($data->idRktSerapanTenagaKerja->jumlah) ? $data->idRktSerapanTenagaKerja->jumlah : "0"',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'footer' => '<strong>'.$modelSerapan->getTotal($modelSerapan->searchByRkt('0')->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header' => 'sd Bulan Lalu',
            'value' => '$data->sd_bulan_lalu',
            'footer' => '<strong>' . $modelSerapan->getTotal($modelSerapan->searchByRkt('0')->getData(), 'sd_bulan_lalu') . '</strong>',
        ),
        array(
            'header' => 'Bulan Ini',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'realisasi',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/serapanTenagaKerja/inputJumlah'),
//                'success' => 'js:function(){
//                    $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-naker-notetap-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '&id_bulan=' . $id_bulan . '&tahun_periode=' . $tahun_periode . '",complete:function(){
//                        setTimeout(function(){
//                            generateTable();
//                        }, 100)
//                    }});
//                }'
            ),
            'footer' => '<strong>' . $modelSerapan->getTotal($modelSerapan->searchByRkt('0')->getData(), 'realisasi') . '</strong>',
        ),
        array(
            'header' => 'sd Bulan Ini',
            'value' => '$data->sd_sekarang',
            'footer' => '<strong>' . $modelSerapan->getTotal($modelSerapan->searchByRkt('0')->getData(), 'sd_sekarang') . '</strong>'
        ),
        array(
            'name' => 'persentase',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value' => 'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            //'footer' => '<strong>' . $modelSerapan->getTotalPersen($modelSerapan->searchByRkt('1')->getData(), 'persentase') . '</strong>',
        )
    ),
));
?>


<?php $this->endWidget(); ?>
