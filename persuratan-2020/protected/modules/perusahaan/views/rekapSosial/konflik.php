<h4 style="margin-top: 2em; text-align: center">Rekapitulasi Penanganan Konflik Sosial Periode RKT <?=$tahun;?></h4>
<?php $this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-rekap-konflik-grid',
    'type' => 'bordered condensed striped get',
    'responsiveTable' => true,
    'dataProvider' => $model->searchByRkt(),
    'enableSorting' => false,
    'mergeColumns' => array('id_rkt_konflik_sosial'),
    'extraRowColumns' => array('id_rkt_konflik_sosial'),
    'extraRowTotals' => function($data, $row, &$totals){
        if (!isset($totals['persentase'])) {
            $totals['persentase'] = 0;
        }
        $totals['persentase'] += $data['persentase'];
    },
    'extraRowPos' => 'below',
    'extraNipzExpression' => '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red\"><strong><i>Sub Total</i></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class=\"nipz-red\">".round(($totals["persentase"]),2)."</td>"
    ',
    'columns' => array(
        array(
            'name' => 'id_rkt_konflik_sosial',
            'value' => '$data->idRktKonflikSosial->jenis_konflik',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'name' => 'id_bulan',
            'value' => '$data->idBulan->bulan',
            //'footer' => '<strong>Bulan</strong>'
        ),                
        'penanganan',
        'persentase'
    ),
));?>