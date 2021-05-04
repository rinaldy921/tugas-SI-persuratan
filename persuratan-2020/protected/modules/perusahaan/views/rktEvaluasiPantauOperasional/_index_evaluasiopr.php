<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createGanis'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id.'-evaluasipantauoperasional-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'enableSorting'=>false,
// 'filter'=>$model,
'template' => '{items}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
        array(
            'name' => 'id_ganis',
            'value' => '$data->idGanis->nama_jenis',
            'footer' => '<strong>Total</strong>'
        ),
		// 'id_ganis',
		array(
            // 'header'=>'Rencana',
            'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'jumlah',
            'type'=>'raw',
            // 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
            'editable'=> array('url'=>$this->createUrl('//perusahaan/RktEvaluasiPantauOperasional/inputJumlahGanisOpr'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-evaluasipantauoperasional-grid");
                }'
            ),
            'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
        ),
        // 'realisasi',
        array(
            'header'=>'Realisasi',
            'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'realisasi',
            'type'=>'raw',
            // 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
            'editable'=> array('url'=>$this->createUrl('//perusahaan/RktEvaluasiPantauOperasional/inputJumlahGanisOpr'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-evaluasipantauoperasional-grid");
                }'
            ),
            'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
        ),
        array(
            // 'header'=>'%',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? $data->persentase : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
        )
        // array(
        //     'class'=>'booster.widgets.TbButtonColumn',
        //     'buttons' => array(
        //         'update' => array(
        //             'url' => 'Yii::app()->createUrl("//perusahaan/rktGanis/updateGanis",array("id"=>$data->id))',
        //         ),
        //         'delete' => array(
        //             'url' => 'Yii::app()->createUrl("//perusahaan/rktGanis/delGanis",array("id"=>$data->id))',
        //         )
        //     )
        // ),
),
)); ?>