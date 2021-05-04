<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-sungai-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $sungai->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_sungai',
        'keterangan',
    ),
));
?>