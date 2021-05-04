<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-perambahan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'perlindungan',
            'header' => 'Jenis Perlindungan',
        ),
    )
));
?>
