<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-batuan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $batuan->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_batuan',
        'keterangan'
    ),
));
?>