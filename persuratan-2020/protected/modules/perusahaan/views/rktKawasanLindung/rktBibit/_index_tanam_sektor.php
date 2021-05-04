<div class="row" style="margin-top: 1em">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Entry Data RKT Penanaman <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="link-menu" href="javascript:;" onclick="entry_rkt_by_rku()">Sesuai RKU</a></li>
            <li><a class="link-menu"  href="javascript:;" onclick="show_form_alasan()">Tidak Sesuai RKU</a></li>            
        </ul>
    </div>
</div>    


<?php

$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rkt-penanaman-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'mergeColumns' => array('daur', 'Sektor', 'Blok', 'id_jenis_produksi_lahan', 'id_jenis_lahan'),
// 'filter'=>$model,
    'template' => '{items}',
    'columns' => array(
        'daur',
        array(
            'name' => 'Sektor',
            'value' => '$data->idBlok->idSektor->nama_sektor',
        ),
        array(
            'name' => 'Blok',
            'value' => '$data->idBlok->idBlok->nama_blok',
        ),
        array(
            'name' => 'id_jenis_produksi_lahan',
            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
        ),
        array(
            'name' => 'id_jenis_lahan',
            'value' => '$data->idJenisLahan->jenis_lahan',
        ),
        array(
            'name' => 'id_jenis_tanaman',
            'value' => '$data->idJenisTanaman->nama_tanaman'
        ),
        //'jumlah',
        array(
            // 'header'=>'Jumlah',
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jumlah',
            'type' => 'raw',
            'value' => '!empty($data->jumlah) ? number_format($data->jumlah,0,",",".") : ""',
            'editable' => array('url' => $this->createUrl('//perusahaan/rktBibit/inputJumlahBibit'),
                'success' => 'js:function() {
	                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-bibit-grid",{data:"aksi=updateGrid&tahun=' . $tahun . '"});
	            }'
            ),
            //'footer' => '<strong>' . $model->getTotal($model->search()->getData(), 'jumlah') . '</strong>',
        ),
        array(
            'header' => 'Keterangan',
            'name' => 'rkumatch',
            'value' => function($data){
                if(empty($data->id_rku_tanam)) return "Tidak Sesuai RKU";
                return "Sesuai RKU";
            }//'$data->idJenisTanaman->nama_tanaman'
        ),        
    ),
));
?>


<script type="text/javascript">

    function show_form_alasan()
    {
        var thn = $("#Rkt_tahun_mulai").val();
        var url = "<?php echo $this->createUrl('//perusahaan/inputRKT/formAlasanTanam'); ?>" + "tahun/" + thn;
        var title = "Tambah Data RKT Penanaman (Tidak Sesuai RKU)";
        showModal(url, title);
    }

    function entry_rkt_by_rku()
    {
        var thn = $("#Rkt_tahun_mulai").val();
        //alert(thn);
        var url = "<?php echo $this->createUrl('//perusahaan/inputRKT/formRKTTanamByRKU'); ?>" + "tahun/" + thn;
        var title = "Entry RKT Penanaman Sesuai Data RKU";
        showModal(url, title);
    }
</script>
