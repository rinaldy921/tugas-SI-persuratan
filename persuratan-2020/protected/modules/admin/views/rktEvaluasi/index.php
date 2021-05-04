<?php
$this->breadcrumbs = array(
    'Pemantauan & Evaluasi'
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
<div class="col-md-2">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt_.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-10">
    <h4 class="page-header">Data Pemantauan dan Evaluasi</h4>
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
            ?><?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'evaluasi',
        'tabs' => array(
            array(
                'label' => 'Pemantauan Kegiatan Operasional Secara Periodik',
                'content' => $this->renderPartial('_index_evaluasiopr', array('model' => $modelGanisOpr), true),
                'active' => true
            ),
            array(
                'label' => 'Evaluasi Keberhasilan Secara Periodik',
                'content' => $this->renderPartial('_index_evaluasiberhasil', array('model' => $modelGanisBerhasil), true),
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
    'language':'id'
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);
