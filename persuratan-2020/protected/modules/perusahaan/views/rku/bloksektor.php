<?php
$this->breadcrumbs = array(
    'RKU' => array('index'),
    
);



?>

<style media="screen">
/* grid border */
.grid-view table.items th, .grid-view table.items td {
border: 1px solid gray !important;
}

/* disable selected for merged cells */
.grid-view td.merge {
background: none repeat scroll 0 0 #F8F8F8;
}
</style>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">

    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Data RKU UPHHK-HTI</div>
            </div>
        </div>

        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
    //            'id_rku',
    //            'id_perusahaan',
                'nomor_sk',
                'tgl_sk',
                array(
                    'name' => "Tahun",
                    'value' => function($data) {
                        $awal = $data->tahun_mulai;
                        $akhir = $data->tahun_sampai;
                        return $awal .' s/d '.$akhir;
                    }
                ),
                array(
                    'name' => "Berlaku",
                    'value' => function($data) {
                        $awal = isset($data->mulai_berlaku) ? Yii::app()->controller->getDateMonth($data->mulai_berlaku) : "-";
                        $akhir = isset($data->akhir_berlaku) ? Yii::app()->controller->getDateMonth($data->akhir_berlaku) : "-";
                        return $awal .' s/d '.$akhir;
                    }
                ),
            ),
        ));
                
                
        ?>

        
        </div>
    
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Unit Kelestarian dan Petak Kerja</div>
            </div>
        </div>  
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => Yii::app()->controller->id . '-form',
            'type' => 'horizontal',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="panel-body">
           
      
            <?php
//                    print_r("<pre>");
//                    print_r($model);
//                    print_r("<pre>");
            ?>
            
            
            <div class="form-group">
                <div class="col-sm-3" style="text-align: left">
                     <?php
                        $this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'htmlOptions' => array('class' => 'btn-sm','id'=>'btnAddNewSektor'),
                            'context' => 'primary',
                            'label' => 'Tambah Unit Kelestarian', 

                        ));
                    ?> 
                </div>
               
            </div> 
            
            
            <div class="form-group">
                <div class="col-sm-3" style="text-align: right">
                    &nbsp;
                </div>
                <div class="col-sm-9">
                    &nbsp;
                </div>
             </div>  
            
       <div id="sektor_area" style="display: none">   
            <?php echo  $form->textFieldGroup($model,'namaSektor',
                                            CHtml::listData(RkuSektor::model()->findAllByAttributes(array('id_rku'=>$rkuId)),'id_sektor','nama_sektor'),
                                            array('empty'=>'   --- Pilih Unit Kelestarian ---   ') ); ?>
			<div class="form-group">
                <div class="col-sm-3" style="text-align: right">
                </div>
                <div class="col-sm-9">
                    <?php
                        $urlAddNewSektor = Yii::app()->createUrl("perusahaan/rku/addNewSektor"); 

                        $this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'htmlOptions' => array('class' => 'btn-sm','id'=>'btnSaveSektor'),
                            'context' => 'primary',
                            'label' => 'Simpan Unit Kelestarian', 

                        ));
						
						echo "   ";
						
						$this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'htmlOptions' => array('class' => 'btn-sm','id'=>'btnBatalSektor'),
                            'context' => 'primary',
                            'label' => 'Batal', 

                        ));
                    ?>
                </div>
            </div> 
	   
	   
	   
	   
	   </div>       
            
           
            
        
     <?php   
             echo '<h4> Daftar Unit Kelestarian   </h4>';
