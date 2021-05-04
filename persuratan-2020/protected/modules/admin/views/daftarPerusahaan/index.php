<?php
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => '.modal-fancy',
    'config' => array(
        "autoSize" => false,
        "closeBtn" => true,
        // "showCloseButton" => true,
        "fitToView" => true,
        'width' => '50%',
        'openEffect' => 'none',
        'openSpeed' => 600,
        'closeEffect' => 'none',
        'nextEffect' => 'none',
        'prevEffect' => 'none',
        "helpers" => array("overlay" => array("closeClick" => true)),
        'scrolling' => 'auto',
    ),
));
?>
<?php
$this->breadcrumbs = array(
    'IUPHHK-HTI'
);

//print_r("<pre>");
//print_r($model);
//print_r("</pre>"); die();
?>
<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Data Pemegang IUPHHK-HTI</h4>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-hti-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model,
//        'filter' => $model,
        'template' => '{summary}{items}{pager}',
        'columns' => array(
            array(
//                'name' => 'no',
                'header' => 'No',
                'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            ),
            array(
                'name' => 'nama_perusahaan',
                'header' => 'Nama Perusahaan',
                'value' => '$data[nama_perusahaan]'
            ),
            array(
                'name' => 'nomor_sk_iuphhk',
                'header' => 'Nomor SK',
                'value' => '$data[nomor_sk_iuphhk]'
            ),
            array(
                'name' => 'tgl_sk_iuphhk',
                'header' => 'Tanggal SK',
                'value' => '$data[tgl_sk_iuphhk]'
            ),
            array(
                'name' => 'propinsi',
                'header' => 'Provinsi',
                'value' => '$data[propinsi]'
            ),
            array(
                'header'=>'Aksi',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{profil} {iuphhk} {print}',
                'htmlOptions' => array('style'=>'width:90px', "text-align" => "center"),
                'buttons' => array(
                    'profil' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Data Pokok'),
                        'label' => '<i class="fa fa-search"></i>',
                        'url' => 'Yii::app()->createUrl("/admin/dataIzin/",array("id"=>$data[id_iuphhk]))',
                    ),
                    'iuphhk' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Rencana Kerja'),
                        'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'url' => 'Yii::app()->createUrl("/admin/rku/",array("id"=>$data[id_iuphhk]))',
                    ),
                    'print' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Export PDF', 'class' => 'modal-fancy', 'data-fancybox-type' => 'iframe'),
                        'label' => '<i class="fa fa-cloud-download"></i>',
                        'url' => 'Yii::app()->createUrl("//admin/print/indexPrint",array("id"=>$data[id_iuphhk]))'
                    )
                )
            ),
            /*
            'nomor',
            'tanggal',
            array(
                //'name' => 'provinsi',
                'header' => 'Provinsi',
                'value' => function($data){
                    $model = AdmPemerintahan::model()->find(array(
                        'condition' => 'id_perusahaan='.$data->id_perusahaan
                    ));                    
                    return $model->provinsi0->nama;
                }
            ),            
            array(
                'header' => 'Last Login',
                'type' => 'raw',
                'value' => 'Logic::getLastLoginByPerusahan($data->id_perusahaan)'
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{cabut} {profil} {iuphhk} {print}',
                'htmlOptions' => array('style'=>'width:90px', "text-align" => "center"),
                'buttons' => array(
                    'cabut' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Cabut Ijin Usaha', 'onclick' => 'formCabutIjin(this); return false;' ),
                        'label' => '<i class="fa fa-ban"></i>',
                        'url' => 'Yii::app()->createUrl("/admin/" . Yii::app()->controller->id . "/formcabutijin", array("id"=>$data->id_iuphhk))',
                        'visible' => '$data->is_dicabut == 0 ? "1" : "0"'
                    ),
                    'profil' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Data Pokok'),
                        'label' => '<i class="fa fa-search"></i>',
                        'url' => 'Yii::app()->createUrl("/admin/dataIzin/",array("id"=>$data->id_iuphhk))',
                        // 'url' => 'Yii::app()->createUrl("/admin/" . Yii::app()->controller->id . "/view",array("id"=>$data->id_perusahaan))',
                    ),
                    'iuphhk' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Rencana Kerja'),
                        'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'url' => 'Yii::app()->createUrl("/admin/rku/",array("id"=>$data->id_iuphhk))',
                    ),
                    'print' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Export PDF', 'class' => 'modal-fancy', 'data-fancybox-type' => 'iframe'),
                        'label' => '<i class="fa fa-cloud-download"></i>',
                        'url' => 'Yii::app()->createUrl("//admin/print/indexPrint",array("id"=>$data->id_iuphhk))'
                    )
                )
            ),*/
        ),
    ));
    ?>
</div>

<div id="modal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 50%;">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button> -->
          <h4 class="modal-title" id="modalTitle"></h4>
        </div>
        <div class="modal-body" id="modalBody">
            Loading ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" style="float:left" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary" id="modalBtnSave">Save changes</button> -->
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
    function formCabutIjin(el)
    {
        url = $(el).attr('href');
        title = "Cabut Ijin Usaha";
        showModal(url, title);
        return false;
    }

    function showModal(url,title) {
        $("#modalTitle").empty();
        $("#modalTitle").html(title);

        $("#modalBody").empty();
        $("#modalBody").html("Loading ...");
        $("#modalBody").load(url);

        $('#modal').modal({backdrop: 'static', keyboard: false});
        $("#modal").modal("show");
        return false;
    }
</script>
