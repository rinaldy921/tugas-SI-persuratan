<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-naker-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'mergeColumns' => array('is_tenaga_kehutanan', 'is_tenaga_tetap', 'id_jenis_kewarganegaraan'),    
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'enableSorting' => false,
    'template' => '{items}',
//    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'is_tenaga_kehutanan',
            'header' => 'Jenis Tenaga',
            'value' => function($data) {
                if ($data->is_tenaga_kehutanan == '1')
                    return 'Tenaga Professional Kehutanan';
                else
                    return 'Tenaga Professional Lainnya';
            }
        ),
        array(
            'name' => 'is_tenaga_tetap',
            'header' => 'Status',
            'value' => function($data) {
                if ($data->is_tenaga_tetap == '1')
                    return 'Tenaga Tetap';
                else
                    return 'Tenaga Tidak Tetap';
            }
        ),
        array(
            'name' => 'id_jenis_kewarganegaraan',
            'header' => 'Kewarganegaraan',
            'value' => '$data->idJenisKewarganegaraan->kewarganegaraan',
        ),
        array(
            'name' => 'id_pendidikan',
            'header' => 'Pendidikan',
            'value' => '$data->idPendidikan->pendidikan',
        ),
        array(
            'header' => 'Jumlah (Org)',
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
//            'type' => 'raw',
//            'footer' => RkuKawasanLindung::model()->getTotal($model->search()->getData(), 'jumlah') . ' Ha',
//            'editable' => array('url' => $this->createUrl('//perusahaan/rktprasTenagaKerja/inputSerapanNaker')),
        ),
        array(
            'header' => 'Realisasi (Org)',
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'realisasi',
//            'type' => 'raw',
//            'footer' => RkuKawasanLindung::model()->getTotal($model->search()->getData(), 'jumlah') . ' Ha',
//            'editable' => array('url' => $this->createUrl('//perusahaan/rktprasTenagaKerja/inputSerapanNaker')),
        ),
        array(
            'header' => 'Persentase (%)',
//            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'persentase',
//            'type' => 'raw',
//            'footer' => RkuKawasanLindung::model()->getTotal($model->search()->getData(), 'jumlah') . ' Ha',
//            'editable' => array('url' => $this->createUrl('//perusahaan/rktprasTenagaKerja/inputSerapanNaker')),
        ),
//        array(
//            'class' => 'booster.widgets.TbButtonColumn',
//            'template' => '{delete}',
//            'buttons' => array(
//                'delete' => array(
//                    // 'options'=>array(
//                    //     'id'=>'delete-inframukim'.time(),
//                    // ),
//                    'url' => 'Yii::app()->createUrl("/perusahaan/rktprasTenagaKerja/deleteNaker",array("id"=>$data->id))',
//                ),
//            )
//        ),
        // array(
        //     'header'=>'',
        //     'type'=>'raw',
        //     'value'=>function($data){
        //         return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
        //             'class'=>'deleteInFunction',
        //             'onclick'=>'deleteData(this)', 
        //             'data-url'=> Yii::app()->createUrl("/perusahaan/rktprasTenagaKerja/deleteNaker",array("id"=>$data->id))
        //         ));
        //     }
        // ),                
    )
));
?>