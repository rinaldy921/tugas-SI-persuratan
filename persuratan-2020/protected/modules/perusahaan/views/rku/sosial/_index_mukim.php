<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-pemukiman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_infra_mukim',
            'header' => 'Jenis',
            'value' => '$data->idInfraMukim->nama_sarana',
        ),
        array(
            'header' => 'Rencana',
            'name' => 'jumlah',
            'type' => 'raw',
        ),
    )
));
?>