//     print_r("<pre>");
//        print_r($modelblok);
//        print_r("</pre>"); exit(1);
     
          $this->widget('ext.groupgridview.GroupGridView', array(
          'id' => 'grid2',
          'dataProvider' => $modelSektor,
          'columns' => array(
            
            array(
              'name' => 'Nama Unit Kelestarian',
              'value' => function($data) {
                  return $data['nama_sektor'];
              }
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update}',
                'buttons' => array(
                    'update' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit'),
                        // 'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'label' => '<i class="fa fa-edit"></i>',
                        'url' => function($data) {
                            $url = "javascript:getSektor(".$data['id_sektor'].",'".$data['nama_sektor']."')";
                            return $url;
                        }
                    ),
                )
                            
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{delete2}',
                'buttons' => array(
                    'delete2' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Hapus'),
                        // 'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'label' => '<i class="fa fa-trash"></i>',
                        'url' => function($data) {
                            $url = "javascript:deleteSektor('".Yii::app()->createUrl("perusahaan/rku/deletesektor",array("id_sektor"=>$data['id_sektor'],"id_rku"=>$data['id_rku']))."')";
                            return $url;
                        }
                    ),
                )
                            
            )
            
          ),
        ));
        ?>
            
            
       <div class="form-group">
                <div class="col-sm-3" style="text-align: left">
                     <?php
                        
                        $this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'htmlOptions' => array('class' => 'btn-sm','id'=>'btnAddNewBlok'),
                            'context' => 'primary',
                            'label' => 'Tambah Petak Kerja', 

                        ));
                    ?>
                </div>
                
            </div>         
            
            
            
            
     <div id="blok_area" style="display: none">    
            <div class="form-group">
                <div class="col-sm-3" style="text-align: right">
                    <?php echo CHtml::activeLabel($model,'sektor');?>
                </div>
                <div class="col-sm-9">
                
                <?php echo  $form->dropDownList($model,'sektor',
                                            CHtml::listData(RkuSektor::model()->findAllByAttributes(array('id_rku'=>$rkuId)),'id_sektor','nama_sektor'),
                                            array('empty'=>'   --- Pilih Unit Kelestarian ---   ') ); ?>
                </div>
             </div>     
                <?php echo $form->textFieldGroup($model, 'idsektor', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5','value'=>'0')))); ?>

                 <?php echo $form->textFieldGroup($model, 'idblok', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5','value'=>'0')))); ?>

                <?php echo  $form->textFieldGroup($model, 'blok', array('labelOptions'=>array('class'=>'required'), 'groupOptions'=>array('id'=>'blok'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
            
            
           
            
            
            
            <div class="form-group">
                <div class="col-sm-3" style="text-align: right">
                </div>
                <div class="col-sm-9">
                    <?php
                        $urlAdd = Yii::app()->createUrl("perusahaan/rku/addBlokSektor"); 

                        $this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'htmlOptions' => array('class' => 'btn-sm','id'=>'btnAddBlok'),
                            'context' => 'primary',
                            'label' => 'Simpan Petak Kerja',  

                        ));
						echo "   ";
						$this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'button',
                            'htmlOptions' => array('class' => 'btn-sm','id'=>'btnBatalBlok'),
                            'context' => 'primary',
                            'label' => 'Batal', 

                        ));
						
                    ?>
                </div>
            </div> 
        </div>          
            
     <?php   
           echo '<h4> Daftar Petak Kerja  </h4>';
     
          $this->widget('ext.groupgridview.GroupGridView', array(
          'id' => 'grid1',
          'dataProvider' => $modelblok,
          'mergeColumns' => 'Unit Kelestarian',
          'columns' => array(
            array(
              'name'=>'Unit Kelestarian',
              'value' => function($data) {
                  return $data['nama_sektor'];
              }
            ),
            array(
              'name' => 'Petak Kerja',
              'value' => function($data) {
                  return $data['nama_blok'];
              }
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update}',
                'buttons' => array(
                    'update' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit'),
                        // 'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'label' => '<i class="fa fa-edit"></i>',
                        'url' => function($data) {
                            $url = "javascript:getBlok('".Yii::app()->createUrl("perusahaan/rku/getbloksektor",array("id_blok"=>$data['id']))."',".$data['id'].")";
                            return $url;
                        }
                    ),
                )
                            
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{delete2}',
                'buttons' => array(
                    'delete2' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Hapus'),
                        // 'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'label' => '<i class="fa fa-trash"></i>',
                        'url' => function($data) {
                            $url = "javascript:deleteBlok('".Yii::app()->createUrl("perusahaan/rku/deletebloksektor",array("id_blok"=>$data['id']))."',".$data['id'].")";
                            return $url;
                        }
                    ),
                )
                            
            )
            
          ),
        ));
        ?>
          
        </div>
        <div class="panel-footer">
            <!--        <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">-->
            <?php
            //$this->widget('booster.widgets.TbButton', array(
            //    'buttonType' => 'submit',
            //    'htmlOptions' => array('class' => 'btn-sm','id'=>'nipzsubmit'),
            //    'context' => 'primary',
            //    'label' => 'Simpan',
            //));
            ?>
            <!--</div>-->
        </div>
        


       <?php $this->endWidget(); ?>   

