<br />
<button onclick="show_form_pemasaran_hhbk()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>

<!--<a id="buton_new" class="btn btn-primary btn-sm" href="javascript:addPASARHHBK()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Baru</a>-->

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
    'enableSorting' => TRUE,
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
        <td class=\"nipz-red text-right\" colspan=\"2\"></td>"
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
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
                'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
            'type' => 'raw',
            'editable' => array(
                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputPasarHhbk'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("rku-pasar-hhbk-grid");
                }'
            ),
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'), 
            'footer' => '<strong>'.number_format(RkuPasarHhbk::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        
//        array(
//            'header' => 'Jumlah',
//            // 'class' => 'booster.widgets.TbEditableColumn',
//            'name' => 'jumlah',
//            // 'type' => 'raw',
//            'value' => '(!empty($data->jumlah)) ? $data->jumlah. "(".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" : "0 (".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" ',
//            // 'editable' => array('url' => $this->createUrl('//perusahaan/rkuKelestarian/inputHhbk'),
//            //     'success'=>'js:function() {
//            //         $.fn.yiiGridView.update("rku-hhbk-grid");
//            //     }',
//            //     'onShown' => 'js: function(e, editable) {
//            //         var regExp = /\(([^)]+)\)/;
//            //         var sat = regExp.exec(editable.value);
//            //         var isi = editable.value;
//            //         var isi = isi.replace(sat[0], "");
//            //         var isi = isi.replace(" ", "");
//            //         // console.log(sat[0]);
//            //         var tip = $(this).data("editableContainer").tip();
//            //         tip.find("input").val(isi);
//            //     }'
//            // ),
//            // 'footer' => '<strong>' . RkuBibitNew::model()->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
//        ),
	array(
                'header'=>'',
                'type'=>'raw',
                'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
                'value'=>function($data){
                        return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'editPasarHhbk(this)', 
                                        'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/addPasarHhbk",array("id_rku"=>'','id_pasar_hhbk'=>$data->id)),
                            ));
			}
        ),
        array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteData(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/deleteData",array("id"=>$data->id,'modelClass'=>'RkuPasarHhbk')),
					'data-grid'=> Yii::app()->controller->id . '-pasar-grid',
				));
			}
		),
    )
));
?>
<script type="text/javascript">
    function show_form_pemasaran_hhbk(id = "")
    {
        var url = "<?php echo $this->createUrl('//perusahaan/rkuKelestarian/addPasarHhbk', array('id_rku' => $rku->id_rku)); ?>id_pasar_hhbk/" + id;
        var title = "Tambah Data Pemasaran (Hasil Kayu)";
        showModal(url, title);
    }
    function editPasarHhbk(th = '')
    {
       var urlLink=$(th).attr("data-url");
       var url = urlLink;
       var title = "Ubah Data Pemasaran (Hasil Non Kayu)";
       showModal(url, title);
       jQuery('#rku-pasar-grid').yiiGridView('update');
    }
    
//    function addPASARHHBK(id = "")
//    {
//        var url = "<?php //echo $this->createUrl('//perusahaan/rkuKelestarian/addPasarHhbk', array('id_rku' => $rku->id_rku)); ?>?id_pasar_hhbk=" + id;
//        var title = "Tambah Data Pemasaran Hasil Hutan Bukan Kayu";
//        showModal(url, title);
//    }
</script>
