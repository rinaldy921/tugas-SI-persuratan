<br />
    <button onclick="show_form_pembibitan()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>     
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id'=>'rku-pembenihan-grid',
    //'id' => 'pembibitan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'extraRowColumns' => array('rkt_ke'),
    'extraRowPos' => below,
//    'mergeColumns' => array('daur','rkt_ke','tahun', 'sektor','blok'),
    //'mergeColumns' => array('daur', 'tahun', 'id_jenis_produksi_lahan','sektor','blok'),
    //'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
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
        <td class=\"nipz-red text-left\" colspan=\"6\"><strong><i>"."Sub Total Blok Kerja Tahun Ke ".$data->rkt_ke." Tahun ".$data->tahun."</i></strong></td>
        <td class=\"nipz-red text-right\" colspan=\"1\">".number_format($totals["sum"],0,",",".")."</td>
        <td class=\"nipz-red text-right\" colspan=\"2\"></td>"
    ',              
    'columns' => array(
        array(
            'name' => 'daur',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'htmlOptions' => array('style' => 'text-align:center',),
        ),
        array(
            'header' => 'Blok Kerja Tahun Ke',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'name' => 'rkt_ke',
            //            'htmlOptions' => array('width' => '100px' , 'style' => 'text-align:center')
            'htmlOptions' => array('style' => 'text-align:center'),
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
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'value' => '$data->idBlok->namaSektor->nama_sektor',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'value' => '$data->idBlok->nama_blok',
            'htmlOptions' => array('style' => 'text-align:center')
        ),        
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center')
        ),        
        array(
            'header' => 'Jumlah (Btg)',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
                },
            'type' => 'raw',
            'editable' => array(
                'url' => $this->createUrl('//perusahaan/rkuKelestarian/inputPembibitan'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("pembibitan-grid");
                }',
                            ),
            'htmlOptions' => array('style' => 'text-align:right'),
            'footer' => '<strong>'.number_format(RkuBibit::model()->getTotal($model->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
//	array(
//			'header'=>'',
//			'type'=>'raw',
//			'value'=>function($data){
//				return CHtml::link('<i class="glyphicon glyphicon-edit"></i>','',array(
//					'class'=>'deleteInFunction',
//					'onclick'=>'editBibit(this)', 
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/addPembibitan",array("id_rku"=>'','id_bibit'=>$data->id)),
//					'data-grid'=> 'rku-pembenihan-grid',
//				));
//			}
//		),
                        
                        
                        
		array(

                'header'=>'',
                'type'=>'raw',
                'value'=>function($data){
                        return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'editBibit(this)', 
                                        'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/addPembibitan",array("id_rku"=>'','id_bibit'=>$data->id)),
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
					'data-url'=> Yii::app()->createUrl("/perusahaan/rkuKelestarian/deleteData",array("id"=>$data->id,'modelClass'=>'RkuBibit')),
					'data-grid'=> 'rku-pembenihan-grid',
                        ));
                }
        ),            
    )
));
?>

<script type="text/javascript">
   
    function show_form_pembibitan(id = '')
    {
       // var url = "<?php // echo $this->createUrl('//perusahaan/rkuKelestarian/addPembibitan', array('id_rku' => $rku->id_rku)); ?>?id_bibit=" + id;
        var url = "<?php echo $this->createUrl('/perusahaan/rkuKelestarian/addPembibitan', array('id_rku' => $rku->id_rku));?>id_bibit/"+id;

        var title = "Tambah Data Pengadaan Bibit";
        showModal(url, title);
    }
    
//     function editBibit(th = '')
//    {
//        var urlLink = $(th).attr("data-url");
//        
//       
//        var url = urlLink;
//
//        var title = "Ubah Data Pengadaan Bibit";
//        showModal(url, title);
//        
////        jQuery('#rku-pembenihan-grid').yiiGridView('update');
//    }
    function editBibit(th = '')
    {
       var urlLink=$(th).attr("data-url");
       var url = urlLink;
       var title = "Ubah Data Pengadaan Bibit";
       showModal(url, title);
       jQuery('#rku-pembenihan-grid').yiiGridView('update');
    }
    
    
</script>

