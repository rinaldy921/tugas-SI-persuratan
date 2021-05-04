<?php
// echo $id_bulan;
$this->widget('booster.widgets.TbTabs', array(
    'type' => 'tabs',
    'id' => 'panen2',
    'tabs' => array(
        array(
            'label' => 'Tenaga Tetap',
            'content' => $this->renderPartial('index_tetap', array(
                'modelSerapan' => $modelSerapan,
                'tahun'=>$tahun,
                'id_bulan'=>$id_bulan
            ),
            true),
            'active' => true
        ),
        array(
            'label' => 'Tenaga Tidak Tetap',
            'content' => $this->renderPartial('index_tidak_tetap', array(
                'modelSerapan' => $modelSerapan,
                'tahun'=>$tahun,
                'id_bulan'=>$id_bulan
            ),
            true),
        ),
    )
));

?>
