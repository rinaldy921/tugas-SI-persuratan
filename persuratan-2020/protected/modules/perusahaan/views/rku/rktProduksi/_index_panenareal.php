<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-panenareal-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'mergeColumns' => array('id_jenis_lahan'),
    'extraRowColumns' => array('id_jenis_lahan'),
    'extraRowTotals' => function($data, $row, &$totals) {
if (!isset($totals['jumlah']))
    $totals['jumlah'] = 0;
if (!isset($totals['realisasi']))
    $totals['realisasi'] = 0;
if (!isset($totals['persentase'])) {
    $totals['persentase'] = 0;
    $totals['pe'] = 0;
}
$totals['jumlah'] += $data['jumlah'];
$totals['realisasi'] += $data['realisasi'];
$totals['persentase'] += $data['persentase'];
$totals['pe'] += 1;
},
    'extraRowPos' => 'below',
    'extraNipzExpression' => '"<tr class=\"nipz-blue\">
    <td class=\"nipz-red text-left\" colspan=\"2\"><strong><i>Sub Total</i></strong></td>
    <td class=\"nipz-red\">".round($totals["jumlah"],2)."</td>
    <td class=\"nipz-red\">".round($totals["realisasi"],2)."</td>
    <td class=\"nipz-red\">".round(($totals["persentase"] / $totals["pe"]),2)."</td>"
',
    'template' => '{items}',
    'columns' => array(
        array(
            'name' => 'id_jenis_lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'header' => '',
            'name' => 'id_jenis_produksi_lahan',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'jumlah',
            'type' => 'raw',
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'name' => 'realisasi',
            'type' => 'raw',
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'realisasi') . '</strong>',
        ),
        array(
            'name' => 'persentase',
            'value' => 'isset($data->persentase) ? $data->persentase : "0"',
            'footer' => '<strong>' . $model->getTotalPersen($model->search()->getData(), 'persentase') . '</strong>',
        )
    ),
));
?>