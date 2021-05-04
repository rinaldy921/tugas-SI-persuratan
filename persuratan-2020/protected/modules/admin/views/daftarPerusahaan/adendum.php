<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
//    'filter' => false,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nomor_adendum',
        'tanggal',
        array(
            'name' => 'luas',
            'value' => 'isset($data->luas)? floatval($data->luas) . " Ha": "-"',
        ),
//        array(
//            'class' => 'booster.widgets.TbButtonColumn',
//            'template' => '{update} {delete}'
//        ),
    ),
));
?>