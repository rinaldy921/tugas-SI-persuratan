<div id="select-rku">
<h4>Data RKU Pemanenan</h4>
<?php

//$url = $this->createUrl('//perusahaan/rktPembibitan/form-rkt-match');

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        /* array(
          'header' => 'No.',
          'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
         * $this->grid->dataProvider->pagination->pageSize) + 1',
          ), */
        array(
            'header' => 'Daur',
            'value' => '$data->daur'
        ),
        array(
            'header' => 'Blok Kerja Tahun Ke',
            'value' => '$data->rkt_ke'
        ),
        //'daur',
        //'tahun',
        array(
            'header' => 'Sektor',
            'value' => '$data->idBlok->namaSektor->nama_sektor'
        ),
        array(
            'header' => 'Blok',
            'value' => '$data->idBlok->nama_blok'
        ),        
        //'$data->idBlok->idBlok->nama_blok',            
        //'id_jenis_produksi_lahan',
        //'id_jenis_lahan',
        array(
            'header' => 'Luas (Ha)',
            'value' => '$data->jumlah'
        ),
        array(
            'header' => 'Produksi (M3)',
            'value' => '$data->produksi'
        ),        
        //''r
        array(
            'class'=> 'booster.widgets.TbButtonColumn',
            'template' => '{pilih}',
            'htmlOptions' => array('style' => 'width:100px', "text-align" => "center"),
            'buttons' => array(
                'pilih' => array(
                    'options' => array('data-toggle' => 'tooltip', 'title' => 'Pilih RKU'),
                    'label' => '<i class="fa fa-edit"></i>',                    
                    'url' => function($data){
                        return 'javascript:toggleFormRKTByRKU("#select-rku","#form-rkt","'.$this->createUrl('//perusahaan/rktPemanenan/formRktMatch/rku/'.$data->id).'");';
                    },
                ),
            )
        )
    ),
));
?>
</div>
<div id="form-rkt">
    
</div>
