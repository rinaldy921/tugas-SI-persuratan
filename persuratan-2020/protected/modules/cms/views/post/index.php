<?php
$this->pageTitle = Yii::t('view', 'Berita');
$this->breadcrumbs = array(
    Yii::t('view', 'Berita') => array('index'),
);
?>
<div class="page-header">
    <h4><?php echo Yii::t('view', 'Berita'); ?></h4>
</div>
<?php
$this->widget('booster.widgets.TbListView', array(
    'id' => 'post-grid',
    'dataProvider' => $model,
    'itemView' => '_list',
    'pagerCssClass' => 'pagination col-sm-12',
    'replaceContent' => true,
    'pager' => array(
        'class' => 'booster.widgets.TbPager',
        'loadMore' => true,
        'containerHtmlOptions' => array('style' => 'margin-right:-15px'),
    ),
    'template' => '{items}{pager}',
));
?>
<div style="display: none;" tabindex="-1" class="modal fade" id="myModal"></div>