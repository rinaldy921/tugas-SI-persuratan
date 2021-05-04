<?php echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('createBatas'), array('class' => 'btn btn-primary btn-sm')); ?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-tata-batas-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $tata_ruang->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_blok',
            'header' => 'Blok',
            'value' => '$data->idBlok->nama_blok',
        ),
        array(
            'name' => 'jumlah',
            'value' => '$data->jumlah ? $data->jumlah . " Km" : "-"',
        ),
        array(
            'header' => 'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
//            'value' => 'isset($data->nilai_tes) ? $data->nilai_tes : "<i class=\'fa fa-pencil\' data-toggle=\'tooltip\' data-original-title=\'Input Nilai tes\'></i>"',
            'editable' => array(
                'url' => $this->createUrl('/perusahaan/rkuPersyaratan/inputJumlah'),
            ),
        ),
    )
));
?>