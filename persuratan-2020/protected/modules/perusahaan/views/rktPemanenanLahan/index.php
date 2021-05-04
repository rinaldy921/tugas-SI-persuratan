<div class="row" style="margin-top: 1em">
    <?php /*
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Entry Data RKT <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="link-menu" href="javascript:;" onclick="entry_rkt_by_rku()">Sesuai RKU</a></li>
            <li><a class="link-menu"  href="javascript:;" onclick="show_form_alasan()">Tidak Sesuai RKU</a></li>
        </ul>
    </div>
	*/ ?>
	
	 <div class="btn-group pull-left" id="buttonGroup">
        <button type="button" class="btn btn-default dropdown-toggle">
            Entry Data RKT <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="link-menu" href="javascript:;" onclick="entry_rkt_by_rku()">Sesuai RKU</a></li>
            <li><a class="link-menu"  href="javascript:;" onclick="show_form_alasan()">Tidak Sesuai RKU</a></li>
        </ul>
    </div>
</div>

<h4 style="margin: 1em 0 0 0">Sesuai RKU</h4>
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pemanenan-lahan-grid-rku-match',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuMatch(),
    'enableSorting' => false,
//  'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan','id_jenis_kayu', 'id_jenis_kelompok_kayu'),
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
            'name' => 'daur',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',),
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
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idBlok->namaSektor->nama_sektor',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idBlok->nama_blok',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'idKabupaten',
            'header' => 'Kabupaten',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idKabupaten->nama',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'id_jenis_kayu',
            'header' => 'Jenis Kayu',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisKayu->nama_kayu',
            'htmlOptions' => array('style' => 'text-align:center')
        ),  
        array(
            'name' => 'id_jenis_kelompok_kayu',
            'header' => 'Jenis Kelompok Kayu',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisKelompokKayu->nama_kelompok',
            'htmlOptions' => array('style' => 'text-align:center')
        ),                       
        array(
            'header'=>'Luas (Ha)',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah_luas',
            'value'=>function ($data) {
                    return number_format($data->jumlah_luas,2,',','.');
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
            'footer' => '<strong>'.number_format(RktPanenLahan::model()->getTotal($model->findRkuMatch()->getData(), 'jumlah_luas'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'header'=>'Produksi (m³)',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah_produksi',
            'value'=>function ($data) {
                    return number_format($data->jumlah_produksi,2,',','.');
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
            'footer' => '<strong>'.number_format(RktPanenLahan::model()->getTotal($model->findRkuMatch()->getData(), 'jumlah_produksi'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'header'=>'',
            'type'=>'raw',
            'value'=>function($data){
                    return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
                            'class'=>'deleteInFunction',
                            'onclick'=>'deleteDataMatch(this)', 
                            'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemanenanLahan/delete",array("id"=>$data->id))
                    ));
            }
        ),
    ),
));
?>

<h4 style="margin: 1em 0 0 0">Tidak Sesuai RKU</h4>
<?php

//$model->unsetAttributes(); 

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pemanenan-lahan-grid-rku-dismatch',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuDismatch(),
    'enableSorting' => false,
  //  'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan','id_jenis_kayu', 'id_jenis_kelompok_kayu'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                * $this->grid->dataProvider->pagination->pageSize) + 1',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'name' => 'daur',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',),
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
            'name' => 'sektor',
            'header' => 'Unit Kelestarian',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idBlok->namaSektor->nama_sektor',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'blok',
            'header' => 'Petak Kerja',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idBlok->nama_blok',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'idKabupaten',
            'header' => 'Kabupaten',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idKabupaten->nama',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'id_jenis_produksi_lahan',
            'header' => 'Tata Ruang',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'id_jenis_lahan',
            'header' => 'Jenis',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'name' => 'id_jenis_kayu',
            'header' => 'Jenis Kayu',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisKayu->nama_kayu',
            'htmlOptions' => array('style' => 'text-align:center')
        ),    
        array(
            'name' => 'id_jenis_kelompok_kayu',
            'header' => 'Jenis Kelompok Kayu',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idJenisKelompokKayu->nama_kelompok',
            'htmlOptions' => array('style' => 'text-align:center')
        ),                       
        array(
            'header'=>'Luas (Ha)',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah_luas',
            'value'=>function ($data) {
                    return number_format($data->jumlah_luas,2,',','.');
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
            'footer' => '<strong>'.number_format(RktPanenLahan::model()->getTotal($model->findRkuDismatch()->getData(), 'jumlah_luas'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'header'=>'Jumlah (m³)',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah_produksi',
            'value'=>function ($data) {
                    return number_format($data->jumlah_produksi,2,',','.');
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
            'footer' => '<strong>'.number_format(RktPanenLahan::model()->getTotal($model->findRkuDismatch()->getData(), 'jumlah_produksi'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'header' => 'Keterangan',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'rkumatch',
            'value' => function($data) {
                return $data->idRktFormAlasan->keterangan;
            }//'$data->idJenisTanaman->nama_tanaman'
        ),
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteDataDisMatch(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemanenanLahan/delete",array("id"=>$data->id))
				));
			}
		),
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'showAlasan(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktBibit/showAlasan",array("id"=>$data->id,'model'=>'RktPanenLahan'))
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
			jQuery('#rkt-pemanenan-lahan-grid-rku-match').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#rkt-pemanenan-lahan-grid-rku-match').yiiGridView('update');
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
	
	function deleteDataDisMatch(th){
		//alert($(th).attr("data-url"));
		var urlLink = $(th).attr("data-url");
		if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
			//return true;
			//var th = this,
			afterDelete = function(){};
			jQuery('#rkt-pemanenan-lahan-grid-rku-dismatch').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#rkt-pemanenan-lahan-grid-rku-dismatch').yiiGridView('update');
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
	
    function show_form_alasan()
    {
        var thn = $("#Rkt_tahun_mulai").val();
        var url = "<?php echo $this->createUrl('//perusahaan/rktPemanenanLahan/entryAlasan'); ?>" + "tahun/" + thn;
        var title = "Tambah Data RKT (Tidak Sesuai RKU)";
        showModal(url, title);
    }

    function entry_rkt_by_rku()
    {
        var thn = $("#Rkt_tahun_mulai").val();
        //alert(thn);
        var url = "<?php echo $this->createUrl('//perusahaan/rktPemanenanLahan/pilihRKU'); ?>" + "tahun/" + thn;
        var title = "Entry RKT Sesuai Data RKU";
        showModal(url, title);
    }
</script>
