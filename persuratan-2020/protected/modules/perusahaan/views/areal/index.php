<?php
$this->breadcrumbs = array(
    'Iklim'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/iuphhk_menu.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header"> <i class="fa fa-bars" style="cursor:pointer;" id="jalan_negara"></i> Data Jalan Negara</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'htmlOptions' => array('id'=>'jalan-tbl', 'class' => 'detail-view table-bordered'),
        'data' => $jalan,
        'attributes' => array(
            'dalam_areal',
            'luar_areal'
        ),
    ));?>
    <br>
    <h4 class="page-header"> <i class="fa fa-bars" style="cursor:pointer;" id="areal_sungai"></i> Data Sungai</h4>
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'htmlOptions' => array('id'=>'sungai-tbl', 'class' => 'detail-view table-bordered'),
        'data' => $sungai,
        'attributes' => array(
            'dalam_areal',
            'luar_areal'
        ),
    ));?>
    <br>
    <?php
//    if (Yii::app()->user->hasIuphhk()) {
//        if (empty($model->id_iuphhk)) {
//            echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('create'), array('class' => 'btn btn-primary btn-sm'));
//        } else {
//            echo CHtml::link("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Edit'), array('iklim/update/' . $model->id_iuphhk), array('class' => 'btn btn-primary'));
//        }
//    }
    ?>
</div>
<?php
$cs = Yii::app()->ClientScript;
$cs->registerScript("_btn_collapse", "
    $('#jalan_negara').click(function(){
        $('#jalan-tbl').slideToggle('slow');
    });
    $('#areal_sungai').click(function(){
        $('#sungai-tbl').slideToggle('slow');
    });
", CClientScript::POS_END);