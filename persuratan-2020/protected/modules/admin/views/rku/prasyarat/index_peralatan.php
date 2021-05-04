
<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-peralatan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_peralatan',
            'header' => 'Nama Peralatan',
            'value' => '$data->nama_peralatan',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,0,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuPeralatan::model()->getTotal($model->search()->getData(), 'jumlah'),0,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Keterangan',
            'name' => 'keterangan',
        ),
    )
));
?>