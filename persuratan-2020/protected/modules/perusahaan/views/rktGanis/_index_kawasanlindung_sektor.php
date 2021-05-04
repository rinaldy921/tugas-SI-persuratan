<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-kawasanlindung-grid',
    // 'filter'=>$model,
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'template' => "{items}",
    'mergeColumns' => array('sektor'),
    'extraRowColumns' => array('sektor'),
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
    // 'extraRowExpression' => '"<span class=\"subtotal\">avg age - ".round($totals["jumlah"],2)."</span>"',
    'extraNipzExpression' => '"<tr class=\"nipz-blue\">
    <td class=\"nipz-red\"><strong><i>Sub Total</i></strong></td>
    <td>&nbsp;</td>
    <td class=\"nipz-red\">".round($totals["jumlah"],2)."</td>
    <td class=\"nipz-red\">".round($totals["realisasi"],2)."</td>
    <td class=\"nipz-red\">".round(($totals["persentase"] / $totals["pe"]),2)."</td>"
',
    // 'extraRowColumns'=> array('firstLetter'),
    // 'extraRowExpression' =>  '"<b style=\"font-size: 3em; color: #333;\">".substr($data->firstName, 0, 1)."</b>"',
    // 'extraRowHtmlOptions' => array('style'=>'padding:10px'),
    'columns' => array(
        // 'id',
        // 'id_rkt',
        // 'id_blok',
        array(
            'name' => 'sektor',
            'value' => '$data->idBlok->idSektor->nama_sektor',
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'name' => 'id_blok',
            'value' => '$data->idBlok->idBlok->nama_blok',
        ),
        // 'jumlah',
        array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            'type' => 'raw',
            // 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktGanis/inputJumlahKawasanLindung'),
                'success' => 'js:function() {
                    $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-kawasanlindung-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
                }',
                'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
            ),
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        // 'realisasi',
        array(
            // 'header'=>'Realisasi',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'realisasi',
            'type' => 'raw',
            // 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
            'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktGanis/inputJumlahKawasanLindung'),
                'success' => 'js:function() {
                    $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-kawasanlindung-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
                }',
                'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
            ),
            'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'realisasi') . '</strong>',
        ),
        array(
            // 'header'=>'%',
            'name' => 'persentase',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            'value' => 'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>' . $model->getTotalPersen($model->search()->getData(), 'persentase') . '</strong>',
        // 'class'=>'TbPercentOfTypeEasyPieOperation'
        )
    ),
));
