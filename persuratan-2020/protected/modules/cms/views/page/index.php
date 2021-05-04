<?php
$this->pageTitle = Yii::t('view', 'Post');
$this->breadcrumbs = array(
    Yii::t('view', 'Post') => array($this->defaultAction),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('post-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'post-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'columns' => $this->getIndexList($model),
    'responsiveTable' => true,
));
?>
<div style="display: none;" tabindex="-1" class="modal fade" id="myModal"></div>