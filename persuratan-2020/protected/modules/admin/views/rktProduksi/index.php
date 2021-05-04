<?php
$this->breadcrumbs = array(
    'Kelestarian Fungsi Produksi'
);
$sektor = $modelSiapLahan->search()->data[0]->idBlok->id_sektor;
$rku = Rku::model()->find('id_rku = '.$model->id_rku);
?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iup->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iup->idPerusahaan->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggak Keputusan</th>
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
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt_.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Kelestarian Fungsi Produksi</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
//                'type' => 'inline',
                'htmlOptions' => array('class' => 'well well-sm form-inline')
            ));
            ?>
            <?php
            echo $form->datePickerGroup($model, 'tahun_mulai', array(
                'widgetOptions' => array(),
                'labelOptions' => array(
                    'label' => 'Tahun : ',
                    'class' => ''
                ),
                'wrapperHtmlOptions' => array(
                    'class' => '',
                ),
                'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
            ));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'bibits',
        'tabs' => array(
            array(
                'label' => 'Pengadaan Bibit',
                'content' => $this->renderPartial('_index_bibit', array('model' => $modelBibit), true),
                'active' => true
            ),
            array(
                'label' => 'Penyiapan Lahan',
//                'content' => $this->renderPartial(empty($sektor) ? '_index_siaplahan' : '_index_siaplahan_sektor', array('model' => $modelSiapLahan), true),
                'content' => $this->renderPartial('_index_siaplahan', array('model' => $modelSiapLahan), true),
            ),
            array(
                'label' => 'Penanaman',
//                'content' => $this->renderPartial(empty($sektor) ? '_index_tanam' : '_index_tanam_sektor', array('model' => $modelTanam), true),
                'content' => $this->renderPartial('_index_tanam', array('model' => $modelTanam), true),
            ),
            array(
                'label' => 'Pemeliharaan',
                'content' => $this->renderPartial('_index_pemeliharaan', array('model' => $modelPemeliharaan), true),
            ),
            array(
                'label' => 'Pemanenan',
                'content' => $this->renderPartial('index_panen', array('modelPanenProduksi' => $modelPanenProduksi, 'modelPanenLahan' => $modelPanenLahan, 'modelPanenHhbk' => $modelPanenHhbk), true),
            ),
            array(
                'label' => 'Pemasaran',
                'content' => $this->renderPartial('index_pasar', array('modelPasar' => $modelPasar, 'modelPasarHhbk' => $modelPasarHhbk), true),
            ),
        )
    ));
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rkt_tahun_mulai').datepicker({
    'format':'yyyy',
    'startView':'decade',
    'minViewMode':2,
    'autoclose':true,
    'language':'id',
    beforeShowYear: function (date){
        if (date.getFullYear() < ".$rku->tahun_mulai.") {
            return false;
        }
        if(date.getFullYear() > ".$rku->tahun_sampai.") {
            return false;
        }
    }
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);
