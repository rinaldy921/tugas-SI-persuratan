<h4 class="page-header">Data Sertifikasi VLK</h4>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-phpl-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelPhpl->search(),
    // 'filter'=>$model,
    'enableSorting' => false,
    'template' => '{items}',
    'columns' => array(
        'tahun_sertifikasi',
        'nilai_kinerja',
        'predikat',
        'tanggal_mulai',
        'tanggal_berakhir',
        'penerbit',
        'biaya',
    ),
));
?>
<br>
<br>
<h4 class="page-header">Data Sertifikasi VLK</h4>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-vlk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelVlk->search(),
    // 'filter'=>$model,
    'enableSorting' => false,
    'template' => '{items}',
    'columns' => array(
        'nomor',
        'berlaku',
        'berakhir',
        'penerbit',
    ),
));
?>