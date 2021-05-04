<a class="btn btn-primary btn-sm" href="javascript:addKomisaris()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Baru</a>
<?php
 // echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('addKomisaris'), array('class' => 'btn btn-primary')); ?><?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'komisaris-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        'nama_komisaris',
        'jabatan',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url' => '"javascript:updateDireksi(\"" . Yii::app()->createUrl("//perusahaan/dirkom/updateKomisaris",array("id"=>$data->id_komisaris)) . \'")\' ',
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("//perusahaan/dirkom/delKomisaris",array("id"=>$data->id_komisaris))',
                )
            )
        ),
    ),
));

?>
<script type="text/javascript">
    function addKomisaris() {
        var url = "<?php echo $this->createUrl('//perusahaan/dirkom/addKomisaris', array('id_legalitas' => $id_legalitas));?>";
        var title = "Tambah Data Komisaris";
        showModal(url,title);
    }

    function updateKomisaris(url) {
        var title = "Tambah Data Komisaris";
        showModal(url,title);
    }
</script>
