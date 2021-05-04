
    <?php 
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'bina',
        'tabs' => array(
            array(
                'label' => 'Pembangunan Penyaluran Infrastruktur Pemukiman',
                'content' => $this->renderPartial('_index_inframukim', array('tahun'=>$tahun, 'model'=>$modelInfraMukim), true),
                'active' => true
            ),
            array(
                'label' => 'Peningkatan SDM',
                'content' => $this->renderPartial('_index_sdm', array('tahun'=>$tahun, 'model'=>$modelSdm), true),
            ),
            // array(
            //     'label' => 'Areal Produktif',
            //     'content' => $this->renderPartial('_index_areal_produktif', array('bloksektor'=>$bloksektor, 'idRkt'=>$idRkt, 'model' => $model_areal_produktif), true),
            // ),
        )
    ));
    ?>
