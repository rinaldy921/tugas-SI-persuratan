<?php
$this->breadcrumbs = array(
    'Kelestarian Fungsi Sosial'
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
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rku.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Kelestarian Fungsi Sosial</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
//                'type' => 'inline',
                'htmlOptions' => array('class' => 'well well-sm form-inline')
            ));
            ?>
            <div class="form-group">
                <label for="Rku_periode">Periode Tahun : </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <input id="Rku_periode" class="span5 form-control ct-form-control" type="text" name="Rku[periode]" value="<?php echo $model->tahun_mulai . ' - ' . ($model->tahun_mulai + 9); ?>" placeholder="Pilih Periode RKU">
                </div>
            </div>
            <?php
            echo $form->datePickerGroup($model, 'tahun_mulai', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array(), 'labelOptions' => array(), 'wrapperHtmlOptions' => array()));
            ?>
            <?php $this->endWidget(); ?>
        </div>
                <?php echo $this->renderPartial('_index_fungsos', array('model' => $fungsos), true); ?>

    </div>
    <?php
//    $this->beginWidget('booster.widgets.TbTabs', array(
//        'type' => 'tabs',
//        'id' => 'root-fungsos',
////        'justified' => true,
//        'tabs' => array(
//            array(
//                'label' => 'Pembangunan Penyaluran Infrastruktur Pemukiman',
//                'content' => $this->renderPartial('_index_mukim', array('model' => $mukim), true),
//                'active' => true
//            ),
//            array(
//                'label' => 'Kelembagaan Masyarakat',
//                'content' => $this->renderPartial('_index_lembaga', array('model' => $lembaga), true),
//            )
//        ),
//    ));
//    $this->endWidget();
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rku_periode').datepicker({
    format: { /* Say our UI should display a week ahead, but textbox should store the actual date. This is useful if we need UI to select local dates, but store in UTC */ 
        toDisplay: function (date, format, language) { 
            var d = new Date(date); 
            d = d.getFullYear() + ' - '+ (d.getFullYear() + 9); 
            return d;
        }, 
        toValue: function (date, format, language) { 
            var d = new Date(date); 
            d.setDate(d.getDate() + 7); 
            return new Date(d); 
        }
    },
    'startView':'decade',
    'minViewMode':2,
    'autoclose':true,
    'language':'id'
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);