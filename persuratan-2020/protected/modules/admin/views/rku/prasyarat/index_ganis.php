<?php
$listPendidikan = CHtml::listData(MasterPendidikan::model()->findAll(), 'id_pendidikan', 'pendidikan');
$listKewarganegaraan = CHtml::listData(MasterJenisKewarganegaraan::model()->findAll(), 'id', 'kewarganegaraan');

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'ganis-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'is_tenaga_kehutanan',
            'value' => function($data){
                if($data->is_tenaga_kehutanan == '1') return 'Tenaga Professional Kehutanan';
                else return 'Tenaga Professional Lainnya';
            },
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'is_tenaga_tetap',
            'value' => function($data){
                if($data->is_tenaga_tetap == '1') return 'Tenaga Tetap';
                else return 'Tenaga Tidak Tetap';
            }
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_kewarganegaraan',
            'value' => '$data->idJenisKewarganegaraan->kewarganegaraan',
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_pendidikan',
            'value' => '$data->idPendidikan->pendidikan',
        ),                
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Org)',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuSerapanTenagaKerja::model()->getTotal($model->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    ),
));
?>