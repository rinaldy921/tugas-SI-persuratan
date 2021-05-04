<?php
$this->breadcrumbs = array(
    'Absensi Laporan Realisasi Bulanan'
);


// print_r("<pre>");
//        print_r($mode);
//        print_r("</pre>");        exit(1);
?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_monev_realisasi.php'; ?>
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
                    foreach($listbulan as $rbulan){ 
                        if($rbulan['bulanlaporan'] > 0){
//                          
                ?>
                        <tr>
                            <td><?php echo($idx);?></td>
                            <td><?php echo($rbulan['bulan']);?></td>
                            <td><?php if($rbulan['statuslaporan'] == 0){ 
                                        echo("Laporan Telah Diinput Operator");
                                      }else{
                                          echo("Laporan Telah Di Setujui Atasan");
                                      }  
                                  ?>
                            </td>                
                            <td>
                                <?php if($rbulan['statuslaporan'] == 0){
                                            echo CHtml::link("<i class='fa fa-check-square-o'></i> " . Yii::t('app', 'Setujui'), array('approve','bulan'=>$rbulan['id'],'rktId'=>$rkt['id']), array('class' => 'btn btn-primary btn-sm'));
                                        }
                                        else{
                                            echo CHtml::link("<i class='fa fa-lock'></i> " . Yii::t('app', ''));
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
                            <td><?php echo("Laporan Belum Diinput"); ?> </td>                
                            <td></td>
                        </tr>
                <?php  
                        
                            } 
                
                     $idx++;
                   
                }?>
        </tbody>
    </table>
    
    <br>
   
  


   
</div>
