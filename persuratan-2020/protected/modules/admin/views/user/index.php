<?php
$role = CHtml::listData(AppRole::model()->findAll(array('select' => 'id, nama_role')), 'id', 'nama_role');
$role[""] = Yii::t('app', 'Pilih Role...');
$this->breadcrumbs = array(
    'User'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data User Aplikasi</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary')); ?><?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
            array(
                'name' => 'id_role',
                'filter' => CHtml::dropDownList(get_class($model) . '[id_role]', $model->id_role, $role, array('class' => 'form-control')),
                'value' => '($data->id_role) ? $data->idRole->nama_role : "-"',
            ),
            array(
                'name' => 'id_perusahaan',
                'value' => '$data->idPerusahaan->nama_perusahaan'
            ),
            // 'id_perusahaan',
            'nama_user',
            'username',
//            'password',
            array(
                'name' => 'last_login',
                'value' => '$data->last_login ? Yii::app()->controller->getDateTime($data->last_login) : "-" ',
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    ));
    ?>
</div>