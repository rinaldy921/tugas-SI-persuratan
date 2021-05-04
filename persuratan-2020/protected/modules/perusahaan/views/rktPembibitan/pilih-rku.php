<div id="select-rku">
<h4>Data RKU Pengadaan Bibit</h4>
<?php

//$url = $this->createUrl('//perusahaan/rktPembibitan/form-rkt-match');

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->searchByRkt(),
    //'filter' => $model,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
            * $this->grid->dataProvider->pagination->pageSize) + 1',
            'htmlOptions' => array('style' => 'text-align:center')
        ), 
        array(
            'header' => 'Daur',
            'value' => '$data->daur',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        //'daur',
        //'tahun',
        array(
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'htmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'header' => 'Jumlah (Btg)',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right'),
        ),
        array(
            'header' => 'Pilih',
            'class'=> 'booster.widgets.TbButtonColumn',
            'template' => '{pilih}',
            'htmlOptions' => array('style' => 'width:100px', "text-align" => "center"),
            'buttons' => array(
                'pilih' => array(
                    'options' => array('data-toggle' => 'tooltip', 'title' => 'Pilih RKU'),
                    'label' => '<i class="fa fa-edit"></i>',                    
                    'url' => function($data){
                        return 'javascript:toggleFormRKTByRKU("#select-rku","#form-rkt","'.$this->createUrl('//perusahaan/rktPembibitan/formRktMatch/rku/'.$data->id).'");';
                    },
                ),
            ),
            'htmlOptions' => array('style' => 'text-align:center')
        )
    ),
));
?>
</div>
<div id="form-rkt">
</div>
