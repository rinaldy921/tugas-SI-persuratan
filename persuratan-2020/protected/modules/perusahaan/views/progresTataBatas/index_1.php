<?php
$this->breadcrumbs = array(
    'Progres Tata Batas'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_izin.php'; ?>        
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Progres Tata Batas</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
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
    $this->widget('booster.widgets.TbEditableDetailView', array(
        'data' => $modelTataBatas,
        'url' => $this->createUrl('changeStatus'),
        'attributes' => array(
            array(
                'label' => 'Progres Tata Batas',
                'name' => 'status',
                'value' => ($modelTataBatas->status == 1) ? "Belum Ada Proses" : (($modelTataBatas->status == 2) ? "Pelaksanaan" : "Penetapan"),
                'editable' => array(
                    'type' => 'select',
                    'source' => array(1 => 'Belum Ada Proses', 2 => 'Pelaksanaan', 3 => 'Penetapan'),
                    'apply' => true, //we must set apply to overwrite defaults
                )
            ),
        ),
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