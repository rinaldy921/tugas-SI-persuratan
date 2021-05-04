<?php

$this->pageTitle = Yii::t('view', 'Halaman') . ': ' . $model->wp_trim($model->Judul, 60);
$this->breadcrumbs = array(
    Yii::t('view', 'Pengelolaan Halaman') => array($this->defaultAction),
    $model->wp_trim($model->Judul, 60),
);
?>
<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => $this->getViewList($model),
));
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.mixitup.min.js", CClientScript::POS_END);
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/lightbox-2.6.min.js", CClientScript::POS_END);
Yii::app()->getClientScript()->registerScript("init_mixitup", "$('.detail-view').mixitup();", CClientScript::POS_READY);
?>
