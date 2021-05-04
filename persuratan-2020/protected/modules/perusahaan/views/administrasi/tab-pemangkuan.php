<?php

if (Yii::app()->user->hasIuphhk()) {
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('createPemangkuanHutan'), array('class' => 'btn btn-primary btn-sm'));
}

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-pemangkuan-grid',
    'type' => 'bordered condensed',
   // 'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $pemangkuan->search(),
//    'filter' => $pemangkuan,
    'mergeColumns' => array('dinhut_prov'),
    'enableSorting'=> false,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        array(
            'name' => 'dinhut_prov',
            'header' => 'Dishut Provinsi',
            'value' => '$data->dinhutProv->nama',
        ),
        array(
            'name' => 'dinhut_kab',
            'header' => 'Kabupaten',
            'value' => '$data->dinhutKab->nama',
        ),
        array(
            'name' => 'id_kph',
            'header' => 'KPH',
            'value' => '$data->idKph->nama_kph',
        ),
        array(
            'name' => 'bkph',
        ),
        array(
            'name' => 'rph',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn', 'htmlOptions' => array('nowrap' => 'nowrap'),
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/delPemangkuanHutan",array("id"=>$data->id))',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updatePemangkuanHutan",array("id"=>$data->id))',
                )
            )
        ),
    ),
));
?>