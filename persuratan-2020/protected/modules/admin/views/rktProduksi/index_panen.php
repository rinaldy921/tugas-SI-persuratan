<?php

$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'panen',
    'tabs' => array(
        array(
            'label' => 'Pemanenan RKT',
            'content' => $this->renderPartial('_index_panen_produksi', array(
                'model' => $modelPanenProduksi,
                    ), true),
            'active' => true
        ),
        array(
            'label' => 'Pemanenan Penyiapan Lahan',
            'content' => $this->renderPartial('_index_panen_lahan', array(
                'model' => $modelPanenLahan
                    ), true),
        ),
        array(
            'label' => 'Pemanenan HHBK',
            'content' => $this->renderPartial('_index_panen_hhbk', array(
                'model' => $modelPanenHhbk
                    ), true),
        ),
    )
));
?>
