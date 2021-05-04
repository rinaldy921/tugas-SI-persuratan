<p style="color:red"><strong>* Untuk pengisian koma (,) isikan dengan titik (.)</strong></p>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-areal-non-produktif-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
 'enableSorting'=>false,
// 'filter'=>$model,
'template' => '{items}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
		// 'id_blok',
		array(
			'name'=>'id_blok',
			'value'=>'$data->idBlok->idBlok->nama_blok',
			'footer' => '<strong>Total</strong>'
		),
		// 'jumlah',
		array(
			// 'header'=>'Jumlah',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'jumlah',
			'type'=>'raw',
			'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
			'editable'=> array(
				// 'mode'=>'inline',
				'url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahArealNonProduktif'),
				'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-areal-non-produktif-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
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
			'header'=>'Realisasi',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'realisasi',
			'type'=>'raw',
			'visible'=>false,
			'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
			'editable'=> array(
				// 'mode'=>'inline',
				'url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahArealNonProduktif'),
				'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-areal-non-produktif-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
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
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
        )
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
),
)); ?>