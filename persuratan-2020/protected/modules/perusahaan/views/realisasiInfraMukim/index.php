<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (Unit)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi (Unit)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-inframukim-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Pembinaan & Pemberdayaan Masyarakat',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<center><h3>Pembangunan Penyaluran Infrastruktur Pemukiman</h3></center>
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-inframukim-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelRalisasi->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
    	array(
    		'name'=>'id_infra_mukim',
    		'value'=>'$data->idRktInfraMukim->idInfraMukim->nama_sarana',
            'headerHtmlOptions' => array('class' => 'hidden'),
    		'footer' => '<strong>Total</strong>'
    	),
        array(
            'header'=>'Rencana (Unit)',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'$data->idRktInfraMukim->jumlah',
            'footer' => '<strong>'.$modelRalisasi->getTotal($modelRalisasi->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'sd Bulan Lalu',
            'value'=>'$data->sd_bulan_lalu',
            'footer' => '<strong>'.$modelRalisasi->getTotal($modelRalisasi->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>',
        ),
    	array(
    		'header'=>'Bulan Ini',
    		'class'=>'booster.widgets.TbEditableColumn',
    		'name'=>'realisasi',
    		'type'=>'raw',
    		'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",",".") : ""',
    		'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiInfraMukim/inputRealisasi'),
//    			'success'=>'js:function(){
//                            $.fn.yiiGridView.update("-inframukim-grid");
//                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-inframukim-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
//                        setTimeout(function(){
//                            generateTable();
//                        }, 100)
//                    }});
//                }'
    		),
    		'footer' => '<strong>'.$modelRalisasi->getTotal($modelRalisasi->searchByRkt()->getData(), 'realisasi').'</strong>',
    	),
        array(
            'header'=>'sd Bulan Ini',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelRalisasi->getTotal($modelRalisasi->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
    	array(
            'name'=>'persentase',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelRalisasi->getTotal($modelRalisasi->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
<?php $this->endWidget(); ?>