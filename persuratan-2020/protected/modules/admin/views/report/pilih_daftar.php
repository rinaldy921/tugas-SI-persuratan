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
$listBphp;
$listPropinsi;
$condition;




if($role == 1 || $role == 5 || $role == 6){   // Admin  
    $listBphp = CHtml::listData(MasterBphp::model()->findAllByAttributes($condition), 'id', 'nama_bphp');
    $listPropinsi = CHtml::listData(Provinsi::model()->findAllByAttributes($condition), 'id_provinsi', 'nama');
}

else if($role == 3){  //BPHP
    $condition = array('id'=>$userBphp);
    $listBphp = CHtml::listData(MasterBphp::model()->findAllByAttributes($condition), 'id', 'nama_bphp');
    
    
    
    $listPropinsi = Provinsi::model()->getByBphp($userBphp);
 }
 
else if($role == 4){   // DISHUT  
    $wilayahBphp = BphpWilayahKerja::model()->findByAttributes(array('id_provinsi'=>$userProv));
    

    
    if(isset($wilayahBphp)){
       // $wilayahBphp = $wilayahBphp['0'];
        
        $condition = array('id'=>$wilayahBphp->id_master_bphp);
        $listBphp = CHtml::listData(MasterBphp::model()->findAllByAttributes($condition),'id','nama_bphp');
       // print_r("<pre>");print_r($userProv);print_r("<pre>");die();
        
        $condition2 = array('id_provinsi'=>$userProv);
        $listPropinsi = CHtml::listData(Provinsi::model()->findAllByAttributes($condition2), 'id_provinsi', 'nama');
    }
    
    
    //$list = CHtml::listData(Perusahaan::model()->findAllByAttributes($condition), 'id_perusahaan', 'nama_perusahaan');
}
$url = Yii::app()->createUrl('admin/report/daftar/idpropinsi/');


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
                <div class="panel-title">Daftar Pemegang IUPHHK-HT</div>
            </div>
        </div>
     
     <div class="panel-body">
            <?php // echo $form->select2Group($model, 'id_master_bphp', array('groupOptions' => array('id' => 'nama_user'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listBphp, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Perusahaan')))); ?>
            <?php echo $form->select2Group($model, 'id_provinsi', array('groupOptions' => array('id' => 'nama_user'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $listPropinsi, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Provinsi')))); ?>

        <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'button',
                    'context' => 'primary',
                    'label' => 'Tampilkan',
                    'htmlOptions'=> array('onclick' => 'tampilDaftar()'),
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
     function tampilDaftar(){
        if($('#BphpWilayahKerja_id_provinsi').val() != ""){
            idBphp= $("#BphpWilayahKerja_id_master_bphp option:selected").val();
            idPropinsi= $("#BphpWilayahKerja_id_provinsi option:selected").val();

            url = "<?php echo $url; ?>"+idPropinsi;
            title = "Daftar Pemegang IUPHHK - HT";

//      window.open('http://localhost:8080/'+url);
//      window.open('http://localhost/'+url);
        window.open('http://sehati.menlhk.go.id/'+url);
//      window.open('http://sehati.menlhk.go.id/devel/'+url);


        }
        else{
            window.alert("Silahkan Pilih Provinsi Terlebih Dahulu .... !");
        }
        
    }

</script>
