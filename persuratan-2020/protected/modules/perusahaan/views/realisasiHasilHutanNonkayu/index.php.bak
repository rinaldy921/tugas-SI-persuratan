<style media="screen">
    #<?php echo Yii::app()->controller->id ?>-nonkayu-grid table th{
        text-align: center;
        vertical-align: middle
    }
</style>
<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Hasil Hutan Non Kayu</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Satuan</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-nonkayu-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Hasil Hutan Non Kayu',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-nonkayu-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelNonKayu->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
    		'header'=>'Hasil Hutan Non Kayu',
    		'value'=>'$data->idRktHasilHutanNonkayu->idHasilHutanNonkayu->nama_hhbk',
            'headerHtmlOptions' => array('class' => 'hidden'),
    		'footer' => '<strong>Total</strong>'
    	),
        array(
    		'header'=>'Satuan',
            'headerHtmlOptions' => array('class' => 'hidden'),
    		'value'=>'$data->idRktHasilHutanNonkayu->idSatuanVolumeNonkayu->satuan'
    	),
        array(
            'header'=>'Rencana',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktHasilHutanNonkayu->jumlah) ? number_format($data->idRktHasilHutanNonkayu->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelNonKayu->getTotal($modelNonKayu->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'sd Bulan Lalu',
            'value'=>'$data->sd_bulan_lalu',
            'footer' => '<strong>'.$modelNonKayu->getTotal($modelNonKayu->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>',
        ),
        array(
            'header'=>'Bulan Ini',
    		'class'=>'booster.widgets.TbEditableColumn',
    		'name'=>'realisasi',
    		'type'=>'raw',
    		'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",",".") : ""',
    		'editable'=> array(
                'url'=>$this->createUrl('//perusahaan/realisasiHasilHutanNonkayu/inputJumlahKayu'),
    			'success'=>'js:function(){
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-nonkayu-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
                        setTimeout(function(){
                            generateTable();
                        }, 100)
                    }});
                }'
    		),
    		'footer' => '<strong>'.$modelNonKayu->getTotal($modelNonKayu->searchByRkt()->getData(), 'realisasi').'</strong>',
    	),
        array(
            'header'=>'sd Bulan Ini',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelNonKayu->getTotal($modelNonKayu->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'name'=>'persentase',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelNonKayu->getTotalPersen($modelNonKayu->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
<?php $this->endWidget(); ?>
