<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-mata-air-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $mataAir->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_mata_air',
        'keterangan',
    ),
));
?>