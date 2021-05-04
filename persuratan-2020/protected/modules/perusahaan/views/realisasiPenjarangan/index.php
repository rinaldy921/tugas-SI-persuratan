<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Produksi Lahan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (Ha)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi (Ha)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-sulam-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Pemeliharaan',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<center><h3>Penjarangan</h3></center>
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-sulam-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelSulam->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
            'header'=>'Jenis Produksi Lahan',
            'value'=>'$data->idRktJarang->idJenisProduksiLahan->jenis_produksi',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'header'=>'Rencana (Ha)',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktJarang->jumlah) ? number_format($data->idRktJarang->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelSulam->getTotal($modelSulam->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'sd Bulan Lalu',
            'value'=>'$data->sd_bulan_lalu',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
            'footer' => '<strong>'.$modelSulam->getTotal($modelSulam->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>'
        ),
		array(
            'header'=>'Bulan Ini',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'realisasi',
			'type'=>'raw',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
			'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPenjarangan/inputJumlahSulam'),
				'success'=>'js:function(){
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-sulam-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
                        setTimeout(function(){
                            generateTable();
                        }, 100)
                    }});
	            }',
	            'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
			),
			'footer' => '<strong>'.$modelSulam->getTotal($modelSulam->search()->getData(), 'realisasi').'</strong>',
		),
        array(
            'header'=>'sd Bulan Ini',
            'value'=>'$data->sd_sekarang',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
            'footer' => '<strong>'.$modelSulam->getTotal($modelSulam->searchByRkt()->getData(), 'sd_sekarang').'</strong>'
        ),
		array(
            'name'=>'persentase',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelSulam->getTotal($modelSulam->search()->getData(), 'persentase').'</strong>',
        )
),
)); ?>
<?php $this->endWidget(); ?>