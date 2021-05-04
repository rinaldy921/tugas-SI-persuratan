<?php


//print_r("<pre>");print_r($model);print_r("<pre>");//die();



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
    <h3 >Data Pemegang IUPHHK-HTI Aktif (Memiliki RKT)</h3>
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title"></div>
            </div>
        </div>
     
     <div class="panel-body">
         
         
            <?php
            $this->widget('booster.widgets.TbGridView', array(
                'id' => Yii::app()->controller->id . '-hti-grid',
                'type' => 'bordered condensed striped',
                'responsiveTable' => true,
                'dataProvider' => $model,
                'template' => '{summary}{items}{pager}',
                'columns' => array(
                    array('header' => 'No', 
                        'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                                    * $this->grid->dataProvider->pagination->pageSize) + 1',
                        ),
                    array(
                        'name' => 'namaperusahaan',
                        'header' => 'Nama Perusahaan',
                    ),
                    array(
                        'name' => 'nomor',
                        'header' => 'Nomor SK IUPHHK',
                    ),
                    array(
                        'name' => 'tanggal',
                        'header' => 'Tanggal SK IUPHHK',
                    ),
                    array(
                        'name' => 'propinsi',
                        'header' => 'Provinsi',

                    ), 
                     array(
                        'name' => 'kabupaten',
                        'header' => 'Kabupaten',

                    ), 
                     array(
                        'name' => 'luas',
                        'header' => 'Luas (Ha)',
                        'value' => function($data) {
                                $nLuas =  number_format($data["luas"]);
                                return $nLuas;
                            }

                    ), 
//                    array(
//                        'header' => 'Last Login',
//                        'type' => 'raw',
//                        'value' => 'Logic::getLastLoginByPerusahan($data["id_perusahaan"])'
//
//                    ),
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
                ),
            ));
            ?>
     </div>
    </div>
        <div align="right">Tanggal Cetak : <?php echo(Yii::app()->controller->getDateMonth(date("Y/m/d") )); ?></div>
        <h5 style="font-style: italic">http://sehati.menlhk.go.id</h5>
        
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
        window.open('http://localhost:8080/'+url);
        return false;
    }
    
    function tampilDataRku(url){
        title = "RKU IUPHHK";
        window.open('http://localhost:8080/'+url);
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
