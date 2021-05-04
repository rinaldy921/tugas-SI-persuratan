<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-non-produktif-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
// 'filter'=>$model,
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'name' => 'id',
            'header' => 'Jenis Areal',
            'value' => '"Areal Tidak Efektif"'
        ),
        array(
            'header' => 'Jumlah (Ha)',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
//			'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputNonProduktif')),
        ),
    ),
));
?>