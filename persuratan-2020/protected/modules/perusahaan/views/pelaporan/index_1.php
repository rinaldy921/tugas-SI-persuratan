<?php
$this->breadcrumbs = array(
    'Kinerja'
);
?>
<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Pelaporan</h4>
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
    $this->widget('booster.widgets.TbGroupGridView', array(
        'id' => Yii::app()->controller->id . '-mata-air-grid',
        'type' => 'bordered condensed',
        'responsiveTable' => true,
        'dataProvider' => $model,
        'mergeColumns' => array('grade', 'rekom', 'total'),
        'template' => '{items}',
        'mergeCellCss' => 'vertical-align: middle;text-align:center;',
        'columns' => array(
            array(
                'name' => 'aspek',
                'header' => 'Aspek',
            ),
            array(
                'name' => 'bobot',
                'header' => 'Bobot',
            ),
            array(
                'name' => 'kpi',
                'header' => 'Kriteria',
            ),
            array(
                'name' => 'nilai',
                'header' => 'Nilai',
            ),
            array(
                'name' => 'total',
                'header' => 'Nilai',
            ),
            array(
                'name' => 'grade',
                'header' => 'Grade/Mark',
            ),
            array(
                'name' => 'rekom',
                'header' => 'Rekomendasi',
            )
        )
    ));
    ?>
</div>
<?php
Yii::app()->booster->registerPackage('datepicker');
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