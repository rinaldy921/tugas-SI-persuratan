<p style="color:red"><strong>* Untuk pengisian koma (,) isikan dengan titik (.)</strong></p>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'tata-batas-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'enableSorting'=>false,
// 'filter'=>$model,
'template' => '{items}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
		// 'id_jenis_batas',
        array(
            'name' => 'id_jenis_batas',
            'value' => '$data->idJenisBatas->jenis_batas',
            'footer' => '<strong>Total</strong>'
        ),
		array(
            // 'header'=>'Rencana',
            'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'jumlah',
            'type'=>'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,2,",",".") : ""',
            // 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
            'editable'=> array('url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahTataBatas'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("tata-batas-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
                }',
                'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
            ),
            'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
        ),
        // 'realisasi',
        /*array(
            // 'header'=>'Realisasi',
            'class'=>'booster.widgets.TbEditableColumn',
            'name'=>'realisasi',
            'type'=>'raw',
            'value' => '!empty($data->realisasi) ? number_format($data->realisasi,2,",",".") : ""',
            // 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
            'editable'=> array(
                'url'=>$this->createUrl('//perusahaan/rktGanis/inputJumlahTataBatas'),
                'success'=>'js:function() {
                    $.fn.yiiGridView.update("tata-batas-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
                }',
                'onShown' => 'js: function(e, editable) {
                    var isi = editable.value.replace(".", "");
                    var isi = isi.replace(",", ".");
                    var tip = $(this).data("editableContainer").tip();
                    tip.find("input").val(isi);
                }'
            ),
            'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
        ),
        array(
            // 'header'=>'%',
            'name' => 'persentase',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            'value' => '!empty($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
        )
        */
        // array(
        //     'class'=>'booster.widgets.TbButtonColumn',
        //     'buttons' => array(
        //         'update' => array(
        //             'url' => 'Yii::app()->createUrl("//perusahaan/rktGanis/updateTataBatas",array("id"=>$data->id))',
        //         ),
        //         'delete' => array(
        //             'url' => 'Yii::app()->createUrl("//perusahaan/dirkom/delTataBatas",array("id"=>$data->id))',
        //         )
        //     )
        // ),
),
)); ?>