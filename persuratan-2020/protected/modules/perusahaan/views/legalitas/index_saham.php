<div id="page-wrapper" class="col-md-12">
    <a class="btn btn-primary btn-sm" href="javascript:addSaham()"><i class="glyphicon glyphicon-plus-sign"></i> Buat Data Baru</a>
    <!-- <br>
    <br> -->
    <?php
    // if($modal->jenis) {
    //     $this->widget('booster.widgets.TbEditableDetailView', array(
    //         'data' => $modal,
    //         'url' => $this->createUrl('//perusahaan/saham/updateModal'),
    //         'attributes' => array(
    //             array(
    //                 'name' => 'jenis',
    //                 'label' => 'Status Permodalan',
    //                 'value' => ($modal->jenis == 'PMDN') ? 'Penanaman Modal Dalam Negeri (' . $modal->jenis . ')' : 'Penanaman Modal Asing (' . $modal->jenis . ')',
    //                 'editable' => array(
    //                     'type' => 'select',
    //                     'source' => array('PMDN' => 'PMDN', 'PMA' => 'PMA'),
    //                     'apply' => true,
    //                 )
    //             ),
    //         ),
    //     ));
    // }
    ?>

    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => 'saham-saham-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'enableSorting' => false,
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            array(
                'header' => 'Status Permodalan',
                'class' => 'booster.widgets.TbEditableColumn',
                'name' => 'jenis',
                'type' => 'raw',
                'editable' => array(
                    'type' => 'select',
                    'source' => array('PMDN' => 'PMDN', 'PMA' => 'PMA'),
                    'apply' => true,
                    'url' => $this->createUrl('//perusahaan/saham/updateSaham'),
                    'success' => 'js:function() {
	                $.fn.yiiGridView.update("saham-saham-grid");
	            }'
                ),
            ),
            array(
                'header' => 'Nama Pemodal',
                'name' => 'nama_pemodal'
            ),
            array(
                'class' => 'booster.widgets.TbEditableColumn',
                'name' => 'jumlah',
                'type' => 'raw',
                'editable' => array(
                    'url' => $this->createUrl('//perusahaan/saham/updateSaham'),
                    'success' => 'js:function() {
	                $.fn.yiiGridView.update("saham-saham-grid");
	            }'
                ),
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{delete}',
                'buttons' => array(
                    'delete' => array(
                       'url'=>'Yii::app()->createUrl("perusahaan/saham/delete", array("id"=>$data->id))',
                    )
                )
            ),
        ),
    ));
    ?>
</div>



<script type="text/javascript">
    function addSaham() {
        var url = "<?php echo $this->createUrl('//perusahaan/saham/create', array('id_legalitas' => $id_legalitas));?>";
        var title = "Tambah Data Saham";
        showModal(url,title);
    }


</script>
