<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $permodalan,
    'attributes' => array(
        array(
            'name' => 'jenis',
            'label' => 'Status Permodalan',
            'value' => (!empty($permodalan)) ? (($permodalan->jenis == 'PMDN') ? 'Penanaman Modal Dalam Negeri (' . $permodalan->jenis . ')' : 'Penanaman Modal Asing (' . $permodalan->jenis . ')') : null,
        ),
    ),
));
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-saham-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'template' => '{summary}{items}{pager}',
    'columns' => array(
        array(
            'name' => 'nama_pemodal',
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah (%)'
        )
    ),
));
?>