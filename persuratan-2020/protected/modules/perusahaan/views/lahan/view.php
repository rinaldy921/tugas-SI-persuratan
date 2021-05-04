<?php
$this->breadcrumbs = array(
    'Keadaan Lahan'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Keadaan Lahan</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
//            'id_keadaan_lahan',
//            'id_iuphhk',
            array(
                'label' => 'Lahan Kering',
                'value' => $model->lahan_kering ? floatval($model->lahan_kering) . ' Ha' : null,
            ),
            array(
                'label' => 'Basah',
                'value' => $model->basah ? floatval($model->basah) . ' Ha' : null,
            ),
            array(
                'label' => 'Payau',
                'value' => $model->payau ? floatval($model->payau) . ' Ha' : null,
            ),
        ),
    ));
    if (Yii::app()->user->hasIuphhk()) {
        if (empty($model->id_iuphhk)) {
            echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary btn-sm'));
        } else {
            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('lahan/update/id/' . $model->id_keadaan_lahan), array('class' => 'btn btn-primary'));
        }
    }
    ?>
</div>