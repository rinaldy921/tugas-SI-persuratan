<?php

$this->widget('booster.widgets.TbGroupGridView', array(
    'id' => Yii::app()->controller->id . '-mata-air-grid',
    'type' => 'bordered condensed',
    'responsiveTable' => true,
    'dataProvider' => $model,
    'mergeColumns' => array('total', 'grade', 'rekom'),
    'template' => '{items}',
    'mergeCellCss' => 'vertical-align: middle;text-align:center;',
    'columns' => array(
        array(
            'name' => 'aspek',
            'header' => 'Aspek',
        ),
        array(
            'name' => 'bobot',
            'header' => 'Bobot',
        ),
        array(
            'name' => 'kpi',
            'header' => 'Kriteria',
        ),
        array(
            'name' => 'nilai',
            'header' => 'Nilai',
        ),
        array(
            'name' => 'total',
            'header' => 'Total Nilai',
        ),
        array(
            'name' => 'grade',
            'header' => 'Grade/Mark',
        ),
        array(
            'name' => 'rekom',
            'header' => 'Rekomendasi',
        )
    )
));
?>