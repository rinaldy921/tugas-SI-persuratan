<?php
/* @var $this PesanController */
/* @var $model Pesan */

$this->breadcrumbs=array(
	'Inbox'=>array('index'),
	'Detil Pesan',
);

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
            <?php  require_once dirname(__FILE__) . '/../layouts/menu_inbox.php'; ?>        </div>                   
    </div>
</div>


<?php $path =Yii::app()->baseUrl.'/'; //print_r("<pre>");print_r($model);print_r("</pre>"); die();?>


<div id="page-wrapper" class="col-md-9"> 
    
 <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Detil Pesan</div>
            </div>
        </div>
     
     <div class="panel-body">
     
        <div class="form-group">
            <div class="col-sm-3">Pengirim</div>
            <div class="col-sm-9">:&nbsp;&nbsp;<?php echo($model['namapengirim']); ?></div>
        </div>
        <div class="form-group">
            <div class="col-sm-3">Subyek</div>
            <div class="col-sm-9">:&nbsp;&nbsp;<?php echo($model['subyek']); ?></div>
        </div>
          
         
           <?php $jenis='';
                if($model['tipe']==1){
                    $jenis = "Surat Himbauan";
                }
                elseif($model['tipe']==2){
                    $jenis = "Surat Peringatan";
                }
                else{
                    $jenis = "Surat Teguran";
                }
          ?>
         
         <div class="form-group">
            <div class="col-sm-3">Jenis</div>
            <div class="col-sm-9">:&nbsp;&nbsp;<?php echo($jenis); ?></div>
        </div>
          <div class="form-group">
            <div class="col-sm-3">Tanggal Kirim</div>
            <div class="col-sm-9">:&nbsp;&nbsp;<?php echo($model['tgl_kirim']); ?></div>
        </div>
         
         
        <div class="form-group">
            <div class="col-sm-3">&nbsp;&nbsp;</div>
            <div class="col-sm-9">&nbsp;&nbsp;</div>
        </div>
         
       
         <div class="form-group">
            <div class="col-sm-12"><?php echo($model['isi']); ?></div>
        </div>
         
         <div class="form-group">
            <div class="col-sm-3">&nbsp;&nbsp;</div>
            <div class="col-sm-9">&nbsp;&nbsp;</div>
        </div>
         
         
       
     </div>
</div>
</div>
