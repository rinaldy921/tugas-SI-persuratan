<?php

$this->pageTitle = Yii::t('view', 'Publikasi') . ': ' . $model->wp_trim($model->Judul, 60);
$this->breadcrumbs = array(
    Yii::t('view', 'Publikasi') => array($this->defaultAction),
    Yii::t('view', 'Ubah Data'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>