
    <?php
    // echo $modelPanenAreal->id_rkt;
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'panen2',
        'tabs' => array(
            array(
                'label' => 'Luas Areal',
                'content' => $this->renderPartial(empty($sektor) ? '_index_panenareal' : '_index_panenareal_sektor', array(
                    'model' => $modelPanenAreal,
                    'tahun'=>$tahun
                ),
                true),
                'active' => true
            ),
            array(
                'label' => 'Volume Produksi Hasil Tanaman',
                'content' => $this->renderPartial(empty($sektor) ? '_index_panentanaman' : '_index_panentanaman_sektor', array(
                    'model' => $modelPanenTanaman,
                    'tahun'=>$tahun
                ),
                true),
            ),
            array(
                'label' => 'Volume Produksi Penyiapan Lahan (LOA & Non LOA)',
                'content' => $this->renderPartial('_index_panensiaplahan', array(
                    'model' => $modelPanenSiapLahan,
                    'tahun'=>$tahun
                ),
                true),
            ),
        )
    ));
    ?>
