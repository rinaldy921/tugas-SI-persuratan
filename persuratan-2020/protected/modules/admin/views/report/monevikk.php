<?php


$listRKT = CHtml::listData(
    Rkt::model()->findAll(
            array(
                'order' => 'tahun_mulai DESC',
                'distinct' => true,
            )
    ), 'tahun_mulai', 'tahun_mulai'
);



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

if($role == 1 || $role == 5 || $role == 6){   // Admin  AND UHP
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

$url = Yii::app()->createUrl('admin/report/viewmonevikk/tahun/');


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
                <div class="panel-title">Monitoring IUPHHK-HT Aktif</div>
            </div>
        </div>
     
     <div class="panel-body">
            <?php echo $form->select2Group($model, 'tahun', array('groupOptions' => array('id' => 'nama_user'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listRKT, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Perusahaan')))); ?>
 
                
               
         
          <div class="form-group">
              <div class="col-sm-3"></div>
              <div class="col-sm-9">
                  <?php
                  $this->widget('booster.widgets.TbButton', array(
                      'buttonType' => 'button',
                      'context' => 'primary',
                      'label' => 'Tampilkan',
                      'htmlOptions'=> array('onclick' => 'tampilDataPokok()'),
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
     function tampilDataPokok(){
        idIuphhk = $("#RktBulan_tahun option:selected").val();
         
        url = "<?php echo $url; ?>"+idIuphhk;
        title = "Data Pokok IUPHHK";

      window.open('http://localhost:8080/'+url);
//      window.open('http://localhost/'+url);
//        window.open('http://sehati.menlhk.go.id/'+url);
//      window.open('http://sehati.menlhk.go.id/devel/'+url);


    }

</script>
