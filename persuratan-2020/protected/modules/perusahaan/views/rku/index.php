<?php
$rkuSk="SK Nomor : ";



if(isset(Yii::app()->session['rku_sk'])){
    $rkuSk= $rkuSk.' '.Yii::app()->session['rku_sk'];
}
else{
    $rkuSk="";
}

$this->breadcrumbs = array(
    'Rencana Kerja Umum'=>array('index'),
    $rkuSk
);

$ada = Rku::model()->findAll(array('condition'=>'status = 1 AND id_perusahaan = '.Yii::app()->user->idPerusahaan()));
?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>
        </div>
    </div>
</div>


<script type="text/javascript">
    function changeRKU(url, idRku)
    {   id = idRku;
        var form = new FormData($("#<?=Yii::app()->controller->id . '-form'?>")[0]);
              $.ajax({
                type: "GET",
                //data: 'id='+id,
                dataType: "json",
                //contentType: false,
                //processData: false,
                url: url,
                success: function(data) {
                    if(data.status == "sukses"){
                        
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
          
        
    }

</script>




<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Daftar Rencana Kerja Umum</h4>
    <?php
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah RKU Baru'), array('create'), array('class' => 'btn btn-primary btn-sm'));
        // if(empty($ada)) {
        // } else {
        //     echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary btn-sm','style'=>'display:none','id'=>'tombol'));
        // }
    ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
//        'filter' => $model,
        'enableSorting' => false,
        'emptyText' => 'Tidak ada data',
        'template' => '{items}{summary}{pager}',
        'columns' => array(
//		'id_rku',
//		'id_perusahaan',
            array(
                'name' => "Tahun",
                'value' => function($data) {
                    $awal = $data->tahun_mulai;
                    $akhir = $data->tahun_sampai;
                    return $awal .' s/d '.$akhir;
                }
            ),
            // 'tahun_mulai',
            // 'tahun_sampai',
            'nomor_sk',
            array(
                'name' => 'tgl_sk',
                'value' => 'isset($data->tgl_sk) ? Yii::app()->controller->getDateMonth($data->tgl_sk) : null'
            ),
            array(
                'name' => "Berlaku",
                'value' => function($data) {
                    $awal = isset($data->mulai_berlaku) ? Yii::app()->controller->getDateMonth($data->mulai_berlaku) : "-";
                    $akhir = isset($data->akhir_berlaku) ? Yii::app()->controller->getDateMonth($data->akhir_berlaku) : "-";
                    return $awal .' s/d '.$akhir;
                }
            ),
            array(
                'name' => 'id_kelas_perusahaan',
                'header' => 'Kelas Perusahaan',
                'value' => 'isset($data->idKelasPerusahaan->nama_kelas_perusahaan) ? $data->idKelasPerusahaan->nama_kelas_perusahaan : "" ',
            ),
            // array(
            //     'name'=>'mulai_berlaku',
            //     'value' => 'isset($data->mulai_berlaku) ? Yii::app()->controller->getDateMonth($data->mulai_berlaku) : null'
            // ),
            // array(
            //     'name'=>'akhir_berlaku',
            //     'value' => 'isset($data->akhir_berlaku) ? Yii::app()->controller->getDateMonth($data->akhir_berlaku) : null'
            // ),
            array(
                'name' => 'status',
                'value' => '$data->cekRev($data->id_perusahaan,$data->id_rku)'
            ),
             
            array(
                'header'=>'Used',
                'class' => 'booster.widgets.TbButtonColumn',
                'template'=>'{aktifasi}{deaktifasi}',
                'htmlOptions' => array('style'=>'width:50px', "text-align" => "center"),
                'buttons'=>array(
                    
                    'aktifasi' => array(
                        'label' => "<i class='glyphicon glyphicon-record'></i>",
                        'options' => array('title' => Yii::t('app', 'Perbaharui Data RKU'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/aktifasiRKU", array("id"=>$data->id_rku))',
                        'visible' => '$data->edit_status == 0 ? "1" : "0"'
                    ), 
                    'deaktifasi' => array(
                        'label' => "<i class='glyphicon glyphicon-ok-circle'></i>",
                        'options' => array('title' => Yii::t('app', 'RKU Sedang Diperbaharui'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'visible' => '$data->edit_status == 1 ? "1" : "0"'
                    ), 
                )
            ),
                    
            array(
                'header'=>'Aksi',
                'class' => 'booster.widgets.TbButtonColumn',
                'template'=>' {bloksektor} {revisi} {update} {delete} {telahDirevisi} {telahBerakhir} {file_1} {file_2}',
                'htmlOptions' => array('style'=>'width:100px', "text-align" => "center"),
                'buttons'=>array(
                    'file_1' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'SK RKU' ),
                        'label' => '<i class="fa fa-file-pdf-o"></i>',
                        'visible' => '$data->file_doc == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->file_doc)) {
                                $file = $this->createUrl('/').$data->file_doc;
                                return $file;
                            }
                        }
                    ), 
                    'file_2' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'File SHP' ),
                        'label' => '<i class="glyphicon glyphicon-file"></i>',
                        'visible' => '$data->file_shp == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->file_shp)) {
                                $file = $this->createUrl('/').$data->file_shp;
                                return $file;
                            }
                        }
                    ),         
                    'bloksektor' => array(
                        'label' => "<i class='glyphicon glyphicon-list-alt'></i>",
                        'options' => array('title' => Yii::t('app', 'Unit Kelestarian dan Petak Kerja'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/bloksektor", array("id"=>$data->id_rku))',
                        'visible' => '$data->edit_status == 1 ? "1" : "0"'
                    ),
                    'revisi' => array(
                        'label' => "<i class='glyphicon glyphicon-repeat'></i>",
                        'options' => array('title' => Yii::t('app', 'Revisi'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/revisi", array("id"=>$data->id_rku))',
                        'visible' => '$data->edit_status == 1 ? "1" : "0"'
                    ),
                    'update' => array(
                        'visible' => '$data->edit_status == 1 ? "1" : "0"'
                    ),
                    'delete' => array(
                        'visible' => '$data->edit_status == 1 ? "1" : "0"',
                    ),
                    'telahDirevisi' => array(
                        'label' => "<i class='glyphicon glyphicon-eye-open'></i>",
                        'options' => array('title' => Yii::t('app', 'Telah Direvisi'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/indexRev", array("id"=>$data->id_rku))',
                        'visible' => '$data->status == 2 ? "1" : "0"'
                    ),
                    'telahBerakhir' => array(
                        'label' => "<i class='glyphicon glyphicon-eye-open'></i>",
                        'options' => array('title' => Yii::t('app', 'Telah Berakhir'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/indexRev", array("id"=>$data->id_rku))',
                        'visible' => '$data->status == 3 ? "1" : "0"'
                    )
                ),
                'afterDelete'=>'function(link,success,data){
                    if(success) {
                        $.ajax({
                            type:"POST",
                            url:"'.Yii::app()->createUrl("/perusahaan/rku/cekData").'",
                            dataType: "JSON",
                            success: function(data) {
                                if(data.hasil == "kosong") {
                                    $("#tombol").show();
                                }
                            }
                        });
                    }
                }'
                
            ),
        ),
    ));
    ?>
</div>


