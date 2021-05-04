<?php
if (Yii::app()->user->hasIuphhk()) {
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('createTanah'), array('class' => 'btn btn-primary btn-sm'));
}

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-tanah-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $tanah->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama',
        'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn', 'htmlOptions' => array('nowrap' => 'nowrap'),
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/delTanah",array("id"=>$data->id_tanah))',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updateTanah",array("id"=>$data->id_tanah))',
                )
            )
        ),
    ),
));
?>