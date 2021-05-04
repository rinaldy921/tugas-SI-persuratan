<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'jumlah',
        'realisasi',
        array(
            'label' => 'Realisasi (%)',
            'value' => (isset($model->jumlah) && $model->jumlah > 0 && isset($model->realisasi) && $model->realisasi > 0) ? round(($model->realisasi / $model->jumlah) * 100, 2). ' %' : '-'
        )
    ),
));
?>