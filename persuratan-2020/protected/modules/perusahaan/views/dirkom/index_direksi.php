<?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('addDireksi'), array('class' => 'btn btn-primary')); ?><?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'direksi-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_direksi',
        'jabatan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/dirkom/updateDireksi",array("id"=>$data->id_direksi))',
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/dirkom/delDireksi",array("id"=>$data->id_direksi))',
                )
            )
        ),
    ),
));
