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
                    <strong><?php echo Yii::t('app', 'NERACA TANAMAN'); ?></strong>
                    
                </h3>
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
                                    <td rowspan="2" style="text-align: center">Luas Efektif  (Ha)</td>
                                    <td colspan="3" style="text-align: center">Saldo Awal Tanaman</td>
                                    <td rowspan="2" style="text-align: center">Realisasi Tanaman Tahun Berjalan</td>
                                    <td colspan="2" style="text-align: center">Realisasi Produksi</td>
                                    <td colspan="3" style="text-align: center">Saldo Akhir Tanaman</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">Tahun Penanaman</td>
                                    <td style="text-align: center">Umur Tanaman</td>
                                    <td style="text-align: center">Luas (Ha)</td>
                                    <td style="text-align: center">Tahun Penanaman</td>
                                    <td style="text-align: center">Luas (Ha)</td>
                                    <td style="text-align: center">Tahun Penanaman</td>
                                    <td style="text-align: center">Umur Tanaman</td>
                                    <td style="text-align: center">Luas (Ha)</td>
                                </tr>
                            </thead>
                            
                            <tbody>
                                
                        <?php   $saldoTotalLuas=0;  $i=0;                               
                                foreach($arealProduktif as $areal){?>        
                                <tr>
                                    <?php if($i == 0){ ?>
                                        <td style="text-align: center" rowspan="<?=  sizeof($arealProduktif);?>"><?=  number_format($areal['efektif']); ?></td>
                                    <?php } ?>
                                    <td style="text-align: center"><?=  $areal['tahun']; ?></td>
                                    <td style="text-align: center"><?=  number_format($areal['umur']); ?></td>
                                    <td style="text-align: center"><?=  number_format($areal['stokluas']); ?></td>
                                    
                                    <td style="text-align: center"><?=  number_format($areal['jmlRealisasi']); ?></td>
                                    
                                    <td style="text-align: center"><?=  $areal['tahun']; ?></td>
                                    <td style="text-align: center"><?=  number_format($areal['luasProduksi']); ?></td>
                                    
                                    
                                    <td style="text-align: center"><?=  $areal['tahun']; ?></td>
                                      <td style="text-align: center"><?=  number_format($areal['umur']); ?></td>
                                    <td style="text-align: center"><?=  number_format(($areal['stokluas'] + $areal['jmlRealisasi']) - $areal['luasProduksi']); ?></td>
                                    
                                </tr>
                        <?php 
                                $saldoTotalLuas = $saldoTotalLuas + (($areal['stokluas'] + $areal['jmlRealisasi']) - $areal['luasProduksi']);
                                $i++;
                                } ?>        
                                <tr>
                                    <td style="text-align: right" colspan="9"> T O T A L</td>
                                    <td style="text-align: center"><?= number_format($saldoTotalLuas); ?></td>
                                </tr>
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
                    <td style="font-style:italic;font-size: 10px;">Data IUPHHK-HTI <?php echo $iuphhk->idPerusahaan->nama_perusahaan; ?><br><span>Tanggal Cetak : <?= date("d-m-Y H:m:s"); ?></span></td>
                    <td style="font-style:italic;text-align:right;font-size: 10px;">http://sehati.menlhk.go.id</div></td>
                </tr>
            </table>
        </htmlpagefooter>
    </body>
</html>