<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-waduk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $waduk->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_waduk',
        'keterangan',
    ),
));
?>