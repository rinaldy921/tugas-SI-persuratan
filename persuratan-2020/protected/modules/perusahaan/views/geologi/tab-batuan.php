<?php
if (Yii::app()->user->hasIuphhk()) {
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('createBatuan'), array('class' => 'btn btn-primary btn-sm'));
}

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-batuan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $batuan->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_batuan',
        'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/delBatuan",array("id"=>$data->id))',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updateBatuan",array("id"=>$data->id))',
                )
            )
        ),
    ),
));
?>