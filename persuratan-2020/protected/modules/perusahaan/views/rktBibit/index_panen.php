
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'panen',
        'tabs' => array(
            // array(
            //     'label' => 'Luas Areal',
            //     'content' => $this->renderPartial(empty($sektor) ? '_index_panenareal' : '_index_panenareal_sektor', array(
            //         'model' => $modelPanenAreal,
            //         'tahun'=>$tahun
            //     ),
            //     true),
            //     'active' => true
            // ),
            // array(
            //     'label' => 'Volume Produksi Hasil Tanaman',
            //     'content' => $this->renderPartial(empty($sektor) ? '_index_panentanaman' : '_index_panentanaman_sektor', array(
            //         'model' => $modelPanenTanaman,
            //         'tahun'=>$tahun
            //     ),
            //     true),
            // ),
            // array(
            //     'label' => 'Volume Produksi Penyiapan Lahan (LOA & Non LOA)',
            //     'content' => $this->renderPartial('_index_panensiaplahan', array(
            //         'model' => $modelPanenSiapLahan,
            //         'tahun'=>$tahun
            //     ),
            //     true),
            // ),
            array(
                'label' => 'Hasil Hutan Kayu',
                'content' => $this->renderPartial('_index_panen_kayu', array(
                    'modelPanenAreal' => $modelPanenAreal,
                    'modelPanenTanaman' => $modelPanenTanaman,
                    'modelPanenSiapLahan' => $modelPanenSiapLahan,
                    'tahun'=>$tahun
                ),
                true),
                'active' => true
            ),
            array(
                'label' => 'Hasil Hutan Non Kayu',
                'content' => $this->renderPartial('_index_nonkayu', array(
                    'model' => $modelNonKayu,
                    'tahun'=>$tahun
                ),
                true),
            ),
            // array(
            //     'label' => 'Areal Efektif',
            //     'content' => $this->renderPartial('_index_areal_produktif', array('bloksektor'=>$bloksektor, 'idRkt'=>$idRkt, 'model' => $model_areal_produktif), true),
            // ),
        )
    ));
    ?>
