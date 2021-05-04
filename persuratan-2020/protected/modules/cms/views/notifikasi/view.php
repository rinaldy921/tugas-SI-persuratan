<?php

$this->pageTitle = Yii::t('view', 'Notifikasi') . ': ' . $model->wp_trim($model->isi, 60);
$this->breadcrumbs = array(
    Yii::t('view', 'Notifikasi') => array($this->defaultAction),
    $model->wp_trim($model->isi, 60),
);
?>
<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => $this->getViewList($model),
));
?>
