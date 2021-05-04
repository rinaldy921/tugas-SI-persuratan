<?php
if (Yii::app()->user->hasIuphhk()) {
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('addMataAir'), array('class' => 'btn btn-primary btn-sm'));
}

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-mata-air-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'enableSorting' => false,
    'dataProvider' => $mataAir->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_mata_air',
        'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/delMataAir",array("id"=>$data->id))',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updateMataAir",array("id"=>$data->id))',
                )
            )
        ),
    ),
));
?>