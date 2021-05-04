<?php
$this->breadcrumbs = array(
    'Tenaga Kerja',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_realisasi.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Serapan Tenaga Kerja</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Serapan Tenaga Kerja'), array('create'), array('class' => 'btn btn-primary')); ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        // 'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'tahun',
            array(
                'name' => 'id_bulan',
                'value' => function($data) {
                    $model = MasterBulan::model()->findByAttributes(['id' => $data->id_bulan]);
                    return $model->bulan;
                },
                'type' => 'raw'
            ),
            array(
                'name' => 'is_tenaga_kehutanan',
                'value' => function($data) {
                    if($data->is_tenaga_kehutanan == "1") {
                        return "Tenaga Profesional Bidang Kehutanan";
                    } else {
                        return "Tenaga Lainnya";
                    }
                },
                'type' => 'raw'
            ),
            'sarjana',
            'diploma',
            'menengah',
            'asing',
            array(
                'name' => 'is_tenaga_tetap',
                'value' => function($data) {
                    if($data->is_tenaga_tetap == "1") {
                        return "Tenaga Tetap";
                    } else {
                        return "Tenaga Tidak Tetap";
                    }
                },
                'type' => 'raw'
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    ));
    ?>
</div>
