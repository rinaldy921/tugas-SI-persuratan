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

if($role == 1 || $role == 5 || $role == 6){   // Admin   AND UHP
    //$condition = array('provinsi'=>$userProv);
    $list = Perusahaan::model()->getByAdmin();
}
else if($role == 2){   // Perusahaan  
    //$condition = array('provinsi'=>$userProv);
    $list = Perusahaan::model()->getByIdPerusahaan(Yii::app()->user->idPerusahaan());
}
else if($role == 4){   // DISHUT  
    //$condition = array('provinsi'=>$userProv);
    $list = Perusahaan::model()->getByPropinsi($userProv);
    //$list = CHtml::listData(Perusahaan::model()->findAllByAttributes($condition), 'id_perusahaan', 'nama_perusahaan');
}
else if($role == 3){  //BPHP
    $list = Perusahaan::model()->getByBphp($userBphp);
 }
$url = Yii::app()->createUrl('admin/report/rkt/id/');
$urlPrasyarat = Yii::app()->createUrl('admin/report/rktprasyarat/id/');
$urlLingkungan = Yii::app()->createUrl('admin/report/rktlingkungan/id/');
$urlSosial= Yii::app()->createUrl('admin/report/rktsosial/id/');
$urlGetTahun = Yii::app()->createUrl('admin/report/gettahunrkt');

$urlGetBulan = Yii::app()->createUrl('admin/report/getbulanrkt');


