<?php

$this->pageTitle = Yii::t('view', 'Message') . ': ' . $model->wp_trim($model->judul, 60);
$this->breadcrumbs = array(
    Yii::t('view', 'Message') => array($this->defaultAction),
    Yii::t('view', 'Ubah Data'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>