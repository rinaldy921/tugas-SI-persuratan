<?php
$this->breadcrumbs = array(
    'Adendum',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/data_perusahaan_menu.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Adendum SK</h4>
    <?php echo Yii::app()->user->hasIuphhk() ? CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Adendum SK'), array('create'), array('class' => 'btn btn-primary')) : ""; ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            'nomor_adendum',
            'tanggal',
            array(
                'name' => 'luas',
                'value' => 'isset($data->luas)? floatval($data->luas) . " Ha": "-"',
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    ));
    ?>
</div>
