<script type="text/javascript">
    function generateTable(){
        var temp = '<tr>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Daur</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Jenis Pemasaran</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Rencana (M³)</th>';
        temp += '<th colspan=\'3\' style=\'text-align: center; vertical-align: middle\'>Realisasi</th>';
        temp += '<th rowspan=\'2\' style=\'text-align: center; vertical-align: middle\'>Persentase (%)</th>';
        temp += '</tr>';
        $('#<?=Yii::app()->controller->id?>-pasar-grid table thead').prepend(temp);
    }
    generateTable();
</script>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Pemasaran',
        'headerIcon' => 'save',
        'padContent' => false
    )
);?>
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>Yii::app()->controller->id . '-pasar-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider'=>$modelPasar->searchByRkt(),
    'enableSorting'=>false,
    'template' => '{items}',
    'columns'=>array(
        array(
            'header' => 'Daur',
            'name' => 'daur',
            'value'=>'$data->idRktPasar->daur',
            'headerHtmlOptions' => array('class' => 'hidden'),
//            'footer' => '<strong>Total</strong>'
        ),
        array(
            'name'=>'id_pemasaran',
            'value'=>'$data->idRktPasar->idPemasaran->nama_pemasaran',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'footer' => '<strong>Total</strong>'
        ),
        array(
            'header'=>'Rencana (Btg)',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->idRktPasar->jumlah) ? number_format($data->idRktPasar->jumlah,2,",",".") : "0"',
            'footer' => '<strong>'.$modelPasar->getTotal($modelPasar->searchByRkt()->getData(), 'jumlah').'</strong>',
        ),
        array(
            'header'=>'sd Bulan Lalu',
            'value'=>'$data->sd_bulan_lalu',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
            'footer' => '<strong>'.$modelPasar->getTotal($modelPasar->searchByRkt()->getData(), 'sd_bulan_lalu').'</strong>',
        ),
        array(
            'header'=>'Bulan Ini',
            'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'realisasi',
            'type'=>'raw',
            'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
            'editable'=> array('url'=>$this->createUrl('//perusahaan/realisasiPemasaran/inputRealisasi'),
//                'success'=>'js:function(){
//                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-pasar-grid",{data:"aksi=updateGrid&tahun='. $tahun .'&id_bulan='. $id_bulan .'&tahun_periode='. $tahun_periode .'",complete:function(){
//                        setTimeout(function(){
//                            generateTable();
//                        }, 100)
//                    }});
//                }',
//                'onShown' => 'js: function(e, editable) {
//                    var isi = editable.value.replace(".", "");
//                    var isi = isi.replace(",", ".");
//                    var tip = $(this).data("editableContainer").tip();
//                    tip.find("input").val(isi);
//                }'
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
            'footer' => '<strong>'.$modelPasar->getTotal($modelPasar->searchByRkt()->getData(), 'realisasi').'</strong>',
        ),
        array(
            'header'=>'sd Bulan Ini',
            'value'=>'$data->sd_sekarang',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center; vertical-align: middle'
            ),
            'footer' => '<strong>'.$modelPasar->getTotal($modelPasar->searchByRkt()->getData(), 'sd_sekarang').'</strong>',
        ),
        array(
            'name'=>'persentase',
            'headerHtmlOptions' => array('class' => 'hidden'),
            'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$modelPasar->getTotal($modelPasar->searchByRkt()->getData(), 'persentase').'</strong>',
        )
    ),
)); ?>
<?php $this->endWidget(); ?>