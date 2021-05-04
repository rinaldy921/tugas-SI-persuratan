<?php
$this->breadcrumbs = array(
    'Saham'
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
            <?php require_once dirname(__FILE__) . '/../layouts/data_perusahaan_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Saham</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary btn-sm')); ?>
    <br>
    <br>
    <?php
    $this->widget('booster.widgets.TbEditableDetailView', array(
        'data' => $modal,
        'url' => $this->createUrl('updateModal'),
        'attributes' => array(
            array(
                'name' => 'jenis',
                'label' => 'Status Permodalan',
                'value' => ($modal->jenis == 'PMDN') ? 'Penanaman Modal Dalam Negeri (' . $modal->jenis . ')' : 'Penanaman Modal Asing (' . $modal->jenis . ')',
                'editable' => array(
                    'type' => 'select',
                    'source' => array('PMDN' => 'PMDN', 'PMA' => 'PMA'),
                    'apply' => true,
                )
            ),
        ),
    ));
    ?>

    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-saham-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'enableSorting' => false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'header' => 'Kepemilikan dan Komposisi Saham',
                'name' => 'nama_pemodal'
            ),
            array(
                'class' => 'booster.widgets.TbEditableColumn',
                'name' => 'jumlah',
                'type' => 'raw',
                'editable' => array(
                    'url' => $this->createUrl('//perusahaan/saham/updateSaham'),
                    'success' => 'js:function() {
	                $.fn.yiiGridView.update("' . Yii::app()->controller->id . '-saham-grid");
	            }'
                ),
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{delete}'
            ),
        ),
    ));
    ?>
</div>