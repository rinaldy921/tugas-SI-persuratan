
<?php

$sektor = $model_kawasan_lindung->search()->data[0]->idBlok->id_sektor;
$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'tataruang',
    'tabs' => array(
        array(
            'label' => 'Kawasan Lindung',
            'content' => $this->renderPartial(empty($sektor) ? 'test/_index_kawasanlindung' : 'test/_index_kawasanlindung_sektor', array(
                'bloksektor' => $bloksektor,
                'idRkt' => $idRkt, 'model' => $model_kawasan_lindung,
                    ), true),
            'active' => true
        ),
        array(
            'label' => 'Areal Tidak Efektif',
            'content' => $this->renderPartial(empty($sektor) ? 'test/_index_areal_non_produktif' : 'test/_index_areal_non_produktif_sektor', array('bloksektor' => $bloksektor, 'idRkt' => $idRkt, 'model' => $model_areal_non_produktif), true),
        ),
        array(
            'label' => 'Areal Efektif',
            'content' => $this->renderPartial(empty($sektor) ? 'test/_index_areal_produktif' : 'test/_index_areal_produktif_sektor', array('bloksektor' => $bloksektor, 'idRkt' => $idRkt, 'model' => $model_areal_produktif), true),
        ),
    )
));
?>
