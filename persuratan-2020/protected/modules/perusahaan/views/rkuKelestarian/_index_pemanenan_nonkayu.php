<!--<a id="buton_new" class="btn btn-primary btn-sm" href="javascript:addHHBK()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Baru</a>-->
<br />
<button onclick="show_form_panen_nonkayu()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>

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
    'enableSorting' => TRUE,
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
        <td class=\"nipz-red text-right\" colspan=\"2\"></td>"
    ', 
    'columns' => array(
         array(
            'header' => 'Blok Kerja Tahun Ke',
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'rkt_ke',
            //'type' => 'raw',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputRktKeHhbk'),
//                'success'=>'js:function() {
//                    $.fn.yiiGridView.update("rku-hhbk-grid");
//                }'
//            ),
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
        // array(
        //     'header' => 'Satuan',
        //     'name'   => 'satuan',
        //     'value' => '$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan',
        // ),
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
            // 'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
            // 'type' => 'raw',
            //'value' => '(!empty($data->jumlah)) ? $data->jumlah. "(".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" : "0 (".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" ',
            // 'editable' => array('url' => $this->createUrl('//perusahaan/rkuKelestarian/inputHhbk'),
            //     'success'=>'js:function() {
            //         $.fn.yiiGridView.update("rku-hhbk-grid");
            //     }',
            //     'onShown' => 'js: function(e, editable) {
            //         var regExp = /\(([^)]+)\)/;
            //         var sat = regExp.exec(editable.value);
            //         var isi = editable.value;
            //         var isi = isi.replace(sat[0], "");
            //         var isi = isi.replace(" ", "");
            //         // console.log(sat[0]);
            //         var tip = $(this).data("editableContainer").tip();
            //         tip.find("input").val(isi);
            //     }'
            // ),
            // 'footer' => '<strong>' . RkuBibitNew::model()->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>'.number_format(RkuHasilHutanNonkayu::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
                'header'=>'',
                'type'=>'raw',
                'value'=>function($data){
                        return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'editPanenHhbk(this)', 
                                        'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/addHhbk",array("id_rku"=>'','id_hhbk'=>$data->id)),
                            ));
			},
                'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteData(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/deleteData",array("id"=>$data->id,'modelClass'=>'RkuHasilHutanNonkayu')),
					'data-grid'=> 'rku-hhbk-grid',
				));
			},
                        'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            ),
//        array(
//            'class' => 'booster.widgets.TbButtonColumn',
//            //'template'=>'{update} {delete}',
//            'template'=>'{delete}',
//            'buttons'=>array(
//                // 'update' => array(
//                //     'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit'),
//                //     'label' => '<i class="fa fa-edit"></i>',
//                //     'url' => function ($data) {
//                //         $_url = 'javascript:addHHBK("' . $data->id . '")';
//                //         return $_url;
//                //     },
//                // ),
//                'delete' => array(
//                    'url' => function ($data) {
//                        $_url = Yii::app()->createUrl("perusahaan/rkuKelestarian/deleteHhbk", array("id" => $data->id));
//                        return $_url;
//                    },
//                )
//            ),
//        ),
    )
));
?>


<script type="text/javascript">
    function show_form_panen_nonkayu(id = "")
    {
        var url = "<?php echo $this->createUrl('//perusahaan/rkuKelestarian/addHhbk', array('id_rku' => $rku->id_rku)); ?>id_hhbk/" + id;
        var title = "Tambah Data Pemanenan (Hasil Non Kayu)";
        showModal(url, title);
    }
    
    function editPanenHhbk(th = '')
    {
       var urlLink=$(th).attr("data-url");
       var url = urlLink;
       var title = "Ubah Data Pemanenan (Hasil Non Kayu)";
       showModal(url, title);
       jQuery('#rku-hhbk-grid').yiiGridView('update');
    }
//    function addHHBK(id = "")
//    {
//        var url = "<?php //echo $this->createUrl('//perusahaan/rkuKelestarian/addHhbk', array('id_rku' => $rku->id_rku)); ?>?id_hhbk=" + id;
//        var title = "Tambah Data Pemanenan Hasil Hutan Bukan Kayu";
//        showModal(url, title);
//    }
</script>
