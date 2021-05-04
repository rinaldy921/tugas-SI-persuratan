<?php
$this->breadcrumbs=array(
	'Prasyarat'=>array('index'),
	'Manage',
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
    <h4 class="page-header">Data IUPHHK-HTI</h4>
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
    </div>
    <?php 
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'rootwizard',
        'tabs' => array(
            array(
                'label' => 'Organisasi & Tenaga Kerja',
                'content' => $this->renderPartial('index_ganis', array('model' => $ganis), true),
                'active' => true
            ),
            array(
                'label' => 'Tata Batas',
                'content' => $this->renderPartial('index_tatabatas', array('model' => $tatabatas), true),
            ),
            array(
                'label' => 'Penataan Ruang',
                'content' => $this->renderPartial('index_tataruang', array(
                    'modelKawasan' => $tataruang, 
                    'produktif'=>$arealProduktif, 
                    'non_produktif'=>$arealNonProduktif,
                ), 
                true),
            ),
            array(
                'label' => 'Penataan Areal Kerja',
                'content' => $this->renderPartial('index_areal_kerja', array('model' => $arealKerja), true),
            ),
            array(
                'label' => 'Pemasukan & Penggunaan Peralatan',
                'content' => $this->renderPartial('index_peralatan', array('model' => $peralatan), true),
            ),
            array(
                'label' => 'Pengadaan Sarpras',
                'content' => $this->renderPartial('index_sarpras', array('model' => $sarpras), true),
            ),
            array(
                'label' => 'Pembukaan Wilayah Hutan',
                'content' => $this->renderPartial('index_pwh', array('model' => $pwh), true),
            ),
        )
    ));
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