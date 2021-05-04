<?php
$this->breadcrumbs = array(
    'Data Fasilitas Tempat Ibadah'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_sosial_ekonomi.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Fasilitas Tempat Ibadah</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            // 'tipe_iklim',
            array(
                'label' => 'Masjid',
                'value' => $model->mesjid ? floatval($model->mesjid) . ' (Unit)' : null,
            ),
            array(
                'label' => 'Gereja',
                'value' => $model->gereja ? floatval($model->gereja) . ' (Unit)' : null,
            ),
            array(
                'label' => 'Lainnya',
                'value' => $model->lainnya ? floatval($model->lainnya) . ' (Unit)' : null,
            )
        ),
    ));?>
    <br>
    <?php
    if (Yii::app()->user->hasIuphhk()) {
        if (empty($model->id)) {
            echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary btn-sm'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('iuphhkTempatIbadah/update/id/' . $model->id), array('class' => 'btn btn-sm btn-primary'));
        }
    }
    ?>
</div>