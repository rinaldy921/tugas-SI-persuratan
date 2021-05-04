<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-pwh-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => FALSE,
    // 'filter' => $model,
    'columns' => array(
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'name' => 'id_jenis_pwh',
            'header' => 'Jenis Pembukaan',
            'value' => '$data->idJenisPwh->jenis_pembukaan',
            'footer' => '<strong>Total</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Jumlah (Km)',
            'name' => 'jumlah',
            'type' => 'raw',
            'value'=>function ($data) {
                    return number_format($data->jumlah,2,',','.');
            },
            'htmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
            'footer' => '<strong>' . number_format(RkuPwh::model()->getTotal($model->search()->getData(), 'jumlah'),2,",",".") . '</strong>',
            'footerHtmlOptions' => array('style' => 'text-align:right; vertical-align:middle'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align:middle'),
            'header' => 'Keterangan',
            'name' => 'keterangan',
        )
    )
));
?>