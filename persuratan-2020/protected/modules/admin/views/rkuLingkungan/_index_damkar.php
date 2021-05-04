<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-damkar-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_damkar',
            'header' => 'Jenis Alat',
            'value' => '$data->idDamkar->jenis_dalkar'
        ),
        array(
            'name' => 'jumlah',
            'type' => 'raw',
        ),
        array(
            'name' => 'keterangan',
        ),
    )
));
?>
