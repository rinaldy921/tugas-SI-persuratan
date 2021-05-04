<?php

$this->pageTitle = Yii::t('view', 'Tambah Data') . ' ' . Yii::t('view', 'Halaman');
$this->breadcrumbs = array(
    Yii::t('view', 'Pengelolaan Halaman') => array('admin'),
    Yii::t('view', 'Buat Halaman Baru'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>