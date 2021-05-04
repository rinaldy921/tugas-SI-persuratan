<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (Unit/Orang)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi (Unit/Orang)</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-dalkar-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Pengendalian Kebakaran',
        'padContent' => false,
        'headerIcon' => 'save'
    )
);?>
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-dalkar-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelBibit->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
            'name'=>'id_dalkar',
            'value'=>'$data->idRktLingkunganDalkar->nama_dalkar',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'header'=>'Rencana (Btg)',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktLingkunganDalkar->jumlah) ? number_format($data->idRktLingkunganDalkar->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'jumlah').'</strong>'
        ),
        array(
            'header'=>'sd Bulan Lalu',
            'value'=>'$data->sd_bulan_lalu',
            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>',
        ),
        array(
            'header'=>'Bulan Ini',
            'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'realisasi',
            'type'=>'raw',
            'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",",".") : ""',
            'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiKendaliKebakaran/inputRealisasi'),
//                'success'=>'js:function(){
//                    $.fn.yiiGridView.update("-dalkar-grid");
//                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-dalkar-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
//                        setTimeout(function(){
//                            generateTable();
//                        }, 100)
//                    }});
//                }'
            ),
            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'realisasi').'</strong>',
        ),
        array(
            'header'=>'sd Bulan Ini',
            'value'=>'$data->sd_sekarang',
            'footer' => '<strong>'.$modelBibit->getTotal($modelBibit->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'name'=>'persentase',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelBibit->getTotalPersen($modelBibit->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
<?php $this->endWidget(); ?>