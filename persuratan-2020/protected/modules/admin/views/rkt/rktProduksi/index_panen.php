<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'panen',
    'tabs' => array(
        array(
            'label' => 'Luas Areal',
            'content' => $this->renderPartial('rktProduksi/_index_panenareal', array(
                'model' => $modelPanenAreal,
                    ), true),
            'active' => true
        ),
        array(
            'label' => 'Volume Produksi Hasil Tanaman',
            'content' => $this->renderPartial('rktProduksi/_index_panentanaman', array(
                'model' => $modelPanenTanaman
                    ), true),
        ),
        array(
            'label' => 'Volume Produksi Penyiapan Lahan (LOA & Non LOA)',
            'content' => $this->renderPartial('rktProduksi/_index_panensiaplahan', array(
                'model' => $modelPanenSiapLahan
                    ), true),
        ),
    )
));
?>
