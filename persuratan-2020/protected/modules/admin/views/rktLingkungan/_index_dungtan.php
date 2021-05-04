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
            'header' => 'Rencana (Satuan)',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
//            'class' => 'booster.widgets.TbEditableColumn',
//            'type' => 'raw',
//            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPerlindunganHutan/editJumlahPerlindunganHutan')),
        ),
        array(
            'name' => 'jumlah',
            'header' => 'Jumlah',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
//            'class' => 'booster.widgets.TbEditableColumn',
//            'type' => 'raw',
//            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPerlindunganHutan/editJumlahPerlindunganHutan')),
        ),
        array(
            'name' => 'realisasi',
            'header' => 'Realisasi',
        ),
        array(
            'name' => 'persentase',
            'header' => 'Persentase (%)',
        ),
        /* array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/perusahaan/rktlingPerlindunganHutan/deletePerlindunganHutan",array("id"=>$data->id))',
                ),
            )
        ), */
        array(
            'name' => 'keterangan',
            'header' => 'Keterangan',
            //'value' => '$data->jumlah ? $data->jumlah . " meter" : "-"',
//            'class' => 'booster.widgets.TbEditableColumn',
//            'type' => 'raw',
//            'editable' => array('url' => $this->createUrl('/perusahaan/rktlingPerlindunganHutan/editJumlahPerlindunganHutan')),
        ),		
//        array(
//			'header'=>'',
//			'type'=>'raw',
//			'value'=>function($data){
//				return CHtml::link('<i class="glyphicon glyphicon-trash"></i>','',array(
//					'class'=>'deleteInFunction',
//					'onclick'=>'deleteData(this)', 
//					'data-url'=> Yii::app()->createUrl("/perusahaan/rktlingPerlindunganHutan/deletePerlindunganHutan",array("id"=>$data->id))
//				));
//			}
//		),
    )
));
?>