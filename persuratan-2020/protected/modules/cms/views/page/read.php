<?php
$this->pageTitle = $model->wp_trim($model->Judul, 100);
$this->breadcrumbs = array(
    $model->wp_trim($model->Judul, 60),
);
?>
<div class="page-header">
    <h4><?php echo $model->Judul; ?></h4>
</div>
<div class="detail-view">
    <?php echo $model->Isi; ?>
</div>