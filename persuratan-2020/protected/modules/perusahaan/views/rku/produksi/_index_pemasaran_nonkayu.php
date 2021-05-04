<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    //'id' => Yii::app()->controller->id . '-rku-pasar-hhbk-grid',
    'id' => 'rku-pasar-hhbk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
//    'mergeColumns' => array('tahun', 'nama_hhbk', 'id_jenis_pasar'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    'extraRowColumns' => array('rkt_ke'),
    'extraRowPos' => below,
    // 'filter' => $model,
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
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'rkt_ke',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'footer' => '<strong>'.'Total'.'</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            //'type' => 'raw',
            //'editable' => array(
            //    'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputRktKePasarHhbk'),
            //    'success'=>'js:function() {
            //        $.fn.yiiGridView.update("rku-pasar-hhbk-grid");
            //    }'
            //),
            // 'footer' => '<strong>' . RkuBibitNew::model()->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        
        //'daur',
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
            'name' => 'id_jenis_pasar',
            'header' => 'Pemasaran',
            'value' => '$data->idJenisPasar->nama_pemasaran',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
         array(
            'header' => 'Jumlah',
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
                'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
//            'type' => 'raw',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputPasarHhbk'),
//                'success'=>'js:function() {
//                    $.fn.yiiGridView.update("rku-pasar-hhbk-grid");
//                }'
//            ),
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'), 
            'footer' => '<strong>'.number_format(RkuPasarHhbk::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    )
));
?>
