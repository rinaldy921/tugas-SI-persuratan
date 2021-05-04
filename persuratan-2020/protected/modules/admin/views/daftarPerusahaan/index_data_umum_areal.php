<h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Kelompok Hutan</h4>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kelompok-hutan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $pokhut->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama',
        'keterangan',
    )
));
?>
<br>

<h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Keadaan Lahan</h4>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-kelompok-hutan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $keadaan_lahan,
    'template' => '{items}',
    'columns' => array(
        array(
            'name' => 'jenis',
            'header' => 'Jenis Lahan',
        ),
        array(
            'name' => 'jml',
            'header' => 'Luas (Ha)',
            'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data["jml"])'
        ),
        array(
            'name' => 'persen',
            'header' => 'Pesentase (%)'
        ),
    )
));
?>
<br>

<h4><i class="fa fa-bars" style="cursor:pointer;" id="btn-kelompok_hutan"></i> Topografi</h4>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $topografi,
    'htmlOptions' => array('class' => 'detail-view table-bordered'),
    'attributes' => array(
        array(
            'label' => 'Datar (0-8%)',
            'value' => $topografi->datar ? floatval($topografi->datar) . ' Ha' : null,
        ),
        array(
            'label' => 'Landai (8-15%)',
            'value' => $topografi->landai ? floatval($topografi->landai) . ' Ha' : null,
        ),
        array(
            'label' => 'Agak Curam (15-25%)',
            'value' => $topografi->agak_curam ? floatval($topografi->agak_curam) . ' Ha' : null,
        ),
        array(
            'label' => 'Curam (25-40%)',
            'value' => $topografi->curam ? floatval($topografi->curam) . ' Ha' : null,
        ),
        array(
            'label' => 'Sangat Curam (>40%)',
            'value' => $topografi->sangat_curam ? floatval($topografi->sangat_curam) . ' Ha' : null,
        ),
        array(
            'label' => 'Ketinggian Tempat (dpl)',
            'value' => $topografi->ketinggian ? floatval($topografi->ketinggian) . ' dpl' : null,
        )
    ),
));
?>