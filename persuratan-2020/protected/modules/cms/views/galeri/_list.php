<div class="media">
    <?php $img_cover = ($data->Cover) ? Yii::app()->params->uploadDir . 'images/thumb/' . $data->Cover : Yii::app()->params->uploadDir . 'no-image.png'; ?>
    <a class="pull-left" href="#">
        <img class="media-object" src="<?php echo Yii::app()->baseUrl . $img_cover ?>">
    </a>
    <div class="media-body">
        <h3>
            <strong>
                <?php echo CHtml::link($data->Judul, array('read', 'slug' => $data->slug)); ?>
            </strong>
        </h3>
        <?php echo $data->wp_trim(strip_tags($data->Deskripsi), 300); ?>
        <p class="readmore">
            <strong>
                <?php echo CHtml::link(Yii::t('view', 'Lihat Galeri'), array('read', 'slug' => $data->slug)); ?> &raquo;
            </strong>
        </p>
    </div>
</div>
