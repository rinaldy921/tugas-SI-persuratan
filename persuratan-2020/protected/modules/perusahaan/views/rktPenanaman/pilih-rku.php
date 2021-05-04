<div id="select-rku">
<h4>Data RKU Penanaman</h4>
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
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Daur',
            'value' => '$data->daur',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
         array(
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Jumlah (ha)',
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right',)
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
                        return 'javascript:toggleFormRKTByRKU("#select-rku","#form-rkt","'.$this->createUrl('//perusahaan/rktPenanaman/formRktMatch/rku/'.$data->id).'");';
                    },
                ),
            ),
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        )
    ),
));
?>
</div>
<div id="form-rkt">
    
</div>
