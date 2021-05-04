<?php
$this->breadcrumbs = array(
    'Absensi Laporan Realisasi Bulanan'
);


// print_r("<pre>");
//        print_r($listbulan);
//        print_r("</pre>");        exit(1);
?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_realisasi.php'; ?>
        </div>
    </div>
    <!-- if(is_null($model->nama_perusahaan)) {
        $v = $model->idPerusahaan->nama_perusahaan;
    } else {
        $v = $model->nama_perusahaan;
    } -->
</div>

<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Absensi Laporan Realisasi Bulanan IUPHHK-HTI</h4>
    
    
    
    <table class="table-striped" style="width: 50%">
        <tr>
            <td>Nomor SK RKT</td>
            <td>:</td>
            <td><?=$rkt['nomor_sk']?></td>
        </tr>
        <tr>
            <td>Tanggal SK RKT</td>
            <td>:</td>
            <td><?=$rkt['tanggal_sk']?></td>
        </tr>
        <tr>
            <td>Tahun SK RKT</td>
            <td>:</td>
            <td><?=$rkt['tahun_mulai']?></td>
        </tr>
    </table>    
    
    <br>
    
        <a href="<?php echo $this->createUrl('/perusahaan/rktBulan/create');?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah RKT Bulan</button></a>
     <a href="<?php echo $this->createUrl('/perusahaan/rktBulan/syncrktbulan');?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-history"></i> Syncronize RKT Bulan</button></a>
  <br>
  <br>
  
    <table class="table-striped table-bordered table-hover" style="width: 80%">
        <thead>
            
            <tr style="background-color:gainsboro;">
                <td><b>No</b></td>
                <td><b>Bulan Laporan</b></td>
                <td><b>Status Laporan</b></td>
               <td><b>Aksi</b></td>
            </tr>
            
        </thead>
        <tbody>
            <?php  $idx=1;
                   $cbulan = date('m'); 
                   $ctahun = date('Y');
                   
                   //echo($ctahun);
                   //echo($cbulan);
                   
                    foreach($listbulan as $rbulan){ 
                       // echo ("test".$rbulan['bulanlaporan']."  bulan :".$cbulan."  ||  "); 
                        if($rkt['tahun_mulai'] == $ctahun){  //rkt berjalan
                            if($rbulan['bulanlaporan'] < ($cbulan) ){
                            if($rbulan['bulanlaporan'] > 0){
                            
                                
//                          
                ?>
                        <tr>
                            <td><?php echo($idx);?></td>
                            <td><?php echo($rbulan['bulan']);?></td>
                            <td><?php if($rbulan['statuslaporan'] == 0){ 
                                        echo("Laporan Menunggu Persetujuan Atasan IUPHHK-HT");
                                      }else{
                                          echo("Laporan Telah Terkirim");
                                      }  
                                  ?>
                            </td>                
                            <td>
                                <?php if($rbulan['statuslaporan'] == 0){
                                          //  echo CHtml::link("<i class='fa fa-edit'></i> " . Yii::t('app', 'Buat Laporan'), array('approve','bulan'=>$rbulan['id'],'rktId'=>$rkt['id']), array('class' => 'btn btn-primary btn-sm'));
                                        }
                                        else {
                                            echo CHtml::link("<i class='fa fa-lock'></i> " . Yii::t('app', ''));
                                        }
                                ?>
                            </td>
                        </tr>
               
                            <?php 
                            
                        
                        
                        
                        
                            }
                        }
                        }
                            else{   //rkt sebelumnya 
                                 //   echo "rkt sblmnya";
                                    if($rbulan['bulanlaporan'] > 0){
                            
                                
//                          
                                ?>
                                       <tr>
                                                <td><?php echo($idx);?></td>
                                                <td><?php echo($rbulan['bulan']);?></td>
                                                <td><?php if($rbulan['statuslaporan'] == 0){ 
                                                                echo("Laporan Menunggu Persetujuan Atasan IUPHHK-HT");
                                                            }else{
                                                                echo("Laporan Telah Terkirim");
                                                            }  
                                                      ?>
                                                </td>                
                                                <td>
                                                    <?php if($rbulan['statuslaporan'] == 0){
                                                                //echo CHtml::link("<i class='fa fa-edit'></i> " . Yii::t('app', 'Perbaiki Laporan'), array('approve','bulan'=>$rbulan['id'],'rktId'=>$rkt['id']), array('class' => 'btn btn-primary btn-sm'));
                                                            }
                                                            else if($rbulan['statuslaporan'] == 1) {
                                                                echo CHtml::link("<i class='fa fa-lock'></i> " . Yii::t('app', ''));
                                                            }
                                                            else {
                                                                //   echo CHtml::link("<i class='fa fa-check-square-o'></i> " . Yii::t('app', 'Input Laporan'), array('approve','bulan'=>$rbulan['id'],'rktId'=>$rkt['id']), array('class' => 'btn btn-primary btn-sm'));
                                                         
                                                            }
                                                    ?>
                                                </td>
                                            </tr>     
               
                            <?php 
                            
                                        } else {
                                             ?>
                                        <tr style="background-color:orange;">
                                             <td><?php echo($idx);?></td>
                                            <td><?php echo($rbulan['bulan']);?></td>
                                            <?php $warn = "Laporan Belum diinput ";
                                                  ?>
                                            <td><?php echo($warn); ?> </td>                
                                            <td></td>
                                        </tr>


                                <?php  

                            }
                            
                            
                    }
                     $idx++;
                        
                   
                }?>
        </tbody>
    </table>
    
    <br>
   
  


   
</div>