//$listTahun = Rku::model()->getTahun();

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
                <div class="panel-title">RKT IUPHHK-HT</div>
            </div>
        </div>
     
     <div class="panel-body">
        <?php echo $form->select2Group($model, 'id_perusahaan', array('groupOptions' => array('id' => 'nama_user'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Perusahaan')))); ?>
        <?php  echo $form->select2Group($model, '_tahun', array('groupOptions' => array('id' => 'nama_user'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listTahun, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Tahun')))); ?>
        <?php  echo $form->select2Group($modelRealisasi, 'id_bulan', array('groupOptions' => array('id' => 'nama_user'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listBulan, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Bulan')))); ?>

      <div class="form-group">
          <div class="col-sm-12">
              <?php
             
             
                $this->widget('booster.widgets.TbButton', array(
                  'buttonType' => 'button',
                  'context' => 'primary',
                  'label' => 'Prasyarat',
                  'htmlOptions'=> array('onclick' => 'tampilRktPrasyarat()'),
              ));
                 echo ' ';
              $this->widget('booster.widgets.TbButton', array(
                  'buttonType' => 'button',
                  'context' => 'primary',
                  'label' => 'Fungsi Produksi',
                  'htmlOptions'=> array('onclick' => 'tampilRkt()'),
              ));
                 echo ' ';
              $this->widget('booster.widgets.TbButton', array(
                  'buttonType' => 'button',
                  'context' => 'primary',
                  'label' => 'Fungsi Lingkungan',
                  'htmlOptions'=> array('onclick' => 'tampilRktLingkungan()'),
              ));
              
              echo ' ';
              $this->widget('booster.widgets.TbButton', array(
                  'buttonType' => 'button',
                  'context' => 'primary',
                  'label' => 'Fungsi Sosial',
                  'htmlOptions'=> array('onclick' => 'tampilRktSosial()'),
              ));
              ?>
          </div>
      </div>

      <?php $this->endWidget(); ?>
      </div>
    </div>
</div>

<script type="text/javascript">
     function tampilRkt(){
        if($('#Rkt_id_perusahaan').val() != "" && $('#Rkt__tahun').val() != ""){
            idIuphhk = $("#Rkt_id_perusahaan option:selected").val();
            tahun = $("#Rkt__tahun option:selected").val();
            bulan = $("#RealisasiRktBibit_id_bulan option:selected").val();

            url = "<?php echo $url; ?>"+idIuphhk+"/tahun/"+tahun+"/bulan/"+bulan;
            title = "RKU IUPHHK";
            
//      window.open('http://localhost:8080/'+url);
//      window.open('http://localhost/'+url);
        window.open('http://sehati.menlhk.go.id/'+url);
//      window.open('http://sehati.menlhk.go.id/devel/'+url);
            return false;
        }
        else{
            window.alert("Silahkan Pilih Provinsi dan Tahun Terlebih Dahulu .... !");
        }
        
       
    }
    
    
     function tampilRktPrasyarat(){
        if($('#Rkt_id_perusahaan').val() != "" && $('#Rkt__tahun').val() != ""){
            idIuphhk = $("#Rkt_id_perusahaan option:selected").val();
            tahun = $("#Rkt__tahun option:selected").val();
            bulan = $("#RealisasiRktBibit_id_bulan option:selected").val();

            url = "<?php echo $urlPrasyarat; ?>"+idIuphhk+"/tahun/"+tahun+"/bulan/"+bulan;
            title = "RKU IUPHHK";
//      window.open('http://localhost:8080/'+url);
//      window.open('http://localhost/'+url);
        window.open('http://sehati.menlhk.go.id/'+url);
//      window.open('http://sehati.menlhk.go.id/devel/'+url);
            return false;
        }
        else{
            window.alert("Silahkan Pilih Provinsi dan Tahun Terlebih Dahulu .... !");
        }
        
       
    }
    
    
     function tampilRktLingkungan(){
        if($('#Rkt_id_perusahaan').val() != "" && $('#Rkt__tahun').val() != ""){
            idIuphhk = $("#Rkt_id_perusahaan option:selected").val();
            tahun = $("#Rkt__tahun option:selected").val();
            bulan = $("#RealisasiRktBibit_id_bulan option:selected").val();

            url = "<?php echo $urlLingkungan; ?>"+idIuphhk+"/tahun/"+tahun+"/bulan/"+bulan;
            title = "RKU IUPHHK";
//      window.open('http://localhost:8080/'+url);
//      window.open('http://localhost/'+url);
        window.open('http://sehati.menlhk.go.id/'+url);
//      window.open('http://sehati.menlhk.go.id/devel/'+url);
            return false;
        }
        else{
            window.alert("Silahkan Pilih Provinsi dan Tahun Terlebih Dahulu .... !");
        }
        
       
    }
    
    function tampilRktSosial(){
        if($('#Rkt_id_perusahaan').val() != "" && $('#Rkt__tahun').val() != ""){
            idIuphhk = $("#Rkt_id_perusahaan option:selected").val();
            tahun = $("#Rkt__tahun option:selected").val();
            bulan = $("#RealisasiRktBibit_id_bulan option:selected").val();

            url = "<?php echo $urlSosial; ?>"+idIuphhk+"/tahun/"+tahun+"/bulan/"+bulan;
            title = "RKU IUPHHK";
//      window.open('http://localhost:8080/'+url);
//      window.open('http://localhost/'+url);
        window.open('http://sehati.menlhk.go.id/'+url);
//      window.open('http://sehati.menlhk.go.id/devel/'+url);
            return false;
        }
        else{
            window.alert("Silahkan Pilih Provinsi dan Tahun Terlebih Dahulu .... !");
        }
        
       
    }
    
    
      $("#Rkt_id_perusahaan").change(function(){
            $.ajax({
			type: "POST",
                data:{
                    idPerusahaan:$("#Rkt_id_perusahaan option:selected").val()
                },
                dataType: "json",
                url: "<?php echo $urlGetTahun; ?>",
                success: function(result) {
                    if(result.status == "success"){
                        $('#Rkt__tahun').select2('val','',true);
                        $("#Rkt__tahun").empty();  //clear all option
                        //recreate list sektor
                        jQuery.each(result.listTahun, function(index, item) {
                       //foreach(result.listSektor,index,val){
                            $('#Rkt__tahun').append('<option value="'+index+'" >'+item+'</option>');
                        });
                    }
                    else{
                        var tmpMsg = "RKT untuk "+$("#Rkt_id_perusahaan option:selected").html()+" Tidak Ditemukan....!";
                        alert(tmpMsg);
                        $('#Rkt__tahun').select2('val','',true);
                        $("#Rkt__tahun").empty();  //clear all option
                        $('#Rkt__tahun').append('<option value="0" selected>Data Tahun Tidak Ditemukan...!</option>');                        
                    }    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        });
        
        $("#Rkt__tahun").change(function(){
            $.ajax({
			type: "POST",
                data:{
                    idPerusahaan:$("#Rkt_id_perusahaan option:selected").val(),
                    tahun:$("#Rkt__tahun option:selected").val()
                },
                dataType: "json",
                url: "<?php echo $urlGetBulan; ?>",
                success: function(result) {
                    if(result.status == "success"){
                        $('#RealisasiRktBibit_id_bulan').select2('val','',true);
                        $("#RealisasiRktBibit_id_bulan").empty();  //clear all option
                        //recreate list sektor
                        jQuery.each(result.listBulan, function(index, item) {
                       //foreach(result.listSektor,index,val){
                            $('#RealisasiRktBibit_id_bulan').append('<option value="'+index+'" >'+item+'</option>');
                        });
                    }
                    else{
                          $('#RealisasiRktBibit_id_bulan').select2('val','',true);
                        $("#RealisasiRktBibit_id_bulan").empty();  //clear all option
                        $('#RealisasiRktBibit_id_bulan').append('<option value="0" selected>Data Tahun Tidak Ditemukan...!</option>');                        
                    }    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
        });

</script>
