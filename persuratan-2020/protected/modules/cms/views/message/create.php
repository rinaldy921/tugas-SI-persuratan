<?php

$this->pageTitle = Yii::t('view', 'Tulis') . ' ' . Yii::t('view', 'Message');
$this->breadcrumbs = array(
    Yii::t('view', 'Message') => array($this->defaultAction),
    Yii::t('view', 'Buat Pesan Baru'),
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>