<div id="select-rku">
<h4>Data RKU Penanaman</h4>
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
            'header' => 'Unit Kelestarian',
            'value' => '$data->idBlok->namaSektor->nama_sektor'
        ),
        array(
            'header' => 'Petak Kerja',
            'value' => '$data->idBlok->nama_blok'
        ),
        array(
            'header' => 'Tata Ruang',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi'
        ),
        array(
            'header' => 'Jenis Lahan',
            'value' => '$data->idJenisLahan->jenis_lahan'
        ),
        array(
            'header' => 'Jumlah (ha)',
            'value' => '$data->jumlah'
        ),
        //'$data->idBlok->idBlok->nama_blok',            
        //'id_jenis_produksi_lahan',
        //'id_jenis_lahan',
        //'jumlah',
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
                        return 'javascript:toggleFormRKTByRKU("#select-rku","#form-rkt","'.$this->createUrl('//perusahaan/rktPenanaman/formRktMatch/rku/'.$data->id).'");';
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
