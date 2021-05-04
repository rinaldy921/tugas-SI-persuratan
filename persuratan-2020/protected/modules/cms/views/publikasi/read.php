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
    <?php echo $model->Deskripsi; ?>
</div>
<div class="related-file">
    <div class="well well-sm">
        <p>Lampiran :</p>
        <?php
        if (!empty($model->attachments)) {
            echo '<ul>';
            $i = 0;
            foreach ($model->attachments as $a) {
                $i++;
                echo '<li>' . CHtml::link($a->File_Name, Yii::app()->baseUrl . $a->File_Path, array("class" => "text-info")) . '</li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
</div>