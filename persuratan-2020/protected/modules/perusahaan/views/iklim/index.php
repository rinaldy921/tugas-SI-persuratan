<?php
$this->breadcrumbs = array(
    'Iklim'
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
    <h4 class="page-header">Data Iklim</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'tipe_iklim',
            array(
                'label' => 'Curah Hujan (mm)',
                'value' => $model->curah_hujan ? floatval($model->curah_hujan) . ' mm' : null,
            ),
            array(
                'label' => 'Curah Hujan Terendah (mm)',
                'value' => $model->hujan_terendah ? floatval($model->hujan_terendah) . ' mm' : null,
            ),
            array(
                'label' => 'Curah Hujan Tertinggi (mm)',
                'value' => $model->hujan_tertinggi ? floatval($model->hujan_tertinggi) . ' mm' : null,
            )
        ),
    ));?>
    <br>
    <?php
    if (Yii::app()->user->hasIuphhk()) {
        if (empty($model->id_iuphhk)) {
            echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary btn-sm'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('iklim/update/id/' . $model->id_iklim), array('class' => 'btn btn-primary btn-sm'));
        }
    }
    ?>
</div>