<script type="text/javascript">
    function deleteBlok(url, id)
    {
        swal({
          title: "Konfirmasi?",
          text: "Hapus Blok ?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
              var form = new FormData($("#<?=Yii::app()->controller->id . '-form'?>")[0]);
              $.ajax({
                type: "GET",
                // data: 'id='+id,
                dataType: "json",
                contentType: false,
                processData: false,
                url: url,
                success: function(result) {
                    swal(result.header, result.message, result.status).then((ok) => {
                        $.fn.yiiGridView.update("grid1");
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
          } else {
            // swal("Your imaginary file is safe!");
          }
        });
    }
    
    
    function getBlok(url, id)
    {
                $.ajax({
			type: "POST",
                data:{
                    idBlok:id,
                   // namaBlok:$("#Rku_blok").val(),
                   // idSektor:$("#Rku_sektor option:selected").val(),
                   // idKabupaten:$("#Rku_kabupaten option:selected").val()
                },
                dataType: "json",
                url: url,
                success: function(result) {
                    document.getElementById('Rku_sektor').value=result.id_sektor;
                    
                    $("#Rku_blok").val(result.nama_blok);
                    $("#Rku_idblok").val(result.id_blok);
                    $( "#blok_area" ).show();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
        });
         
    }
    
    
    
     function deleteSektor(url)
    {
        swal({
          title: "Konfirmasi?",
          text: "Hapus Sektor?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
              var form = new FormData($("#<?=Yii::app()->controller->id . '-form'?>")[0]);
              $.ajax({
                type: "GET",
                // data: 'id='+id,
                dataType: "json",
                contentType: false,
                processData: false,
                url: url,
                success: function(result) {
                    swal(result.header, result.message, result.status).then((ok) => {
                        $.fn.yiiGridView.update("grid2");
                        $.fn.yiiGridView.update("grid1");
                         
                        $('#Rku_sektor').children('option:not(:first)').remove();
                        
                        //recreate list sektor
                        jQuery.each(result.listSektor, function(index, item) {
                       //foreach(result.listSektor,index,val){
                            $('#Rku_sektor').append('<option value="'+result.listSektor[index]+'" >'+item+'</option>');
                        });
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
          } else {
            // swal("Your imaginary file is safe!");
          }
        });
    }
    
    
    
    function getSektor(id, nama)
    {
               $("#Rku_namaSektor").val(nama);
               $("#Rku_idsektor").val(id);
               $("#sektor_area" ).show();
       
    }
    
  </script>  
  <script  type="text/javascript"> 
      $("#btnAddNewBlok").click(function(){
          $( "#blok_area" ).show();
          $( "#sektor_area" ).hide();
      });
      
      $("#btnAddNewSektor").click(function(){
            $("#Rku_namaSektor").val('');
            $("#Rku_idsektor").val('');
            $( "#blok_area" ).hide();
            $( "#sektor_area" ).show();
            
      });
	  
	  $("#btnBatalSektor").click(function(){
        $( "#blok_area" ).hide();
		$( "#sektor_area" ).hide();
      });
	  
	  $("#btnBatalBlok").click(function(){
        $( "#blok_area" ).hide();
		$( "#sektor_area" ).hide();
      });
      
      $("#btnAddBlok").click(function(){

        
            $.ajax({
			type: "POST",
                data:{
                    idBlok:$("#Rku_idblok").val(),
                    namaBlok:$("#Rku_blok").val(),
                    idSektor:$("#Rku_sektor option:selected").val()
                },
                dataType: "json",
                url: "<?php echo $urlAdd; ?>",
                success: function(result) {
                swal(result.header, result.message, result.status).then((ok) => {
                        $.fn.yiiGridView.update("grid1");
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        });

		
	$("#btnSaveSektor").click(function(){
            $.ajax({
			type: "POST",
                data:{
                    namaSektor:$("#Rku_namaSektor").val(),
                    idSektor:$("#Rku_idsektor").val()
                },
                dataType: "json",
                url: "<?php echo $urlAddNewSektor; ?>",
                success: function(result) {
                swal(result.header, result.message, result.status).then((ok) => {
                        $.fn.yiiGridView.update("grid2");
				$('#Rku_sektor').append('<option value="'+result.id+'" >'+$("#Rku_namaSektor").val()+'</option>');
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        });


</script>

</div>


