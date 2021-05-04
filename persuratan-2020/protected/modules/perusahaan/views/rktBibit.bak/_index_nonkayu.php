<a id="buton_new" class="btn btn-primary btn-sm" href="javascript:addNonKayu()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Baru</a>

<?php $this->widget('booster.widgets.BootGroupGridView',array(
'id'=>Yii::app()->controller->id . '-nonkayu-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'enableSorting'=>false,
'mergeColumns'=>array('id_hasil_hutan_nonkayu'),
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
        'name'=>'id_hasil_hutan_nonkayu',
        'value'=>'$data->idHasilHutanNonkayu->nama_hhbk',
        'footer' => '<strong>Total</strong>'
    ),
    // array(
    //     'name'=>'id_satuan_volume_nonkayu',
    //     'value'=>'$data->idSatuanVolumeNonkayu->satuan'
    // ),
    // 'jumlah',
    // 'realisasi',
    array(
        // 'header'=>'Realisasi',
        // 'class'=>'booster.widgets.TbEditableColumn',
        'name'=>'jumlah',
        // 'visible'=>false,
        'type'=>'raw',
        'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",","."). " (".$data->idSatuanVolumeNonkayu->satuan.")" : ""',
        // 'editable'=> array('url'=>$this->createUrl('//perusahaan/rktBibit/inputJumlahNonKayu'),
        //     'success'=>'js:function() {
        //         $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-nonkayu-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
        //     }'
        // ),
        // 'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
    ),
    array(
        // 'header'=>'Realisasi',
        // 'class'=>'booster.widgets.TbEditableColumn',
        'name'=>'realisasi',
        // 'visible'=>false,
        'type'=>'raw',
        'value' => '!empty($data->realisasi) ? number_format($data->realisasi,0,",","."). " (".$data->idSatuanVolumeNonkayu->satuan.")" : ""',
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
        'template' => '{edit} {delete}',
        'buttons' => array(
            'edit' => array(
                'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit' ),
                'label' => '<i class="fa fa-edit"></i>',
               'url'=> function ($data) {
                   $_url = 'javascript:editNonKayu('.$data->id.')';
                   return $_url;
               },
            ),
            'delete' => array(
               'url'=> function ($data) {
                   $_url = Yii::app()->createUrl("perusahaan/rktBibit/deleteDeleteNonKayu", array("id"=>$data->id));
                   return $_url;
               },
            )
        )
    ),
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
),
)); ?>

<div id="modal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%;">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button> -->
          <h4 class="modal-title" id="modalTitle"></h4>
        </div>
        <div class="modal-body" id="modalBody">
            Loading ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary" id="modalBtnSave">Save changes</button> -->
        </div>
      </div>
    </div>
</div>

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

    function showModal(url,title) {
        $("#modalTitle").empty();
        $("#modalTitle").html(title);

        $("#modalBody").empty();
        $("#modalBody").html("Loading ...");
        $("#modalBody").load(url);

        $('#modal').modal({backdrop: 'static', keyboard: false});
        $("#modal").modal("show");
        return false;
    }
</script>
