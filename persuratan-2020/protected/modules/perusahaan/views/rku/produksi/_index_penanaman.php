<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-penanaman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
   // 'mergeColumns' => array('daur','rkt_ke', 'tahun', 'id_jenis_produksi_lahan','sektor','blok'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
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
        <td class=\"nipz-red text-left\" colspan=\"7\"><strong><i>"."Sub Total Blok Kerja Tahun Ke ".$data->rkt_ke." Tahun ".$data->tahun."</i></strong></td>
        <td class=\"nipz-red text-right\" colspan=\"1\">".number_format($totals["sum"],2,",",".")."</td>
        "
    ', 
    'columns' => array(
        array(
            'name' => 'daur',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
       array(
          'header' => 'Blok Kerja Tahun Ke',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'rkt_ke',
            //            'htmlOptions' => array('width' => '100px' , 'style' => 'text-align:center')
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'footer' => '<strong>'.'Total'.'</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
//        array(
//            'name' => 'rkt_ke',
//            'header' => 'Blok Kerja Tahun Ke',
//            'footer' => '<strong>Total</strong>',
//        ),
        array(
            'name' => 'tahun',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
        ),
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idBlok->namaSektor->nama_sektor',
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idBlok->nama_blok',
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
        ),           
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
        ),        
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis Lahan',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisLahan->jenis_lahan',
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
        ),
        array(
            'header' => 'Jumlah (Ha)',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
                        'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
//            'type' => 'raw',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputPenanaman'),
//                'success'=>'js:function() {
//                    $.fn.yiiGridView.update("rku-penanaman-grid");
//                }'
//            ),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>'.number_format(RkuBibit::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    )
));
?>
