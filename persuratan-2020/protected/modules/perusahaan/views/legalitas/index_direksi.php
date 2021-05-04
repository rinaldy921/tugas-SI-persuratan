<a class="btn btn-primary btn-sm" href="javascript:addDireksi()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Baru</a>
<?php
// echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('addDireksi'), array('class' => 'btn btn-primary')); ?><?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'direksi-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_direksi',
        'jabatan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url' => '"javascript:updateDireksi(\"" . Yii::app()->createUrl("//perusahaan/dirkom/updateDireksi",array("id"=>$data->id_direksi)) . \'")\' ',
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/dirkom/delDireksi",array("id"=>$data->id_direksi))',
                )
            )
        ),
    ),
));
?>


<script type="text/javascript">
    function addDireksi() {
        var url = "<?php echo $this->createUrl('//perusahaan/dirkom/addDireksi', array('id_legalitas' => $id_legalitas));?>";
        var title = "Tambah Data Direksi";
        showModal(url,title);
    }

    function updateDireksi(url) {
        var title = "Tambah Data Direksi";
        showModal(url,title);
    }
</script>
