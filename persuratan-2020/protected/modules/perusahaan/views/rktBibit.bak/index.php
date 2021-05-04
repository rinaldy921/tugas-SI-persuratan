<?php
$this->breadcrumbs=array(
	'Rkt Bibits'=>array('index'),
	'Manage',
);
$rku = Rku::model()->find('id_rku = '.$model->id_rku);
$sektor = !empty($modelSiapLahan->search()->data) ? $modelSiapLahan->search()->data[0]->idBlok->id_sektor : '';
?>
<div class="col-md-2">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-10">
<h4 class="page-header">Kelestarian Fungsi Produksi</h4>
    <div class="col-md-12">
        <div class="row">
            <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                'id'=> Yii::app()->controller->id . '-filtertahun-form',
                    'type'=>'inline',
                    'htmlOptions'=>array('class'=>'well well-sm')
                //     'enableClientValidation' => true,
                //     'clientOptions' => array(
                //         'validateOnSubmit' => true,
                //     ),
                // 'enableAjaxValidation'=>false,
            )); ?>
            <div class="form-group">
                <label for="Rkt_tahun_mulai">Tahun : </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <input id="Rkt_tahun_mulai" class="span5 form-control ct-form-control" type="text" name="Rkt[tahun_mulai]" value="<?php echo $tahun;?>">
                </div>
            </div>
            <?php //echo $form->datePickerGroup($model,'tahun_mulai',array('widgetOptions'=>array('events'=>array('hide'=>'js:function(){$("#'.Yii::app()->controller->id.'-filtertahun-form").submit();}'), 'options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
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
                'content' => $this->renderPartial('_index_bibit', array('tahun'=>$tahun,'model' => $modelBibit), true),
                'active' => true
            ),
            array(
                'label' => 'Penyiapan Lahan',
                'content' => $this->renderPartial(empty($sektor) ? '_index_siaplahan' : '_index_siaplahan_sektor', array('tahun'=>$tahun,'model' => $modelSiapLahan), true),
            ),
            array(
                'label' => 'Penanaman',
                'content' => $this->renderPartial(empty($sektor) ? '_index_tanam' : '_index_tanam_sektor', array('tahun'=>$tahun,'model'=>$modelTanam), true),
            ),
            array(
                'label' => 'Pemeliharaan',
                'content' => $this->renderPartial('index_pemeliharaan', array('tahun'=>$tahun,'model_sulam' => $modelSulam,'model_jarang'=>$modelJarang,'model_dangir'=>$modelDangir), true),
            ),
            array(
                'label' => 'Pemanenan',
                'content' => $this->renderPartial('index_panen', array('tahun'=>$tahun,'modelPanenAreal' => $modelPanenAreal,'modelPanenTanaman'=>$modelPanenTanaman,'modelPanenSiapLahan'=>$modelPanenSiapLahan,'sektor'=>$sektor,'modelNonKayu'=>$modelNonKayu), true),
            ),
            array(
                'label' => 'Pemasaran',
                'content' => $this->renderPartial('_index_pasar', array('tahun'=>$tahun,'model'=>$modelPasar), true),
            ),
            // array(
            //     'label' => 'Pemasukan dan Penggunaan Peralatan',
            //     'content' => $this->renderPartial('_index_masukgunaalat', array('model' => $masukGunaAlat), true),
            // ),
            // array(
            //     'label' => 'Pembangunan Sarana Prasarana',
            //     'content' => $this->renderPartial('_index_bangunsarpras', array('model' => $bangunSarpras), true),
            // ),
        )
    ));
    ?>
</div>
<?php
// Yii::app()->clientScript->registerScript("filter_tahun", "
// jQuery('#Rkt_tahun_mulai').datepicker({
//     'format':'yyyy',
//     'startView':'decade',
//     'minViewMode':2,
//     'autoclose':true,
//     'language':'id'
// }).on('change', function(){
//     $(\"#".Yii::app()->controller->id."-filtertahun-form\").submit();
// });
// ", CClientScript::POS_END);
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rkt_tahun_mulai').datepicker({
    'format':'yyyy',
    'startView':2,
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
