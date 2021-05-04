
    <?php 
    // var_dump($model_kawasan_lindung->search()->data);die;
    
    //$sektor = !empty($model_kawasan_lindung->search()->data) ? $model_kawasan_lindung->search()->data[0]->idBlok->id_sektor : '';    
    //var_dump($sektor);
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'tataruang',
        'tabs' => array(
            array(
                'label' => 'Kawasan Lindung',
                //'content' => $this->renderPartial(empty($sektor) ? '_index_kawasanlindung' : '_index_kawasanlindung_sektor', array(
				'content' => $this->renderPartial('_index_kawasanlindung', array(
                    'bloksektor'=>$bloksektor, 
                    'idRkt'=>$idRkt, 'model' => $model_kawasan_lindung,
                    'tahun'=>$tahun
                ),
                true),
                'active' => true
            ),
            array(
                'label' => 'Areal Tidak Efektif',
                'content' => $this->renderPartial(empty($sektor) ? '_index_areal_non_produktif' : '_index_areal_non_produktif_sektor', array('bloksektor'=>$bloksektor, 'idRkt'=>$idRkt, 'model' => $model_areal_non_produktif,'tahun'=>$tahun), true),
            ),
            array(
                'label' => 'Areal Efektif',
                'content' => $this->renderPartial(empty($sektor) ? '_index_areal_produktif' : '_index_areal_produktif_sektor', array('bloksektor'=>$bloksektor, 'idRkt'=>$idRkt, 'model' => $model_areal_produktif,'tahun'=>$tahun), true),
            ),
        )
    ));
    ?>
