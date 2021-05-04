<div id="select-rku">
<h4>Data RKU Pemanenan HHBK</h4>
<?php

//debug($model); die();

//$url = $this->createUrl('//perusahaan/rktPembibitan/form-rkt-match');

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
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
            'header' => 'Blok Kerja Tahun Ke',
            'name' => 'rkt_ke',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Tahun',
            'name' => 'tahun',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'name' => 'id_hasil_hutan_nonkayu_silvikultur',
            'header' => 'Tata Ruang',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idJenisProduksiLahan->jenis_produksi',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),
        array(
            'header' => 'Jenis HHBK',
            'name'   => 'nama_hhbk',
            'value' => '$data->idHasilHutanNonkayuSilvikultur->idHasilHutanNonkayu->nama_hhbk',
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:center',)
        ),   
        array(
            'header' => 'Luas (Ha)',
            'value'=>function ($data) {
                return number_format($data->luas,2,',','.');
            },
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'htmlOptions' => array('style' => 'text-align:right',)
        ),
        array(
            'header' => 'Produksi',
            'name' => 'Jumlah',
            'value' => '(!empty($data->jumlah)) ? number_format($data->jumlah,2,",","."). " " .$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan : ""',
//            'value' => '(!empty($data->jumlah)) ? $data->jumlah. "(".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" : "0 (".$data->idHasilHutanNonkayuSilvikultur->idSatuanVolumeNonkayu->satuan.")" ', 
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
                        return 'javascript:toggleFormRKTByRKU("#select-rku","#form-rkt","'.$this->createUrl('//perusahaan/rktPemanenanHhbk/formRktMatch/rku/'.$data->id).'");';
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
