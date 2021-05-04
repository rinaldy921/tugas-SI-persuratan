<?php
Yii::import('zii.widgets.CPortlet');

class HomeCapaian extends CPortlet {

    public $data = array();

    public function run() {
        $this->renderContent();
        $content = ob_get_clean();
        echo $content;
    }

    protected function processData($data) {
        ob_start();
        $i = 0;
        foreach ($data as $r) {
            $i++;
            $bg = ($i % 2) ? "bg-1" : "bg-2";
            ?>
            <div class="col-md-3 col-xs-6 <?php echo $bg; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-7 col-xs-7">
                                <p class="persen">
                                    <?php echo $r['capaian']; ?><sup>%</sup>
                                </p>
                            </div>
                            <div class="col-md-5 col-xs-5 target">
                                <p><?php echo Yii::t('view', 'Dari Target'); ?></p>
                                <p><?php echo $r['target']; ?>%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-we nipz-topline">
                            <p><?php echo $r['instansi']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        return ob_get_clean();
    }

    protected function renderContent() {
        if (isset($this->data) && !empty($this->data)) {
            echo '<div class="panel nipz-panel">';
            echo '<div class="panel-heading header">' . $this->data['title'] . '</div>';
            echo '<div class="panel-body">';
            echo $this->processData($this->data['values']);
            echo '</div>';
            echo '</div>';
        } else {
            echo '';
        }
    }

}
?>