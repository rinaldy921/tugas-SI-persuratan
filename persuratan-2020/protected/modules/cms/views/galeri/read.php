<?php
$this->pageTitle = $model->wp_trim($model->Judul, 100);
$this->breadcrumbs = array(
    $model->wp_trim($model->Judul, 60),
);
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl . "/css/lightbox.css");
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/jquery.mixitup.min.js", CClientScript::POS_END);
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/lightbox-2.6.min.js", CClientScript::POS_END);
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/prettify.min.js", CClientScript::POS_END);
Yii::app()->getClientScript()->registerScript("init_mixitup", "$('#Grid').mixitup();", CClientScript::POS_READY);
?>
<div class="page-header">
    <h4><?php echo $model->Judul; ?></h4>
</div>
<div class="detail-view gallery">
    <div class="row">
        <ul id="Grid" class="list-inline gallery-items">
            <?php foreach ($model->attachments as $d) { ?>
                <li data-name="<?php echo $model->slug; ?>" class="mix dogs  mix_all" style="display: inline-block;  opacity: 1;">
                    <div class="panel panel-cascade panel-gallery ">
                        <div class="panel-body">
                            <img alt="" src="<?php echo Yii::app()->baseUrl . Yii::app()->params->uploadDir . 'images/thumb/' . $d->File_Name; ?>"> 
                        </div>
                        <div class="panel-footer">
                            <h3>
                                <a class="btn bg-purple text-white" title="<?php echo $d->Keterangan; ?>" data-lightbox="<?php echo $model->slug; ?>" href="<?php echo Yii::app()->baseUrl . $d->File_Path; ?>">
                                    <i class="fa fa-search"></i> 
                                </a>
                            </h3>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>