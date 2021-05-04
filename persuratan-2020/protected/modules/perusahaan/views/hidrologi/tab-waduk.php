<?php
if (Yii::app()->user->hasIuphhk()) {
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Data'), array('addWaduk'), array('class' => 'btn btn-primary btn-sm'));
}

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-waduk-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $waduk->search(),
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_waduk',
        'keterangan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/delWaduk",array("id"=>$data->id))',
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/perusahaan/" . Yii::app()->controller->id . "/updateWaduk",array("id"=>$data->id))',
                )
            )
        ),
    ),
));
?>