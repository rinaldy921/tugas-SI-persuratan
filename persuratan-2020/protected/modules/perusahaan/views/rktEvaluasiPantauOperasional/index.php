<?php
$this->breadcrumbs=array(
	'Rkt Evaluasi Pantau Operasionals'=>array('index'),
	'Manage',
);
$rku = Rku::model()->find('id_rku = '.$model->id_rku);
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-10">
    <h4 class="page-header">Data Pemantauan dan Evaluasi</h4>
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
                    <input id="Rkt_tahun_mulai" class="span5 form-control ct-form-control" type="text" name="Rkt[tahun_mulai]" value="<?php echo $model->tahun_mulai;?>">
                </div>
            </div>
            <?php //echo $form->datePickerGroup($model,'tahun_mulai',array('widgetOptions'=>array('events'=>array('hide'=>'js:function(){$("#'.Yii::app()->controller->id.'-filtertahun-form").submit();}'), 'options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
            <?php $this->endWidget(); ?>
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
                // 'active' => true
            ),
        )
    ));
    ?>
</div>
<?php
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