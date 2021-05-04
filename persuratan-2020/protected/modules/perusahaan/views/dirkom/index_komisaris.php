<?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('addKomisaris'), array('class' => 'btn btn-primary')); ?><?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => Yii::app()->controller->id . '-komisaris-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_komisaris',
        'jabatan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/dirkom/updateKomisaris",array("id"=>$data->id_komisaris))',
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/dirkom/delKomisaris",array("id"=>$data->id_komisaris))',
                )
            )
        ),
    ),
));
