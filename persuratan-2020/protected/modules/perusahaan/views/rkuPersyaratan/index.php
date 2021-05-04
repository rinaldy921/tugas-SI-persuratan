<?php
$this->breadcrumbs = array(
    'RKU'=>array('index'),
    'Prasyarat'
    
);
?>

<style>
.deleteInFunction{
	cursor:pointer;
}
</style>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Aspek Persyaratan</h4>
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
                    <input id="Rku_periode" class="span5 form-control ct-form-control" type="text" name="Rku[periode]" value="<?php echo $rku->tahun_mulai . ' - ' . ($rku->tahun_mulai + 9); ?>" placeholder="Pilih Periode RKU">
                </div>
            </div>
            <?php
            echo $form->datePickerGroup($rku, 'tahun_mulai', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array(), 'labelOptions' => array(), 'wrapperHtmlOptions' => array()));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'persyaratan',
//        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Organisasi & Tenaga Kerja',
                'content' => $this->renderPartial('_form_ganis', array('rkuNaker' => $rkuNaker, 'naker' => $naker), true),
                'active' => true
            ),
            array(
                'label' => 'Tata Batas',
                'content' => $this->renderPartial('tata_batas', array('new_tata_batas'=>$new_tata_batas, 'tata_batas' => $tata_batas), true),
            ),
            array(
                'label' => 'Penataan Ruang',
                'content' => $this->renderPartial('index_tataruang', array('modelKawasan' => $modelKawasan, 'non_produktif' => $non_produktif, 'produktif' => $produktif, 'old_produktif' => $old_produktif, 'arealKerja' => $arealKerja, 'old_arealKerja' => $old_arealKerja), true),
            ),
            array(
                'label' => 'Penataan Areal Kerja',
                'content' => $this->renderPartial('index_areal_kerja', array('arealKerja' => $arealKerja, 'model' => $old_arealKerja), true),
            ),
            array(
                'label'=> 'Pemasukan & penggunaan Peralatan',
                'content' => $this->renderPartial('index_peralatan', array('model' => $peralatan, 'addPeralatan'=>$addPeralatan), true),
            ),
            array(
                'label'=> 'Pengadaan Sarpras',
                'content' => $this->renderPartial('index_sarpras', array('model' => $sarpras, 'addSarpras'=>$addSarpras), true),
            ),
            array(
                'label'=> 'Pembukaan Wilayah Hutan',
                'content' => $this->renderPartial('index_pwh', array('model' => $pwh, 'addPwh'=>$addPwh), true),
            ),
        ),
    ));
    $this->endWidget();
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