<?php
$this->breadcrumbs = array(
    'Topografi'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Topografi</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
//            'id_topografi',
//            'id_iuphhk',
            array(
                'label' => 'Datar (0-8%)',
                'value' => $model->datar ? floatval($model->datar) . ' Ha' : null,
            ),
            array(
                'label' => 'Landai (8-15%)',
                'value' => $model->landai ? floatval($model->landai) . ' Ha' : null,
            ),
            array(
                'label' => 'Agak Curam (15-25%)',
                'value' => $model->agak_curam ? floatval($model->agak_curam) . ' Ha' : null,
            ),
            array(
                'label' => 'Curam (25-40%)',
                'value' => $model->curam ? floatval($model->curam) . ' Ha' : null,
            ),
            array(
                'label' => 'Sangat Curam (>40%)',
                'value' => $model->sangat_curam ? floatval($model->sangat_curam) . ' Ha' : null,
            ),
            array(
                'label' => 'Ketinggian Tempat (dpl)',
                'value' => $model->ketinggian ? floatval($model->ketinggian) . ' dpl' : null,
            )
        ),
    ));?>
    <br>
    <?php
    if (Yii::app()->user->hasIuphhk()) {
        if (empty($model->id_iuphhk)) {
            echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary btn-sm'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('topografi/update/id/' . $model->id_topografi), array('class' => 'btn btn-primary'));
        }
    }
    ?>
</div>