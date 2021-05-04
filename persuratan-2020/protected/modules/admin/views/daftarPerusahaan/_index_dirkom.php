<h4> Data Direksi </h4>
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-direksi-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $modelDireksi->search(),
    // 'mergeColumns' => array('jenis_legalitas'),
    'enableSorting' => false,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        array(
            'name' => 'nama_direksi',
        ),
        array(
            'name' => 'jabatan',
        )
    ),
));
?>
<br>
<br>
<h4> Data Komisaris </h4>
<?php
$this->widget('booster.widgets.BootGroupGridView', array(
    'id' => Yii::app()->controller->id . '-komisaris-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $komisaris->search(),
    // 'mergeColumns' => array('jenis_legalitas'),
    'enableSorting' => false,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        array(
            'name' => 'nama_komisaris',
        ),
        array(
            'name' => 'jabatan',
        )
    ),
));
?>