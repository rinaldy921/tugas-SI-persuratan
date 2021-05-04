<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'htmlOptions' => array(
           'enctype' => 'multipart/form-data',
        ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));

$role = Yii::app()->user->findUser()->id_role;
$userBphp = Yii::app()->user->findUser()->id_bphp;
$userProv = Yii::app()->user->findUser()->id_propinsi;
$list;

if($role == 1 || $role == 5 || $role == 6 || $role == 4 || $role == 3){   // Admin  AND UHP
    //$condition = array('provinsi'=>$userProv);
       $list = Provinsi::model()->getProvinsi();

       
}

$url = Yii::app()->createUrl('admin/report/tampilabsenperprop/id/');
$urlGetTahun = Yii::app()->createUrl("admin/report/getidtahunrkt"); 

?>

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
            <?php  require_once dirname(__FILE__) . '/../layouts/menu_report.php'; ?>        </div>                   
    </div>
</div>

<div id="page-wrapper" class="col-md-9">       

 <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Rekap Absensi Laporan Bulanan Per Propinsi</div>
            </div>
        </div>
     
     <div class="panel-body">
            <?php   $model = new Provinsi();
                    echo $form->select2Group($model, 'nama', array('groupOptions' => array('id' => 'nama'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Provinsi')))); ?>
            
         
          <div class="form-group">
              <div class="col-sm-3"></div>
              <div class="col-sm-9">
                  <?php
                  $this->widget('booster.widgets.TbButton', array(
                      'buttonType' => 'button',
                      'context' => 'primary',
                      'label' => 'Tampilkan',
                      'htmlOptions'=> array('onclick' => 'tampilAbsen()'),
                  ));
                  echo ' ';

                  ?>
              </div>
          </div>

          <?php $this->endWidget(); ?>
          </div>
     </div>
 </div>
<script type="text/javascript">
     function tampilAbsen(){
         idIuphhk = $("#Rku_id_perusahaan option:selected").val();
         idRkt = $("#Rku__tahun option:selected").val();

         url = "<?php echo $url; ?>"+idIuphhk;
         title = "Absensi Laporan Bulanan Per Provinsi;

      window.open('http://localhost:8080/'+url);
//      window.open('http://localhost/'+url);
//        window.open('http://sehati.menlhk.go.id/'+url);
//      window.open('http://sehati.menlhk.go.id/devel/'+url);


    }
    
    
    $("#Rku_id_perusahaan").change(function(){
            $.ajax({
			type: "POST",
                data:{
                    idPerusahaan:$("#Rku_id_perusahaan option:selected").val()
                },
                dataType: "json",
                url: "<?php echo $urlGetTahun; ?>",
                success: function(result) {
                    if(result.status == "success"){
                        $('#Rku__tahun').select2('val','',true);
                        $("#Rku__tahun").empty();  //clear all option
                        //recreate list sektor
                        jQuery.each(result.listTahun, function(index, item) {
                       //foreach(result.listSektor,index,val){
                            $('#Rku__tahun').append('<option value="'+index+'" >'+item+'</option>');
                        });
                    }
                    else{
                        var tmpMsg = "RKU untuk "+$("#Rku_id_perusahaan option:selected").html()+" Tidak Ditemukan....!";
                        alert(tmpMsg);
                        $('#s2id_Rkt__tahun').select2('val','',true);
                        $("#Rku__tahun").empty();  //clear all option
                        $('#Rku__tahun').append('<option value="0" selected>Data Tahun Tidak Ditemukan...!</option>');                        
                    } 
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        });
        

</script>
