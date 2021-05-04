<?php
$this->breadcrumbs = array(
    'Data Agama & Kepercayaan Penduduk'
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
    <h4 class="page-header">Data Agama & Kepercayaan Penduduk</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            // 'tipe_iklim',
            array(
                'label' => 'Islam',
                'value' => $model->islam ? floatval($model->islam) . ' (%)' : null,
            ),
            array(
                'label' => 'Katolik',
                'value' => $model->katolik ? floatval($model->katolik) . ' (%)' : null,
            ),
            array(
                'label' => 'Kristen',
                'value' => $model->kristen ? floatval($model->kristen) . ' (%)' : null,
            ),
            array(
                'label' => 'Lainnya',
                'value' => $model->lainnya ? floatval($model->lainnya) . ' (%)' : null,
            )
        ),
    ));?>
    <br>
    <?php
    if (Yii::app()->user->hasIuphhk()) {
        if (empty($model->id_agama)) {
            echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary btn-sm'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('iuphhkAgama/update/id/' . $model->id_agama), array('class' => 'btn-sm btn btn-primary'));
        }
    }
    ?>
</div>