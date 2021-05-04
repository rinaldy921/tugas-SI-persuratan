<?php
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => '.modal-fancy',
    'config' => array(
        "autoSize" => false,
        "closeBtn" => true,
        // "showCloseButton" => true,
        "fitToView" => true,
        'width' => '90%',
        'openEffect' => 'none',
        'openSpeed' => 600,
        'closeEffect' => 'none',
        'nextEffect' => 'none',
        'prevEffect' => 'none',
        "helpers" => array("overlay" => array("closeClick" => true)),
        'scrolling' => 'auto',
    ),
));
?>
<?php
$this->breadcrumbs = array(
    'Data RKT',
);
$list = $arrays = CHtml::listData(Rkt::model()->findAll(array('select' => 'tahun_mulai', 'order' => 'tahun_mulai ASC', 'condition'=>'id_rku = '.$model->id_rku)), 'tahun_mulai', 'tahun_mulai');
?>
<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/perusahaan/rku') ?>">&laquo; Kembali</a>
    <h4 class="text-center">Data RKT Revisi</h4>
    <div class="panel panel-success">
        <div class="table-responsive">
            <table class="detail-view table">
                <tbody>
                    <tr>
                        <th>Nomor SK RKU</th>
                        <td><?= $rku->nomor_sk ?></td>
                        <th>Nama Perusahaan</th>
                        <td><?= $rku->idPerusahaan->nama_perusahaan ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Keputusan RKU</th>
                        <td><?= $this->getDateMonth($rku->tgl_sk) ?></td>
                        <th>Telepon</th>
                        <td><?= $rku->idPerusahaan->telepon ?></td>
                    </tr>
                    <tr>
                        <th>Tahun RKU</th>
                        <td><?= $rku->tahun_mulai.' - '.$rku->tahun_sampai ?></td>
                        <th>Alamat</th>
                        <td><?= $rku->idPerusahaan->alamat ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../../layouts/menu_rku_revisi.php'; ?>        </div>                   
    </div>
</div>
<div class="col-md-10">
    <h4 class="page-header">Data Rkt</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'htmlOptions'=>array('class'=>'table-responsive'),
        'type' => 'bordered condensed striped',
        'responsiveTable' => false,
        'dataProvider' => $model->search(),
        'enableSorting' => false,
        'filter'=>$model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'name'=>'tahun_mulai',
                'filter' => CHtml::dropDownList(get_class($model) . "[tahun_mulai]", $model->tahun_mulai, $list, array("empty"=>"Pilih Tahun...","class" => "form-control"))
            ),
            'nomor_sk',
            array(
                'name'=>'tanggal_sk',
                'filter' => CHtml::activeTextField($model, 'tanggal_sk', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Format: yyyy-mm-dd'))),
            ),
            array(
                'name'=>'mulai_berlaku',
                'filter' => CHtml::activeTextField($model, 'mulai_berlaku', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Format: yyyy-mm-dd'))),
            ),
            array(
                'name'=>'akhir_berlaku',
                'filter' => CHtml::activeTextField($model, 'akhir_berlaku', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Format: yyyy-mm-dd'))),
            ),
            array(
                'name' => 'keterangan',
                'value' => '$data->cekRev($data->id_rku, $data->id)',
                'filter' => CHtml::dropDownList(get_class($model) . "[status]", $model->status, array('1'=>'Aktif','2'=>'Telah direvisi'), array("empty"=>"Pilih Status...","class" => "form-control"))
            ),
            array(
                'class'=>'booster.widgets.TbButtonColumn',
                'template'=>'{telahDirevisi}',
                'buttons'=>array(
                    'telahDirevisi' => array(
                        'label' => "<i class='glyphicon glyphicon-eye-open'></i>",
                        'options' => array('title' => Yii::t('app', 'Lihat Data'), 'class' => 'modal-fancy', 'data-fancybox-type' => 'iframe'),
                        'url' => 'Yii::app()->createUrl("/perusahaan/' . Yii::app()->controller->id . '/detailRkt", array("id"=>$data->id))',
                        'click' => 'js:function(e){e.preventDefault();}'
                    )
                )
            ),
        ),
    ));
    ?>
</div>