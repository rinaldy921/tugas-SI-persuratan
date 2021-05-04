    <?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createKawasanLindung'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.BootGroupGridView',array(
'id'=>Yii::app()->controller->id . '-panenareal-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
 'enableSorting'=>false,
'mergeColumns'=>array('id_jenis_lahan','id_produksi_lahan','sektor'),
'extraRowColumns'=> array('id_jenis_lahan'),
'extraRowTotals'=>function($data, $row, &$totals) {
     if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
     if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
     if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
     $totals['jumlah'] += $data['jumlah'];
     $totals['realisasi'] += $data['realisasi'];
     $totals['persentase'] += $data['persentase'];
     $totals['pe'] += 1;
 },
 'extraRowPos' => 'below',
 // 'extraRowExpression' => '"<span class=\"subtotal\">avg age - ".round($totals["jumlah"],2)."</span>"',
'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
    <td class=\"nipz-red text-left\" colspan=\"4\"><strong><i>Sub Total</i></strong></td>
    <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
    <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
    <td class=\"nipz-red\">".number_format($totals["realisasi"] > 0 ? ($totals["realisasi"] / $totals["jumlah"]) * 100 : 0,2,",",".")."</td>"
',
'template' => '{items}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
		// 'id_blok',
		// array(
		// 	'name'=>'id_blok',
		// 	'value'=>'$data->idBlok->idBlok->nama_blok'
		// ),
		array(
			'name'=>'id_jenis_lahan',
			'value'=>'$data->idJenisLahan->jenis_lahan',
			'footer' => '<strong>Total</strong>'
			// 'headerHtmlOptions' => array('style'=>'display:none'),
			// 'htmlOptions' =>array('style'=>'display:none')
		),
		array(
			'name'=>'id_produksi_lahan',
			'value'=>'$data->idProduksiLahan->jenis_produksi',
			// 'headerHtmlOptions' => array('style'=>'display:none'),
			// 'htmlOptions' =>array('style'=>'display:none')
		),
		array(
			'name'=>'sektor',
			'value'=>'$data->idBlok->idSektor->nama_sektor',
			// 'footer' => '<strong>Total</strong>'
		),
		array(
			'name'=>'id_blok',
			'value'=>'$data->idBlok->idBlok->nama_blok',
			// 'headerHtmlOptions' => array('style'=>'display:none'),
			// 'htmlOptions' =>array('style'=>'display:none')
		),
		array(
			'header'=>'Jenis Tanaman',
			'value'=>'$data->idJenisTanaman->nama_tanaman'
		),

		// 'jumlah',
		array(
			// 'header'=>'Jumlah',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'jumlah',
			'type'=>'raw',
			'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktBibit/inputJumlahPanenAreal'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-panenareal-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
	            }',
	            'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
			),
			'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
		),
		// 'realisasi',
		array(
			// 'header'=>'Realisasi',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'realisasi',
			'type'=>'raw',
			'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktBibit/inputJumlahPanenAreal'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-panenareal-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
	            }',
	            'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
			),
			'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
		),
		array(
            // 'header'=>'%',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
        )
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
),
)); ?>
