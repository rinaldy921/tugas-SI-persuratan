<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-siaplahan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
  //  'mergeColumns' => array('daur','rkt_ke', 'tahun', 'sektor','blok', 'id_tanaman_silvikultur'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_lahan', 'id_jenis_produksi_lahan','sektor','blok'),
    'dataProvider' => $model->search(),
    'extraRowColumns' => array('rkt_ke'),
    'extraRowPos' => below,
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => TRUE,
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
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'daur',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            //'footer' => '<strong>Total</strong>',
        ),
         array(
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'footer' => '<strong>'.'Total'.'</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'name' => 'tahun',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            // 'footer' => '<strong>Total</strong>',
        ),
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
 
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),        
        array(
            'name' => 'id_tanaman_silvikultur',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle' ),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle' ),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'header' => 'Jumlah (Ha)',
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
//            'type' => 'raw',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputSiapLahan'),
//                'success'=>'js:function() {
//                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-siaplahan-grid");
//                }'
//            ),
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle' ),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>'.number_format(RkuSiapLahan::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    )
));
?>
