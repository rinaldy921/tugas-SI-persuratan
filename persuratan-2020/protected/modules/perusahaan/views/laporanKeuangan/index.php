<?php
$this->breadcrumbs = array(
    'Laporan Keuangan',
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
    <h4 class="page-header">Data Laporan Keuangan</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Laporan Keuangan'), array('create'), array('class' => 'btn btn-primary')); ?>
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
            'tahun',
            array(
    			'name'=>'nilai_perolehan',
    			'value'=>function ($data) {
                    return number_format($data->nilai_perolehan,0,',','.');
                }
    		),
            array(
    			'name'=>'nilai_buku',
                'value'=>function ($data) {
                    return number_format($data->nilai_buku,0,',','.');
                }
    		),
            array(
    			'name'=>'total_aset',
                'value'=>function ($data) {
                    return number_format($data->total_aset,0,',','.');
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
