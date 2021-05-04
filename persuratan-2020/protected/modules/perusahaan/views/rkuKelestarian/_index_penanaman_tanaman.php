<br />
<button onclick="show_form_penanaman()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>


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
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
                        'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
                },
            'type' => 'raw',
            'editable' => array(
                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputPenanaman'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("rku-penanaman-grid");
                }'
            ),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>'.number_format(RkuBibit::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
                'header'=>'',
                'type'=>'raw',
                'value'=>function($data){
                        return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'editTanam(this)', 
                                        'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/addPenanaman",array("id_rku"=>'','id_tanam'=>$data->id)),
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
					'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/deleteData",array("id"=>$data->id,'modelClass'=>'RkuTanam')),
					'data-grid'=> 'rku-penanaman-grid',
				));
			},
                    'htmlOptions' => array('style' => 'text-align:center; vertical-align:middle')
		),
    )
));
?>

<script type="text/javascript">
    function show_form_penanaman(id = '')
    {
        var url = "<?php echo $this->createUrl('//perusahaan/rkuKelestarian/addPenanaman', array('id_rku' => $rku->id_rku)); ?>id_tanam/" + id;
        var title = "Tambah Data Penanaman";
        showModal(url, title);
    }
    
    
    function editTanam(th = '')
    {
       var urlLink=$(th).attr("data-url");
       var url = urlLink;
       var title = "Ubah Data Penanaman";
       showModal(url, title);
       jQuery('#rku-penanaman-grid').yiiGridView('update');
    }
</script>
