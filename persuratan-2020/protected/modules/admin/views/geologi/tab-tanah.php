<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-tanah-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $tanah->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama',
        'keterangan'
    ),
));
?>