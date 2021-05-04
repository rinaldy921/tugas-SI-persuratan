<?php

$this->pageTitle = Yii::t('view', 'Tambah Data') . ' ' . Yii::t('view', 'Album Galeri');
$this->breadcrumbs = array(
    Yii::t('view', 'Album Galeri') => array($this->defaultAction),
    Yii::t('view', 'Buat Album Baru'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>