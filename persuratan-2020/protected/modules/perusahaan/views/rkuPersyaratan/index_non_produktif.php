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
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id',
            'header' => 'Jenis Areal',
            'value' => '"Areal Tidak Efektif"'
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Ha)',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'value'=>function ($data) {
                return number_format($data->jumlah,2,',','.');
            },
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('//perusahaan/rkuPersyaratan/inputNonProduktif')),
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
    ),
));
?>