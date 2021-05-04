<?php
$this->breadcrumbs = array(
    'Keadaan Lahans' => array('index'),
    'Manage',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data KeadaanLahan</h4>
    <?php
    print_r($model);
    if (Yii::app()->user->hasIuphhk()) {
        if (empty($model->id_keadaan_lahan)) {
            echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary btn-sm'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('iuphhk/update/' . $model->id_iuphhk), array('class' => 'btn btn-primary'));
        }
    }
    ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'id_keadaan_lahan',
            'id_iuphhk',
            'lahan_kering',
            'basah',
            'payau',
            array(
                'class' => 'booster.widgets.TbButtonColumn',
            ),
        ),
    ));
    ?>
</div>