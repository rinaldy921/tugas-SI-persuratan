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

$urlDataPokok = 'Yii::app()->createUrl("/admin/report/profil/")';
?>
<?php
$this->breadcrumbs = array(
    'IUPHHK-HTI'
);
?>
<div id="page-wrapper" class="col-md-12">
    
     <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Data Pemegang IUPHHK-HTI</div>
            </div>
        </div>
     
        <div class="panel-body"> 
        <div class="form">
       <?php 
       
            $role = Yii::app()->user->findUser()->id_role;
            if($role == 1 || $role == 5){
                  $form=$this->beginWidget('CActiveForm'); ?>
                        Nama Perusahaan  <?php echo CHtml::textField('search_by', '', array('size'=>30,'maxlength'=>25,'value'=>$search_by)); ?>                
                     <?php echo CHtml::button('Cari', array('submit' => array('iuphhk/index'))); 
                
                ?>
        <?php $this->endWidget(); ?> 
        <?php
                if($search_by){
                    echo ('<p>&nbsp;</p>');
                    $val = 'Hasil pencarian dari Nama Perusahaan = "'.$search_by.'"';
                    debug($val);
                }
            }
                ?>
        </div>   
    <?php
    
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-hti-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model,
        'filter' => $filter,
        'selectableRows'=>2,
        'enableHistory' => true,
        'responsiveTable'=>true,
        'template' => '{summary}{items}{pager}',
        'columns' =>
        
        array(
            array(
                'header' => 'No.',
                'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
            array(
                'name' => 'namaperusahaan',
                'header' => 'Nama Perusahaan',
                'value' => '$data["namaperusahaan"]',
            
             ),
            'nomor',
            'tanggal',
            array(
                'name' => 'propinsi',
                'header' => 'Provinsi',
                'value' => function($data){      
                    return $data["propinsi"];
                }
            ),            
            array(
                'header' => 'Last Login',
                'type' => 'raw',
                'value' => 'Logic::getLastLoginByPerusahan($data["id_perusahaan"])'

            ),
            array(
                'header' => 'Status',
                'type' => 'raw',
                'value' => function($data){ 
                    if($data["is_dicabut"] == 0){
                        return "Aktif";
                    }
                    else{
                        return "Di Cabut";
                    }
                    
                }
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{profil}',
                'htmlOptions' => array('style'=>'width:90px', "text-align" => "center"),
                'buttons' => array(
//                    'cabut' => array(
//                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Cabut Ijin Usaha', 'onclick' => 'formCabutIjin(this); return false;' ),
//                        'label' => '<i class="fa fa-ban"></i>',
//                        'url' => 'Yii::app()->createUrl("/admin/" . Yii::app()->controller->id . "/formcabutijin", array("id"=>$data->id_iuphhk))',
//                        'visible' => '$data->is_dicabut == 0 ? "1" : "0"'
//                    ),
                    'profil' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Data Perusahaan'),
                        'label' => '<i class="fa fa-newspaper-o"></i>',
                        'url' => 'Yii::app()->createUrl("/admin/dataIzin/",array("id"=>$data["id_iuphhk"]))',
                    ),
//                    'print' => array(
//                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Print'),
//                        'label' => '<i class="fa fa-print"></i>',
//                        'url' => function($data) {
//                            $url = "javascript:tampilDataPokok('".Yii::app()->createUrl("admin/report/profil/",array("id"=>$data->id_iuphhk))."')";
//                            return $url;
//                        },
//                    ),
//                    'iuphhk' => array(
//                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Rencana Kerja'),
//                        'label' => '<i class="fa fa-pencil-square-o"></i>',
//                        //'url' => 'Yii::app()->createUrl("/admin/rku/",array("id"=>$data->id_iuphhk))',
//                        'url' => function($data) {
//                            $url = "javascript:tampilDataRku('".Yii::app()->createUrl("admin/report/rku/",array("id"=>$data->id_iuphhk))."')";
//                            return $url;
//                        },                        
//                    ),
//                    'print' => array(
//                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Export PDF', 'class' => 'modal-fancy', 'data-fancybox-type' => 'iframe'),
//                        'label' => '<i class="fa fa-cloud-download"></i>',
//                        'url' => 'Yii::app()->createUrl("//admin/print/indexPrint",array("id"=>$data->id_iuphhk))'
//                    )
                )
         
            ),
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
    
    
    function tampilDataPokok(url){
        title = "Data Pokok IUPHHK";
        window.open('http://localhost/'+url);
        return false;
    }
    
    function tampilDataRku(url){
        title = "RKU IUPHHK";
        window.open('http://localhost/'+url);
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
</div>
</div>