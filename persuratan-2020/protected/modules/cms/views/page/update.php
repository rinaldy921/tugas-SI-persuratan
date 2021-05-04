<?php

$this->pageTitle = Yii::t('view', 'Halaman') . ': ' . $model->wp_trim($model->Judul, 60);
$this->breadcrumbs = array(
    Yii::t('view', 'Pengelolaan Halaman') => array('admin'),
    Yii::t('view', 'Ubah Data'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>