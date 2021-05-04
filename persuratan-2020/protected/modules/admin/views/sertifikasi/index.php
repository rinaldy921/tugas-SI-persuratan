<?php $label = Logic::getLastLoginByPerusahan($iuphhk->id_perusahaan);?>

<script type="text/javascript">
    function changeVerified(url, idRku)
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



<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iuphhk->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iuphhk->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggak Keputusan</th>
                    <td><?= $this->getDateMonth($iuphhk->tanggal) ?></td>
                    <th>Telepon</th>
                    <td><?= $iuphhk->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Luas Areal</th>
                    <td><?= floatval($iuphhk->luas) ?> Ha</td>
                    <th>Alamat</th>
                    <td><?= $iuphhk->idPerusahaan->alamat ?></td>
                </tr>
                <tr>
                    <th></th>
                    <td></td>
                    <th>Login Terakhir</th>
                    <td class=""><?=$label?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_admin_data_pokok_data_izin.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Sertifikasi PHPL</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $sertifikasiPhpl->search(),
        // 'filter'=>$model,
        'enableSorting' => false,
        'template' => '{items}',
        'columns' => array(
            'nomor',
            //'tanggal',
            array(
                'name' => "Tanggal",
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
            ),
            array(
                'name' => "Masa Berlaku",
                'value' => function($data) {
                    $awal = isset($data->tanggal_mulai) ? Yii::app()->controller->getDateMonth($data->tanggal_mulai) : "-";
                    $akhir = isset($data->tanggal_berakhir) ? Yii::app()->controller->getDateMonth($data->tanggal_berakhir) : "-";
                    return $awal . ' s/d ' . $akhir;
                }
            ),
            'idPenerbit.penerbit',
            'predikat',
            
            array(
                'name' => "Status Verifikasi",
                'value' => function($data) {
                    if($data->is_verified == 1){
                        return "Terverifikasi";
                    }
                    else if($data->is_verified == 0){
                        return "Belum Terverifikasi";
                    }
                    else{
                        return "Sertifikasi Di Bekukan";
                    }
                }
            ), 
      
                    
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style'=>'width:90px', "text-align" => "center"),
                // 'template' => '{detail} {update} {delete} {file_1}',
                'template' => '{file_1}  {aktifasi}  {deaktifasi} {blokir} {cabutblokir}',
                'buttons' => array(
                    'file_1' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'File Sertifikat' ),
                        'label' => '<i class="fa fa-file-pdf-o"></i>',
                        'visible' => '$data->file_doc == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->file_doc)) {
                                $file = $this->createUrl('/').$data->file_doc;
                                return $file;
                            }
                        }
                    ),
                    
                    'aktifasi' => array(
                        'label' => "<i class='glyphicon glyphicon-record'></i>",
                        'options' => array('title' => Yii::t('app', 'Verifikasi Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/aktifasiphpl", array("id"=>$data->id))',
                        'visible' => '$data->is_verified == 0 ? "1" : "0"'
                    ), 
                    'deaktifasi' => array(
                        'label' => "<i class='glyphicon glyphicon-ok-circle'></i>",
                        'options' => array('title' => Yii::t('app', 'Batalkan Verifikasi Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                          'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/batalaktifasiphpl", array("id"=>$data->id))',
                      'visible' => '$data->is_verified == 1 ? "1" : "0"'
                    ),
                    'blokir' => array(
                        'label' => "<i class='glyphicon glyphicon-ban-circle'></i>",
                        'options' => array('title' => Yii::t('app', 'Bekukan Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/doblokirsertifikatphpl", array("id"=>$data->id))',
                        'visible' =>  '$data->is_verified == 1 ? "1" : "0"'
                    ),
                            
                    'cabutblokir' => array(
                        'label' => "<i class='glyphicon glyphicon-share'></i>",
                        'options' => array('title' => Yii::t('app', 'Buka Pembekuan Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/aktifasiphpl", array("id"=>$data->id))',
                        'visible' => '$data->is_verified == 2 ? "1" : "0"'
                    ),
                            
                    'detail' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Detail'),
                        'label' => '<i class="fa fa-table"></i>',
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/penilikanphpl", array("id"=>$data->id))',
                    ),
                )
            ),
        ),
    ));
    ?>    
    <br>
    <h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-data-perusahaan"></i> Sertifikasi VLK</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-vlk-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $sertifikasiVlk->search(),
        // 'filter'=>$model,
        'enableSorting' => false,
        'template' => '{items}',
        'columns' => array(
            'nomor',
            //'tanggal',
            array(
                'name' => "Tanggal",
                'value' => function($data) {
                    return isset($data->tanggal) ? Yii::app()->controller->getDateMonth($data->tanggal) : "-";
                }
            ),
            array(
                'name' => "Masa Berlaku",
                'value' => function($data) {
                    $awal = isset($data->berlaku) ? Yii::app()->controller->getDateMonth($data->berlaku) : "-";
                    $akhir = isset($data->berakhir) ? Yii::app()->controller->getDateMonth($data->berakhir) : "-";
                    return $awal . ' s/d ' . $akhir;
                }
            ),
            'idPenerbit.penerbit',
            'predikat',
                    
             array(
                'name' => "Status Verifikasi",
                'value' => function($data) {
                    if($data->is_verified == 1){
                        return "Terverifikasi";
                    }
                    else if($data->is_verified == 0){
                        return "Belum Terverifikasi";
                    }
                     else {
                        return "Sertifikat Telah Di Bekukan";
                    }
                }
            ), 
             
           
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style'=>'width:90px', "text-align" => "center"),
                // 'template' => '{detail} {update} {delete} {file_1}',
                'template' => '{file_1}  {aktifasi}  {deaktifasi} {blokir} {cabutblokir}',
                'buttons' => array(
                    'file_1' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'File Sertifikat' ),
                        'label' => '<i class="fa fa-file-pdf-o"></i>',
                        'visible' => '$data->file_doc == null ? "0" : "1"',
                        'url' => function ($data) {
                            if(!is_null($data->file_doc)) {
                                $file = $this->createUrl('/').$data->file_doc;
                                return $file;
                            }
                        }
                    ),
                    'aktifasi' => array(
                        'label' => "<i class='glyphicon glyphicon-record'></i>",
                        'options' => array('title' => Yii::t('app', 'Verifikasi Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/aktifasivlk", array("id"=>$data->id))',
                        'visible' => '$data->is_verified == 0 ? "1" : "0"'
                    ), 
                    'deaktifasi' => array(
                        'label' => "<i class='glyphicon glyphicon-ok-circle'></i>",
                        'options' => array('title' => Yii::t('app', 'Batalkan Verifikasi Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/batalaktifasivlk", array("id"=>$data->id))',
                        'visible' => '$data->is_verified == 1 ? "1" : "0"'
                    ), 
                    'blokir' => array(
                        'label' => "<i class='glyphicon glyphicon-ban-circle'></i>",
                        'options' => array('title' => Yii::t('app', 'Bekukan Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/doblokirsertifikatsvlk", array("id"=>$data->id))',
                         'visible' => '$data->is_verified == 1 ? "1" : "0"'
                    ),
                    
                    'cabutblokir' => array(
                        'label' => "<i class='glyphicon glyphicon-share'></i>",
                        'options' => array('title' => Yii::t('app', 'Buka Pembekuan Sertifikat'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/aktifasivlk", array("id"=>$data->id))',
                        'visible' => '$data->is_verified == 2 ? "1" : "0"'
                    ),
                            
                            
                    'detail' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Detail'),
                        'label' => '<i class="fa fa-table"></i>',
                        'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/penilikanvlk", array("id"=>$data->id))',
                    ),
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("//perusahaan/sertifikasiPhpl/deleteVlk",array("id"=>$data->id))',
                    ),
                    'update' => array(
                        'url' => 'Yii::app()->createUrl("//perusahaan/sertifikasiPhpl/updateVlk",array("id"=>$data->id))',
                    ),
                )
            ),
        ),
    ));
    ?>



</div>