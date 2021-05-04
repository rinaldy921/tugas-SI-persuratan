<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'mergeColumns' => array('jenis_legalitas'),
    'enableSorting' => false,
    'template' => '{summary}{items}{pager}',
    'columns' => array(
        array(
            'name' => 'jenis_legalitas',
        ),
        array(
            'name' => 'notaris',
        ),
        array(
            'name' => 'nomor',
        ),
        array(
            'name' => 'tanggal',
            'value' => 'Yii::app()->controller->getDateMonth($data->tanggal)'
        ),
        array(
            'name' => 'perubahan_ke',
            'value' => '$data->jenis_legalitas=="Akte Perubahan" ? $data->perubahan_ke : ""'
        )
    ),
));
?>