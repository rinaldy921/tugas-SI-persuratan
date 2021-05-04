<?php

// print_r("<pre>");
//        print_r($model);
//        print_r("<pre>"); exit(1);
        
        

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-hhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
//    'mergeColumns' => array('tahun', 'id_hasil_hutan_nonkayu_silvikultur','nama_hhbk'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'extraRowColumns' => array('rkt_ke'),
    'extraRowPos' => below,
//    'mergeColumns' => array('daur','rkt_ke','tahun', 'sektor','blok'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_produksi_lahan','sektor','blok'),
    //'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
      'extraRowTotals' => function($data, $row, &$totals) {
          if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['sum'])) $totals['sum'] = 0;
          $totals['sum'] += $data['jumlah'];
      },
//    'extraRowExpression' => '"<strong>"."Jumlah Blok Kerja Tahun Ke ".$data->rkt_ke." : ".$totals["sum"] . " Batang"."</strong>"',
        'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red text-left\" colspan=\"5\"><strong><i>"."Sub Total Blok Kerja Tahun Ke ".$data->rkt_ke." Tahun ".$data->tahun."</i></strong></td>
        <td class=\"nipz-red text-right\" colspan=\"1\">".number_format($totals["sum"],2,",",".")."</td>
        "
    ', 
    'columns' => array(
         array(
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'footer' => '<strong>'.'Total'.'</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            // 'footer' => '<strong>' . RkuBibitNew::model()->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'name' => 'tahun',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
            'header' => 'Tata Ruang',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'header' => 'Jenis HHBK',
            'name'   => 'nama_hhbk',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'name' => 'luas',
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>'.number_format(RkuHasilHutanNonkayu::model()->getTotal($model->search()->getData(), 'luas'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'header' => 'Jumlah',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>'.number_format(RkuHasilHutanNonkayu::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    )
));
?>

