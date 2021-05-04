<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan);?>
<?php
$this->breadcrumbs = array(
    'Rencana Kerja Umum'
);
?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iup->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iup->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggal Keputusan</th>
                    <td><?= $this->getDateMonth($iup->tanggal) ?></td>
                    <th>Telepon</th>
                    <td><?= $iup->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Luas Areal</th>
                    <td><?= floatval($iup->luas) ?> Ha</td>
                    <th>Alamat</th>
                    <td><?= $iup->idPerusahaan->alamat ?></td>
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rku.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Daftar Rencana Kerja Umum</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'enableSorting'=>false,
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
//            'tahun_mulai',
//            'tahun_sampai',
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
            array(
                'name' => 'status',
                'value' => '$data->cekRev($data->id_perusahaan,$data->id_rku)'
            ),
            array(
                'header' => 'Aksi',
                'class' => 'booster.widgets.TbButtonColumn',
                'template'=>'{telahDirevisi}',
                'buttons'=>array(
                    'telahDirevisi' => array(
                        'label' => "<i class='glyphicon glyphicon-eye-open'></i>",
                        'options' => array('title' => Yii::t('app', 'Lihat Data'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/indexRevRku", array("id"=>'.$iup->id_iuphhk.',"id_rku"=>$data->id_rku))',
                        'visible' => '$data->status != 1 ? "1" : "0"'
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