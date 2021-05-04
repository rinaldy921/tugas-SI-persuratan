<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-konfliksosial-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelKonflikSosial->search(),
    'enableSorting' => false,
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        'jenis_konflik',
        'penanganan',
        array(
            'name' => 'status',
            'type' => 'raw',
        ),
    ),
));
?>