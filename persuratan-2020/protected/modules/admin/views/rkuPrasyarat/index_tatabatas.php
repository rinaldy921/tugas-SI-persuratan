<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-tata-batas-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    'enableSorting' => true,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_batas',
            'header' => 'Jenis Batas',
            'value' => '$data->idJenisBatas->jenis_batas',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Km)',
            'name' => 'jumlah',
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
//          'value' => '$data->jumlah ? $data->jumlah . " Km" : "-"',
            'value' => '$data->jumlah',
            'footer' => '<strong>' . number_format(RkuTataBatas::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . ' </strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        )
    )
));
?>