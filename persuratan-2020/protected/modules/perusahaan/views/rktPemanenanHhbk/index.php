<div class="row" style="margin-top: 1em">
    <button onclick="entry_rkt_by_rku()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<h4 style="margin: 1em 0 0 0">Pemanenan HHBK</h4>
<?php  
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pembibitan-grid-rku-match',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuMatch(),
    'enableSorting' => false,
//  'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan'),
//  'filter'=>$model,
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                * $this->grid->dataProvider->pagination->pageSize) + 1',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Blok Kerja Tahun Ke',
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'name' => 'rkt_ke',
            'htmlOptions' => array('style' => 'text-align:center'),
            'footer' => '<strong>'.'Total'.'</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
            'header' => 'Tata Ruang',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
            'header' => 'Jenis HHBK',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'header'=>'Luas (Ha)',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//          'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'luas',
            'value'=>function ($data) {
                    return number_format($data->luas,2,',','.');
                },
            'type' => 'raw',
//            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rktPembibitan/inputJumlahBibit'),
//                'success' => 'js:function() {
//	                $.fn.yiiGridView.update("rkt-pembibitan-grid-rku-match",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
//	            }'
//                ),
            'htmlOptions' => array('style' => 'text-align:right'),
            'footer' => '<strong>'.number_format(RktPanenHhbk::model()->getTotal($model->findRkuMatch()->getData(), 'luas'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'header'=>'Produksi',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//          'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
//            'value'=>function ($data) {
//                    return number_format($data->jumlah,2,',','.');
//                },
            'value' => '(!empty($data->jumlah)) ? number_format($data->jumlah,2,",","."). " " .$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan : ""',
            'type' => 'raw',
//            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rktPembibitan/inputJumlahBibit'),
//                'success' => 'js:function() {
//	                $.fn.yiiGridView.update("rkt-pembibitan-grid-rku-match",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
//	            }'
//                ),
            'htmlOptions' => array('style' => 'text-align:right'),
//            'footer' => '<strong>'.number_format(RktPanenHhbk::model()->getTotal($model->findRkuMatch()->getData(), 'jumlah'),2,",",".") . '</strong>',
//            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
//        array(
//            'header' => 'Jumlah',
//            // 'class' => 'booster.widgets.TbEditableColumn',
//            'name' => 'jumlah',
//            // 'type' => 'raw',
//            'value' => '(!empty($data->jumlah)) ? $data->jumlah. "(".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" : "0 (".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" ',
//         ),
        array(
            'header'=>'',
            'type'=>'raw',
            'value'=>function($data){
                    return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
                            'class'=>'deleteInFunction',
                            'onclick'=>'deleteDataMatch(this)', 
                            'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemanenanHhbk/delete",array("id"=>$data->id))
                    ));
            }
        ),
    ),
));
?>




<script type="text/javascript">

	function deleteDataMatch(th){
		//alert($(th).attr("data-url"));
		var urlLink = $(th).attr("data-url");
		if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
			//return true;
			//var th = this,
			afterDelete = function(){};
			jQuery('#rkt-pembibitan-grid-rku-match').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#rkt-pembibitan-grid-rku-match').yiiGridView('update');
					afterDelete(th, true, data);
				},
				error: function(XHR) {
					return afterDelete(th, false, XHR);
				}
			});
		  } else {
			//return false;
		  }
		return false;
	}
	
	
	// ini fungsi untuk js button group
	$( "#buttonGroup" ).click(function() {
		if ($(this).hasClass("open")) {
			//alert('close');
			$( this ).removeClass( "open" );
		}else{
			$( this ).addClass( "open" );
		}
	});
	
   

    function entry_rkt_by_rku()
    {
        var thn = $("#Rkt_tahun_mulai").val();
        //alert(thn);
        var url = "<?php echo $this->createUrl('//perusahaan/rktPemanenanHhbk/pilihRKU'); ?>" + "tahun/" + thn;
        var title = "Entry RKT Sesuai Data RKU";
        showModal(url, title);
    }
</script>
