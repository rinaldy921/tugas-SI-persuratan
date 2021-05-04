<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kerjasamakoperasi-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'header' => 'Uraian',
            'value' => '"Kerjasama Koperasi"',
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah (Unit)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktsosKerjasamaKoperasi/editJumlahKerjasamaKoperasi')),
        ),
        array(
            'name' => 'keterangan',
            'header' => 'Keterangan',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
            'class' => 'booster.widgets.TbEditableColumn',
            'type' => 'raw',
            'editable' => array('url' => $this->createUrl('/perusahaan/rktsosKerjasamaKoperasi/editJumlahKerjasamaKoperasi')),
        ),
        //'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    // 'options'=>array(
                    //     'id'=>'delete-kerjasamakoperasi'.time(),
                    // ),
                    'url' => 'Yii::app()->createUrl("/perusahaan/rktsosKerjasamaKoperasi/deleteKerjasamaKoperasi",array("id"=>$data->id))',
                ),
            )
        ),
    )
));
?>
