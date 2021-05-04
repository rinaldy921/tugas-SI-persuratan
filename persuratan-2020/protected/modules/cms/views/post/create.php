<?php

$this->pageTitle = Yii::t('view', 'Tambah Data') . ' ' . Yii::t('view', 'Post');
$this->breadcrumbs = array(
    Yii::t('view', 'Post') => array($this->defaultAction),
    Yii::t('view', 'Buat Post Baru'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>