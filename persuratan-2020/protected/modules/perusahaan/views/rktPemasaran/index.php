<div class="row" style="margin-top: 1em">
    <button onclick="entry_rkt_by_rku()" type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<?php
//debug($model); die();
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-pemasaran-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
//  'mergeColumns' => array('daur', 'id_pemasaran'),
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
            'name' => 'id_pemasaran',
            'header' => 'Jenis Pemasaran',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'value' => '$data->idPemasaran->nama_pemasaran',
            'htmlOptions' => array('style' => 'text-align:center')
        ),  
//        array(
//            'header'=>'Jumlah (m³)',
//            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
//            'class' => 'booster.widgets.TbEditableColumn',
//            'name' => 'jumlah',
//            'value'=>function ($data) {
//                    return number_format($data->jumlah,0,',','.');
//                },
//            'type' => 'raw',
////            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
//            'editable' => array(
//                'url' => $this->createUrl('//perusahaan/rktPembibitan/inputJumlahBibit'),
//                'success' => 'js:function() {
//	                $.fn.yiiGridView.update("rkt-pembibitan-grid-rku-match",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
//	            }'
//                ),
//            'htmlOptions' => array('style' => 'text-align:right'),
//            'footer' => '<strong>'.number_format(RktBibit::model()->getTotal($model->findRkuDismatch()->getData(), 'jumlah'),0,",",".") . '</strong>',
//            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
//        ),
        array(
            'header'=>'Jumlah (m³)',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
            'type' => 'raw',
//            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            'editable' => array(
                'url' => $this->createUrl('//perusahaan/rktPemasaran/inputJumlahPemasaran'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("rkt-pemasaran-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
            'htmlOptions' => array('style' => 'text-align:right'),
            'footer' => '<strong>'.number_format(RktPasar::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'header'=>'',
            'type'=>'raw',
            'value'=>function($data){
                return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
                        'class'=>'deleteInFunction',
                        'onclick'=>'deleteDataMatch(this)', 
                        'data-url'=> Yii::app()->createUrl("/perusahaan/rktPemasaran/delete",array("id"=>$data->id))
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
			jQuery('#rkt-pemasaran-grid').yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#rkt-pemasaran-grid').yiiGridView('update');
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
	
    function entry_rkt_by_rku()
    {
        var thn = $("#Rkt_tahun_mulai").val();
        //alert(thn);
        var url = "<?php echo $this->createUrl('//perusahaan/rktPemasaran/pilihRKU'); ?>" + "tahun/" + thn;
        var title = "Tambah Data Pemasaran";
        showModal(url, title);
    } 
    
</script>
