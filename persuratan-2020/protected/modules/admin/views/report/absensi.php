<?php $baseUrl = Yii::app()->request->baseUrl;
Yii::app()->booster->cs->registerPackage('bootstrap.css');
Yii::app()->clientScript->registerCssFile($baseUrl.'/statics/css/print.css');

//print_r("<pre>");
//print_r($arealProduktif);
//print_r("</pre>");

?>

<!doctype html>
<html>
     <body>
        <div id="body">
            <div id="body-center">
                <h3>
                    <strong><?php echo Yii::t('app', 'ABSENSI LAPORAN REALISASI BULANAN RKT'); ?></strong>
                    
                </h3>
                 <h4>
                    <?php echo("SK RKT Nomor : ".$rkt['nomor_sk']." (Tahun : ".$rkt['tahun_mulai']." )"); ?>
                    
                </h4>
            </div>
            <div id="iup">
                <table class="nipz" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                      <!--  <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 1.&nbsp;&nbsp;Data Pokok </b></h4></td>
                        </tr> -->
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">1.&nbsp;&nbsp;Nama Perusahaan</td>
                            <td width="1%">:</td>
                            <td width="87%" colspan="2"><?= $perusahaan->nama_perusahaan ?></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbspNomor SK</td>
                            <td width="1%">:</td>
                            <td width="87%" colspan="2"><?= $iuphhk['nomor']; ?></td>
                        </tr>
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kantor Pusat</td>
                            <td width="1%">:</td>
                            <td width="87%" colspan="2"><?= $perusahaan->alamat?></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kantor Cabang</td>
                            <td width="1%">:</td>
                            <td width="87%" colspan="2"><?= $cabang->alamat==""?"-":$cabang->alamat; ?></td>
                        </tr>
                    </tbody>
                </table>    
            </div>     
            <div>
                <div style="margin-left: 25px">
                    <table class="table-hover table-bordered table-striped" style="border: 1px; width: 95%;" >
                            <thead>
                                <tr>
                                    <td  style="text-align: center">No.</td>
                                    <td  style="text-align: center">Bulan Laporan</td>
                                    <td  style="text-align: center">Status</td>
                                    <td  style="text-align: center">Keterangan</td>
                                </tr>
                            </thead>
                            
                            <tbody>
                                
                        <?php   $i=1;                               
                                foreach($listbulan as $item){?>        
                                <tr>
                                    <td style="text-align: center"><?php echo($i); ?></td>
                                    <td style="text-align: center">
                                        <?php 
                                                echo $item['bulan'];
                                        ?>
                                    
                                    
                                    
                                    
                                    
                                    </td>
                                    
                                    <td style="text-align: center"><?php if($item['statuslaporan'] == 1){ 
                                                                                echo("V");
                                                                          }else{
                                                                                echo("-");
                                                                          }  
                                                                      ?></td>
                                   
                                     <td><?php if($item['statuslaporan'] == 1){ 
                                                echo("Laporan Telah Dibuat dan Disampaikan");
                                              }else{
                                                  echo("-");
                                              }  
                                          ?>
                                    </td>   
                            
                                </tr>
                                <?php }?>
                            </tbody>    
                        </table>    
                        
                                
                    </tbody>
                </table>
                <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                </div>
            </div>   
        </div>
         
         
         
         
         
         
         
         
         
         
         
         
         
        <htmlpagefooter name="myFooter1">
            <hr>
            <table width="100%" cellpadding="0" cellspacing="0" style="vertical-align:middle">
                <tr>
                    <td style="font-style:italic;font-size: 10px;">Data IUPHHK-HTI <br><span>Tanggal Cetak : <?= date("d-m-Y H:m:s"); ?></span></td>
                    <td style="font-style:italic;text-align:right;font-size: 10px;">http://sehati.menlhk.go.id</div></td>
                </tr>
            </table>
        </htmlpagefooter>
    </body>
</html>