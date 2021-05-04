<?php
$this->breadcrumbs = array(
    'Kelestarian Fungsi Lingkungan'
);
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt_.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Kelestarian Fungsi Lingkungan</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
//                    'type' => 'horizontal',
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
        'id' => 'lingkungan',
        'tabs' => array(
            array(
                'label' => 'Perlindungan dan Pengamanan Hutan',
                'content' => $this->renderPartial('_index_dungtan', array('model' => $modelDungtan), true),
                'active' => true
            ),
            array(
                'label' => 'Pengendalian Hama dan Penyakit',
                'content' => $this->renderPartial('_index_dalmakit', array('model' => $modelDalmakit), true),
            ),
            array(
                'label' => 'Pengendalian Kebakaran',
                'content' => $this->renderPartial('_index_dalkar', array('model' => $modelDalkar), true),
            ),
            array(
                'label' => 'Pengelolaan dan Pemantauan Lingkungan',
                'content' => $this->renderPartial('_index_pantaulingkungan', array('modelPantau'=>$modelPantau), true),
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
    'minViewMode':'years',
    'maxViewMode':'years',
    'immediateUpdates':true,
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
