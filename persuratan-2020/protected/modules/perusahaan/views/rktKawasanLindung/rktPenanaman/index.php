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
	
	 <div class="btn-group pull-right" id="buttonGroup">
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
    'id' => 'rkt-penanaman-grid-rku-match',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuMatch(),
    'enableSorting' => false,
//    'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        'daur',
        array(
            'name' =>'RKT Ke',
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke',
        ),
        array(
            'name' => 'Sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
        ),
        array(
            'name' => 'Blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
        ),
        array(
            'name' => 'id_jenis_produksi_lahan',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'id_jenis_lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        array(
            'name' => 'id_jenis_tanaman',
            'value' => '$data->idJenisTanaman->nama_tanaman'
        ),
        //'jumlah',
        array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktPenanaman/inputJumlahTanam'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("rkt-penanaman-grid-rku-match",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
        //'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
		array(
			'header'=>'',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
					'class'=>'deleteInFunction',
					'onclick'=>'deleteDataMatch(this)', 
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktPenanaman/delete",array("id"=>$data->id))
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
    'id' => 'rkt-penanaman-grid-rku-dismatch',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->findRkuDismatch(),
    'enableSorting' => false,
    'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        'daur',
        array(
            'name' => 'Sektor',
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->idSektor->nama_sektor',
        ),
        array(
            'name' => 'Blok',
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->idBlok->nama_blok',
        ),
        array(
            'name' => 'id_jenis_produksi_lahan',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'id_jenis_lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        array(
            'name' => 'id_jenis_tanaman',
            'value' => '$data->idJenisTanaman->nama_tanaman'
        ),
        //'jumlah',
        array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktPenanaman/inputJumlahTanam'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("rkt-penanaman-grid-rku-dismatch",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
        //'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'header' => 'Keterangan',
            'name' => 'rkumatch',
            'value' => function($data) {
                return $data->idRktFormAlasan->keterangan;
            }//'$data->idJenisTanaman->nama_tanaman'
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="glyphicon glyphicon-trash"></i>', '', array(
                            'class' => 'deleteInFunction',
                            'onclick' => 'deleteDataDisMatch(this)',
                            'data-url' => Yii::app()->createUrl("/perusahaan/rktPenanaman/delete", array("id" => $data->id))
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
					'data-url'=> Yii::app()->createUrl("/perusahaan/rktBibit/showAlasan",array("id"=>$data->id,'model'=>'RktTanam'))
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
			jQuery('#rkt-penanaman-grid-rku-match').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#rkt-penanaman-grid-rku-match').yiiGridView('update');
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
			jQuery('#rkt-penanaman-grid-rku-dismatch').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#rkt-penanaman-grid-rku-dismatch').yiiGridView('update');
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
        var url = "<?php echo $this->createUrl('//perusahaan/rktPenanaman/entryAlasan'); ?>" + "tahun/" + thn;
        var title = "Tambah Data RKT (Tidak Sesuai RKU)";
        showModal(url, title);
    }

    function entry_rkt_by_rku()
    {
        var thn = $("#Rkt_tahun_mulai").val();
        //alert(thn);
        var url = "<?php echo $this->createUrl('//perusahaan/rktPenanaman/pilihRKU'); ?>" + "tahun/" + thn;
        var title = "Entry RKT Sesuai Data RKU";
        showModal(url, title);
    }
</script>
