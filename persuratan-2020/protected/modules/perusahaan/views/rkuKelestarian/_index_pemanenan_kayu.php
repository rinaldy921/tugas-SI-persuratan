<br />
<button onclick="show_form_panen_kayu()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>

<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-panen-kayu-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
//    'mergeColumns' => array('daur', 'rkt_ke', 'tahun', 'sektor','blok'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => TRUE,
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
        <td class=\"nipz-red text-left\" colspan=\"6\"><strong><i>"."Sub Total Blok Kerja Tahun Ke ".$data->rkt_ke." Tahun ".$data->tahun."</i></strong></td>
        <td class=\"nipz-red text-right\" colspan=\"1\">".number_format($totals["sum"],2,",",".")."</td>
        <td class=\"nipz-red text-right\" colspan=\"2\"></td>"
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
//                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputRktKePanen'),
//                'success'=>'js:function() {
//                    $.fn.yiiGridView.update("rku-panen-kayu-grid");
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
              'name' => 'Kabupaten',
              'value' => '$data->namaKabupaten->nama',
              'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
              'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
              
        ),       
        array(
            'name' => 'jumlah',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
                'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
            'footer' => '<strong>'.number_format(RkuPanen::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'name' => 'produksi',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
                'value'=>function ($data) {
                    return number_format($data->produksi,2,',','.');
                },
            'footer' => '<strong>'.number_format(RkuPanen::model()->getTotal($model->search()->getData(), 'produksi'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'name' => 'keterangan',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),        
/*        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),        
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan'
        ),*/
        /*array(
            'header' => 'Jumlah (Ha)',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'editable' => array(
                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputPenanaman'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("rku-penanaman-grid");
                }'
            ),
            // 'footer' => '<strong>' . RkuBibitNew::model()->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ), */
        array(
                'header'=>'',
                'type'=>'raw',
                'value'=>function($data){
                        return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'editPanenKayu(this)', 
                                        'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/addPanenKayu",array("id_rku"=>'','id_panen'=>$data->id)),
                            ));
			},
                'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
        ),
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteData(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/deleteData",array("id"=>$data->id,'modelClass'=>'RkuPanen')),
					'data-grid'=> 'rku-panen-kayu-grid',
				));
			},
                'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
		),
    )
));
?>

<script type="text/javascript">
    function show_form_panen_kayu(id = "")
    {
        var url = "<?php echo $this->createUrl('//perusahaan/rkuKelestarian/addPanenKayu', array('id_rku' => $rku->id_rku)); ?>id_panen/" + id;
        var title = "Tambah Data Pemanenan (Hasil Kayu)";
        showModal(url, title);
    }
    
    function editPanenKayu(th = '')
    {
       var urlLink=$(th).attr("data-url");
       var url = urlLink;
       var title = "Ubah Data Pemanenan (Hasil Kayu)";
       showModal(url, title);
       jQuery('#rku-panen-kayu-grid').yiiGridView('update');
    }
</script>