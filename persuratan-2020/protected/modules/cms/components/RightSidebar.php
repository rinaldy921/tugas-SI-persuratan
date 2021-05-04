<?php
Yii::import('zii.widgets.CPortlet');

class RightSidebar extends CPortlet {

    public $data = array();

    public function run() {
        $this->renderContent();
        $content = ob_get_clean();
        echo $content;
    }

    protected function renderContent() {
        echo!empty($this->data) ? $this->processData($this->data) : '';
    }

    protected function processData($data) {
        ob_start();
        $order = isset($data['order']) ? explode(",", $data['order']) : array('berita', 'banner');
        $show_ads = (isset($data['banner']) && $data['banner'] === false) ? false : true;
        foreach ($order as $o) {
            $fn = 'get' . ucfirst($o);
            if ($o == 'banner' && $show_ads === false) {
                continue;
            } else {
                echo method_exists($this, $fn) ? $this->$fn() : $fn . Yii::t('view', ' tidak ditemukan');
            }
        }
        return ob_get_clean();
    }

    protected function getBerita() {
        $post = Post::model()->Berita()->findAll(array('limit' => 5));
        ob_start();
        if ($post) {
            echo '<div class="col-md-12 berita-kanan">';
            echo '<div class="header">' . Yii::t('view', 'Berita Terkait') . '</div>';
            foreach ($post as $p) {
                ?>
                <div class="media">
                    <div class="media-body">
                        <h5 class="media-heading">
                            <strong>
                                <?php echo CHtml::link($p->Judul, array('/cms/post/read', 'slug' => $p->slug)); ?>
                            </strong>
                        </h5>
                        <p><?php echo $p->wp_trim($p->Deskripsi, 120); ?></p>
                        <p class="readmore">
                            <strong><?php echo CHtml::link("Baca Selengkapnya &raquo;", array('/cms/post/read', 'slug' => $p->slug)); ?></strong>
                        </p>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        }
        return ob_get_clean();
    }

    protected function getBanner() {
        $banner = array('/themes/classic/images/adz.png');
        echo '<div class="col-md-12">';
        foreach ($banner as $b)
            echo '<img src="' . Yii::app()->baseUrl . $b . '" class="img-responsive">';
        echo '</div>';
    }

    protected function getPublikasi() {
        $post = Publikasi::model()->Hukum()->findAll(array('limit' => 5));
        ob_start();
        if ($post) {
            echo '<div class="col-md-12 berita-kanan">';
            echo '<div class="header">' . Yii::t('view', 'Publikasi Terkini') . '</div>';
            foreach ($post as $p) {
                ?>
                <div class="media">
                    <div class="media-body">
                        <h5 class="media-heading">
                            <strong>
                                <?php echo CHtml::link($p->Judul, array('/cms/publikasi/read', 'slug' => $p->slug)); ?>
                            </strong>
                        </h5>
                        <p><?php echo $p->wp_trim($p->Deskripsi, 120); ?></p>
                        <p class="readmore">
                            <strong><?php echo CHtml::link("Baca Selengkapnya &raquo;", array('/cms/publikasi/read', 'slug' => $p->slug)); ?></strong>
                        </p>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        }
        return ob_get_clean();
    }

    protected function getRandomGaleri() {
        $this->getAlbum();
    }

    protected function getAlbum() {
        $post = Publikasi::model()->with('attachments')->find(array('condition' => "Kategori = 'Album'", 'order' => 'RAND()'));
        if (!empty($post->attachments)) {
            echo '<div class="col-md-12 berita-kanan">';
            echo '<div class="header">' . Yii::t('view', 'Album Galeri') . '</div>';
            foreach ($post->attachments as $a) {
                echo '<div class="media">';
                echo '<div class="media-body">';
                $img_url = '<img src="' . Yii::app()->baseUrl . Yii::app()->params->uploadDir . 'images/thumb/' . $a->File_Name . '" class="img-responsive">';
                echo CHtml::link($img_url, Yii::app()->baseUrl . $a->File_Path, array('data-lightbox' => 'image-1', 'title' => $a->Keterangan));
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '<div class="clear clearfix"></div>';
        }
        Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl . "/css/lightbox.css");
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . "/js/lightbox-2.6.min.js", CClientScript::POS_END);
    }

}
?>