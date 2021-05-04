<a id="buton_new" class="btn btn-primary btn-sm" href="javascript:addNonKayu()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Baru</a>

<?php $this->widget('booster.widgets.BootGroupGridView',array(
'id'=>'rktBibit-nonkayu-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'enableSorting'=>false,
'mergeColumns'=>array('id_jenis_lahan','id_jenis_produksi_lahan','sektor'),
'extraRowColumns'=> array('id_jenis_lahan'),
'extraRowTotals'=>function($data, $row, &$totals) {
     if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
     if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
     if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
     $totals['jumlah'] += $data['jumlah'];
     $totals['realisasi'] += $data['realisasi'];
     $totals['persentase'] += $data['persentase'];
     $totals['pe'] += 1;
 },
 'extraRowPos' => 'below',
 // 'extraRowExpression' => '"<span class=\"subtotal\">avg age - ".round($totals["jumlah"],2)."</span>"',
'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
    <td class=\"nipz-red text-left\" colspan=\"5\"><strong><i>Sub Total</i></strong></td>
    <td class=\"nipz-red\">".number_format($totals["jumlah"],2,",",".")."</td>
    <td class=\"nipz-red\">".number_format($totals["realisasi"],2,",",".")."</td>
    <td class=\"nipz-red\">".number_format($totals["realisasi"] > 0 ? ($totals["realisasi"] / $totals["jumlah"]) * 100 : 0,2,",",".")."</td>"
',
// 'filter'=>$model,
'template' => '{items}',
'columns'=>array(
    // 'id',
    // 'id_rkt',
    // 'id_blok',
    // array(
    // 	'name'=>'id_blok',
    // 	'value'=>'$data->idBlok->idBlok->nama_blok'
    // ),
    array(
        'name'=>'id_jenis_lahan',
        'value'=>'$data->idJenisLahan->jenis_lahan',
        'footer' => '<strong>Total</strong>'
    ),
    array(
        'name'=>'id_jenis_produksi_lahan',
        'value'=>'$data->idJenisProduksiLahan->jenis_produksi',
    ),
    array(
    	'name'=>'sektor',
    	'value'=>'$data->idBlok->idSektor->nama_sektor'
    ),
    array(
    	'name'=>'id_blok',
    	'value'=>'$data->idBlok->idBlok->nama_blok'
    ),
    array(
        'name'=>'id_hasil_hutan_nonkayu',
        'value'=>'$data->idHasilHutanNonkayu->nama_hhbk',

    ),
    // array(
    //     'name'=>'id_satuan_volume_nonkayu',
    //     'value'=>'$data->idSatuanVolumeNonkayu->satuan'
    // ),
    // 'jumlah',
    // 'realisasi',
    array(
        'header'=>'Rencana',
        // 'class'=>'booster.widgets.TbEditableColumn',
        'name'=>'jumlah',
        // 'visible'=>false,
        // 'type'=>'raw',
        'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",","."). " (".$data->idSatuanVolumeNonkayu->satuan.")" : ""',
        // 'editable'=> array('url'=>$this->createUrl('//perusahaan/rktBibit/inputJumlahNonKayu'),
        //     'success'=>'js:function() {
        //         $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-nonkayu-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
        //     }'
        // ),
        'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
    ),
    array(
        // 'header'=>'Realisasi',
        // 'class'=>'booster.widgets.TbEditableColumn',
        'name'=>'realisasi',
        // 'visible'=>false,
        'type'=>'raw',
        'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",","."). " (".$data->idSatuanVolumeNonkayu->satuan.")" : "0 (".$data->idSatuanVolumeNonkayu->satuan.")"',
        // 'editable'=> array('url'=>$this->createUrl('//perusahaan/rktBibit/inputJumlahNonKayu'),
        //     'success'=>'js:function() {
        //         $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-nonkayu-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
        //     }'
        // ),
        // 'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
    ),
    array(
        // 'header'=>'%',
        // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
        // 'class'=>'TbPercentOfTypeEasyPieOperation'
        'name'=>'persentase',
        'value'=>'isset($data->persentase) ? number_format($data->persentase,2,",",".") : "0"',
        'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
    ),
    array(
        'class' => 'booster.widgets.TbButtonColumn',
        'template'=>'{update} {delete}',
        'buttons'=>array(
            'update' => array(
                'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit'),
                'label' => '<i class="fa fa-edit"></i>',
                'url' => function ($data) {
                    $_url = 'javascript:editNonKayu("' . $data->id . '")';
                    return $_url;
                },
            ),
            'delete' => array(
                'url' => function ($data) {
                    $_url = Yii::app()->createUrl("perusahaan/rktBibit/deleteDeleteNonKayu", array("id" => $data->id));
                    return $_url;
                },
            )
        ),
    ),
    // array(
    //     'class' => 'booster.widgets.TbButtonColumn',
    //     'template' => '{edit} {delete}',
    //     'buttons' => array(
    //         'edit' => array(
    //             'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit' ),
    //             'label' => '<i class="fa fa-edit"></i>',
    //            'url'=> function ($data) {
    //                $_url = 'javascript:editNonKayu('.$data->id.')';
    //                return $_url;
    //            },
    //         ),
    //         'delete' => array(
    //            'url'=> function ($data) {
    //                $_url = Yii::app()->createUrl("perusahaan/rktBibit/deleteDeleteNonKayu", array("id"=>$data->id));
    //                return $_url;
    //            },
    //         )
    //     )
    // ),

),
)); ?>

<script type="text/javascript">
    function addNonKayu() {
        var url = "<?php echo $this->createUrl('//perusahaan/rktBibit/formNonKayu', array('id' => $model->id_rkt));?>";
        var title = "Tambah Data Hasil Hutan Non Kayu";
        showModal(url,title);
    }

    function editNonKayu(id)
    {
        var url = "<?php echo $this->createUrl('//perusahaan/rktBibit/formNonKayu', array('id' => $model->id_rkt));?>?id_pk="+id;
        var title = "Edit Data Hasil Hutan Non Kayu";
        showModal(url,title);
    }
</script>
