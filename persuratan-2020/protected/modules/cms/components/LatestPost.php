<?php
Yii::import('zii.widgets.CPortlet');

class LatestPost extends CPortlet {

    public $data = array();

    public function run() {
        $this->renderContent();
        $content = ob_get_clean();
        echo $content;
    }

    protected function processData($data) {
        ob_start();
        ?>
        <div id="nipz-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">

                <?php
                foreach ($data as $key => $r) {
                    // var_dump($key);die;
                    // $img_url = (isset($r->Cover) && !empty($r->Cover)) ? Yii::app()->params->uploadDir . 'images/thumb/' . $r->Cover : Yii::app()->params->uploadDir . '/no-image.png';
                    $img_url = (isset($r->Cover) && !empty($r->Cover)) ? Yii::app()->params->uploadDir . 'images/' . $r->Cover : Yii::app()->params->uploadDir . '/no-image.png';
                    $link_url = Yii::app()->createUrl('/cms/post/read', array('slug' => $r->slug));
                    ?>
                    <div class="item <?= ($key === 0) ? 'active' : ''; ?>">
                        <img class="img-responsive" src="<?php echo Yii::app()->baseUrl . $img_url; ?>">
                        <div class="carousel-caption">
                            <h4 class="carousel-title"><?php echo $r->Judul; ?></h4>
                            <p><?php echo $r->wp_trim($r->Deskripsi, 150); ?></p>
                            <p>
                                <a href="<?php echo $link_url; ?>" class="readmore"><?php echo Yii::t('view', 'Baca Selengkapnya'); ?> &raquo;</a>
                            </p>
                        </div>
                    </div>

                    <!-- <div class="col-md-3 col-sm6">
                        <div class="row">
                            <div class="thumbnail">
                                <img class="img-responsive" src="<?php //echo Yii::app()->baseUrl . $img_url;   ?>">
                                <div class="caption">
                                    <h4><?php //echo $r->Judul;   ?></h4>
                                    <p><?php //echo $r->wp_trim($r->Deskripsi, 150);   ?></p>
                                    <p>
                                        <a href="<?php //echo $link_url;   ?>" class="readmore"><?php //echo Yii::t('view', 'Baca Selengkapnya');   ?> &raquo;</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <?php
                }
                ?>
            </div>
            <a class="left carousel-control" href="#nipz-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#nipz-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }

    protected function getBanner() {
        $banner = array('/themes/classic/images/adz1.png', '/themes/classic/images/adz2.png');
        echo '<div class="col-md-12 banner">';
        foreach ($banner as $b)
            echo '<img src="' . Yii::app()->baseUrl . $b . '" class="img-responsive">';
        echo '</div>';
    }

    protected function renderContent() {
        $data_ = !empty($this->data) ? $this->data : Post::model()->Berita()->findAll(array('limit' => 4));
        // $sidebar = array(
        //     'banner' => true,
        //     // 'order' => 'berita,publikasi,banner',
        // );
        if ($data_) {
            echo '<div class="col-sm-9">';
            echo $this->processData($data_);
            echo '</div>';
            echo '<div class="col-sm-3">';
            echo $this->getBanner();
            // echo $this->widget('cms.components.RightSidebar', array('data' => $sidebar));
            echo '</div>';
        } else {
            echo '';
        }
    }

}
?>