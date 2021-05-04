<?php
$this->breadcrumbs = array(
    'Investasi',
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
    <h4 class="page-header">Data Investasi</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Investasi'), array('create'), array('class' => 'btn btn-primary')); ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        // 'filter' => $model,
        'enableSorting'=>false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'name' => 'tgl_invest',
                'value' => function($data) {
                    return isset($data->tgl_invest) ? Yii::app()->controller->getDateMonth($data->tgl_invest) : "-";
                }
                //'value' =>
            ),
            //'tgl_invest',
            array(
    			'name'=>'jml_rupiah',
                'value'=>function ($data) {
                    return number_format($data->jml_rupiah,0,',','.');
                }
    		),
            array(
    			'name'=>'jml_dollar',
                'value'=>function ($data) {
                    return number_format($data->jml_dollar,0,',','.');
                }
    		),
            // 'nilai_perolehan',
            // '',
            // 'total_aset',
            // array(
            //     'name' => 'luas',
            //     'value' => 'isset($data->luas)? floatval($data->luas) . " Ha": "-"',
            // ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    ));
    ?>
</div>
