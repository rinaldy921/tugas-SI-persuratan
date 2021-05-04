<?php

$this->pageTitle = Yii::t('view', 'Album Galeri') . ': ' . $model->wp_trim($model->Judul, 60);
$this->breadcrumbs = array(
    Yii::t('view', 'Album Galeri') => array($this->defaultAction),
    Yii::t('view', 'Ubah Data'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>