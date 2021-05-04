<?php
$this->pageTitle = Yii::t('view', 'Pengelolaan Halaman');
$this->breadcrumbs = array(
    Yii::t('view', 'Pengelolaan Halaman') => array('admin'),
);
?>
<div class="add-new-form">
    <?php
    echo CHtml::link("<i class='fa fa-plus'></i> " . Yii::t('view', 'Tambah Data'), array('create'), array('class' => 'btn btn-info'));
    ?>    
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'post-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => $this->getIndexList($model),
    'responsiveTable' => true,
));
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.mixitup.min.js", CClientScript::POS_END);
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/lightbox-2.6.min.js", CClientScript::POS_END);
Yii::app()->getClientScript()->registerScript("init_mixitup", "$('.grid-view').mixitup();", CClientScript::POS_READY);
?>
<div style="display: none;" tabindex="-1" class="modal fade" id="myModal"></div>