<?php
$this->breadcrumbs=array(
	'Prasyarat'=>array('index'),
	'Manage',
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
    <h4 class="page-header">Data Lembaga</h4>
    <div class="col-md-12">
        <div class="row">
            <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                'id'=> Yii::app()->controller->id . '-filtertahun-form',
                    'type'=>'inline',
                    'htmlOptions'=>array('class'=>'well well-sm')
            )); ?>
<!--            <div class="form-group">
                <label for="Rkt_tahun_mulai">Tahun : </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <input id="Rkt_tahun_mulai" class="span5 form-control ct-form-control" type="text" name="Rkt[tahun_mulai]" value="<?php echo $model->tahun_mulai;?>">
                </div>
            </div>-->
            <?php echo $form->datePickerGroup($model,'tahun_mulai',array('widgetOptions'=>array('events'=>array('change'=>'js:function(){$("#'.Yii::app()->controller->id.'-filtertahun-form").submit();}'), 'options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
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
                'content' => $this->renderPartial('_index_tenaga_kerja', array('model' => $tenagaKerja), true),
                'active' => true,
                //'AjaxTab'=> array('ajax'= >$this->createUrl('ajax'))
            ),
            array(
                'label' => 'Penataan Batas Blok',
                'content' => $this->renderPartial('index_tatabatas', array('model' => $tatabatas), true),
            ),
            array(
                'label' => 'Penataan Ruang',
                'content' => $this->renderPartial('index_tataruang', array(
                    'bloksektor'=>$bloksektor, 
                    'model_kawasan_lindung' => $tataruang, 
                    'idRkt'=>$idRkt,
                    'model_areal_produktif'=>$arealProduktif, 
                    'model_areal_non_produktif'=>$arealNonProduktif,
                ), 
                true),
            ),
            array(
                'label' => 'Penataan Areal Kerja',
                'content' => $this->renderPartial('_index_areal_kerja', array('model' => $arealKerja), true),
            ),
            array(
                'label' => 'Pembukaan Wilayah Hutan',
                'content' => $this->renderPartial('_index_pwh', array('model' => $pwh), true),
            ),
            array(
                'label' => 'Pemasukan dan Penggunaan Peralatan',
                'content' => $this->renderPartial('_index_masukgunaalat', array('model' => $masukGunaAlat), true),
            ),
            array(
                'label' => 'Pembangunan Sarana Prasarana',
                'content' => $this->renderPartial('_index_bangunsarpras', array('model' => $bangunSarpras), true),
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
    $(\"#".Yii::app()->controller->id."-filtertahun-form\").submit();
});
", CClientScript::POS_END);