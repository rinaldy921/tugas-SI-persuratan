<?php

$prop = CHtml::listData(Provinsi::model()->findAll(array('select' => 'id_provinsi, nama')), 'id_provinsi', 'nama');
$prop[""] = Yii::t('app', 'Pilih Provinsi...');
if (Yii::app()->user->hasIuphhk()) {
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('createPemerintahan'), array('class' => 'btn btn-primary btn-sm'));
}

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-pemerintahan-grid',
    'type' => 'bordered condensed',
    // 'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $pemerintahan->search(),
    'mergeColumns' => array('provinsi','kabupaten'),
//    'filter' => $pemerintahan,
    'enableSorting' => false,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
//        'id_iuphhk',
        array(
            'name' => 'provinsi',
            'filter' => CHtml::dropDownList(get_class($pemerintahan) . '[provinsi]', $pemerintahan->provinsi, $prop, array('class' => 'form-control')),
            'value' => '$data->provinsi0->nama',
        ),
        array(
            'name' => 'kabupaten',
            'value' => 'isset($data->kabupaten) ? $data->kabupaten0->nama : null'
        ),
        array(
            'name' => 'kecamatan',
            'value' => 'isset($data->kecamatan) ? $data->kecamatan0->nama : null'
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn', 'htmlOptions' => array('nowrap' => 'nowrap'),
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/delPemerintahan",array("id"=>$data->id))',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updatePemerintahan",array("id"=>$data->id))',
                )
            )
        ),
    ),
));
?>