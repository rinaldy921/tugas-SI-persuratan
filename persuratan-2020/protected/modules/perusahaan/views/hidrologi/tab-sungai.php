<?php
if (Yii::app()->user->hasIuphhk()) {
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('addSungai'), array('class' => 'btn btn-primary btn-sm'));
}

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-sungai-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $sungai->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_sungai',
        'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/delSungai",array("id"=>$data->id_sungai))',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updateSungai",array("id"=>$data->id_sungai))',
                )
            )
        ),
    ),
));
?>