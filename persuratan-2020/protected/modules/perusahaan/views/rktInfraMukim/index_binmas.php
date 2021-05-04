
    <?php 
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'binmas',
        'tabs' => array(
            array(
                'label' => 'Kerjasama Koperasi',
                'content' => $this->renderPartial('_index_kerjasama', array('tahun'=>$tahun, 'model'=>$modelKerjasama,'idRkt'=>$idRkt), true),
                'active' => true,
                'linkOptions'=>array('id'=>'1')
            ),
            array(
                'label' => 'Kemitraan Usaha',
                'content' => $this->renderPartial('_index_bangunmitra', array('tahun'=>$tahun, 'model'=>$modelBangunMitra,'idRkt'=>$idRkt), true),
                'linkOptions'=>array('id'=>'2')
            ),
            // array(
            //     'label' => 'Areal Produktif',
            //     'content' => $this->renderPartial('_index_areal_produktif', array('bloksektor'=>$bloksektor, 'idRkt'=>$idRkt, 'model' => $model_areal_produktif), true),
            // ),
        )
    ));
    ?>


