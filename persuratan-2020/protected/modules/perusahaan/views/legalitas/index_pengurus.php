<!-- <div id="page-wrapper" class="col-md-12"> -->
<br>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'rootwizard2',
        'tabs' => array(
            array(
                'label' => 'Direksi',
                'content' => $this->renderPartial('index_direksi', array('model' => $direksi,'id_legalitas'=>$id_legalitas), true),
                'active' => true
            ),
            array(
                'label' => 'Komisaris',
                'content' => $this->renderPartial('index_komisaris', array('model' => $komisaris,'id_legalitas'=>$id_legalitas), true),
            ),
        )
    ));
    ?>
<!-- </div> -->
