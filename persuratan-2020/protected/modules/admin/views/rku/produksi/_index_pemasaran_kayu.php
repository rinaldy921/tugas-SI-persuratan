<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-pasar-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
//    'mergeColumns' => array('daur', 'rkt_ke','tahun', 'id_jenis_pasar'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => false,
    // 'filter' => $model,
    'extraRowColumns' => array('rkt_ke'),
    'extraRowPos' => below,
//    'mergeColumns' => array('daur','rkt_ke','tahun', 'sektor','blok'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_produksi_lahan','sektor','blok'),
    //'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
      'extraRowTotals' => function($data, $row, &$totals) {
          if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['sum'])) $totals['sum'] = 0;
          $totals['sum'] += $data['jumlah'];
      },
//    'extraRowExpression' => '"<strong>"."Jumlah Blok Kerja Tahun Ke ".$data->rkt_ke." : ".$totals["sum"] . " Batang"."</strong>"',
        'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
        <td class=\"nipz-red text-left\" colspan=\"4\"><strong><i>"."Sub Total Blok Kerja Tahun Ke ".$data->rkt_ke." Tahun ".$data->tahun."</i></strong></td>
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
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'rkt_ke',
//            'type' => 'raw',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputRktKePasar'),
//                'success'=>'js:function() {
//                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-pasar-grid");
//                }'
//            ),
            'footer' => '<strong>'.'Total'.'</strong>',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle; bold'),
        ),
        array(
        'name' => 'tahun',
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
            'header' => 'Jumlah (m³)',
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
                'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
//            'type' => 'raw',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputPasar'),
//                'success'=>'js:function() {
//                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-pasar-grid");
//                }'
//            ),
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>'.number_format(RkuPasar::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    )
));
?>
