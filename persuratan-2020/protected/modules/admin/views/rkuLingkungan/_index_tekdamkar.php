<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-tekdam-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'metode',
            'header' => 'Metode',
        ),
        array(
            'name' => 'kondisi_kebakaran',
            'header' => 'Kondisi Sumber Kebakaran',
        ),
        array(
            'name' => 'cara',
            'header' => 'Cara Penanganan dan Prasarana',
        ),
    )
));
?>
