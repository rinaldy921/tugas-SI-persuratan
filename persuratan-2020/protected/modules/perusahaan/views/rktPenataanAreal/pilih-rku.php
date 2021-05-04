<div id="select-rku">
<h4>Data RKU Penataan Areal Kerja</h4>
<?php

//$url = $this->createUrl('//perusahaan/rktPembibitan/form-rkt-match');

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model,
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
             'value' => function($data) {
                    return isset($data['daur']) ? $data['daur'] : "-";
                }
        ),
        'rkt_ke',
         array(
            'header' => 'Sektor',
            'value' => function($data) {
                    return isset($data['sektor']) ? $data['sektor'] : "-";
                }
             //   'value' => '$data->idBlok->namaSektor->nama_sektor'
        ),
        array(
            'header' => 'Blok',
            'value' => function($data) {
                    return isset($data['blok']) ? $data['blok'] : "-";
                }
        ),
        array(
            'header' => 'Tata Ruang',
            'value' => function($data) {
                    return isset($data['jenis']) ? $data['jenis'] : "-";
                }
        ),
        array(
            'header' => 'Luas (ha)',
            'value' => function($data) {
                    return isset($data['jumlah']) ? $data['jumlah'] : "-";
                }
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
                        return 'javascript:toggleFormRKTByRKU("#select-rku","#form-rkt","'.$this->createUrl('//perusahaan/rktPenataanAreal/formRktMatch/rku/'.$data['id']).'");';
                    },
                ),
            )
        )
    ),
));
?>
</div>
</div>
<div id="form-rkt">
    
</div>