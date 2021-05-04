<?php
    
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-dalmakit-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}',
    // 'filter' => $model,
    'columns' => array(
        array(
            'name' => 'rencana',
            'header' => 'Rencana',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
//            'class' => 'booster.widgets.TbEditableColumn',
//            'type' => 'raw',
//            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPengendalianHama/editJumlahPengendalianHama')),
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah (Ha)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
//            'class' => 'booster.widgets.TbEditableColumn',
//            'type' => 'raw',
//            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPengendalianHama/editJumlahPengendalianHama')),
        ),
        array(
            'name' => 'realisasi',
            'header' => 'Realisasi',
        ),
        array(
            'name' => 'persentase',
            'header' => 'Persentase (%)',
        ),
        array(
            'name' => 'keterangan',
            'header' => 'Keterangan',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
//            'class' => 'booster.widgets.TbEditableColumn',
//            'type' => 'raw',
//            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPengendalianHama/editJumlahPengendalianHama')),
        ),
		
        /* array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/perusahaan/rktlingPengendalianHama/deletePengendalianHama",array("id"=>$data->id))',
                ),
            )
        ), */
		
//		
//		array(
//			'header'=>'',
//			'type'=>'raw',
//			'value'=>function($data){
//				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
//					'class'=>'deleteInFunction',
//					'onclick'=>'deleteData(this)', 
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rktlingPengendalianHama/deletePengendalianHama",array("id"=>$data->id))
//				));
//			}
//		),
    )
));
?>