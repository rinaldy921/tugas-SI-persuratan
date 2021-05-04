<?php

$this->pageTitle = Yii::t('view', 'Tambah Data') . ' ' . Yii::t('view', 'Publikasi');
$this->breadcrumbs = array(
    Yii::t('view', 'Publikasi') => array($this->defaultAction),
    Yii::t('view', 'Buat Data Baru'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>