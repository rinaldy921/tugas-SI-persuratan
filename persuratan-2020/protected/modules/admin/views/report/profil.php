<?php $baseUrl = Yii::app()->request->baseUrl;
Yii::app()->booster->cs->registerPackage('bootstrap.css');
Yii::app()->clientScript->registerCssFile($baseUrl.'/statics/css/print.css');

?>





<!doctype html>
<html>
     <body>
        <div id="body">
            <div id="body-center">
                <h3>
                    <strong><?php echo Yii::t('app', 'DATA PEMEGANG IUPHHK'); ?></strong>
                </h3>
                <h5>
                    <?php echo "Nomor SK " ?>: 
                    <?php echo $iuphhk['nomor']; ?>
                </h5>
            </div>
            <div id="iup">
                <table class="nipz" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 1.&nbsp;&nbsp;Data Pokok </b></h4></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">a.&nbsp;&nbsp;Nama Perusahaan</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $perusahaan->nama_perusahaan ?></td>
                        </tr>
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">b.&nbsp;&nbsp;Status Perusahaan</td>
                            <td width="1%">:</td>
                            <td width="60%">
                            </td>
                            <td width="70%" colspan="2">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">c.&nbsp;&nbsp;Alamat</td>
                            <td width="1%"></td>
                            <td width="70%" colspan="2"></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kantor Pusat</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $perusahaan->alamat?></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kantor Cabang</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $cabang->alamat==""?"-":$cabang->alamat; ?></td>
                        </tr>
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="5">d.&nbsp;&nbsp;Keputusan IUIPHHK-HTI </td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Nomor</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $iuphhk['nomor'] ?></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tanggal</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $iuphhk['tanggal'] ?></td>
                        </tr>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Luas Izin</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= number_format($iuphhk['luas'])." Ha" ?></td>
                        </tr>
                         <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Masa Berlaku</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $iuphhk['tgl_end']?></td>
                        </tr>
                        
                        
                        <?php $idxAdendum=1;
                                foreach($adendum as $iAdendum){ ?>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="5">&nbsp;&nbsp;&nbsp;<b>Addendum <?php echo($idxAdendum);?></b> </td>
                        </tr>
                         <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Nomor</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $iAdendum['nomor'] ?></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tanggal</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $iAdendum['tanggal'] ?></td>
                        </tr>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Luas Izin</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= number_format($iAdendum['luas'])." Ha" ?></td>
                        </tr>
                         <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Masa Berlaku</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $iAdendum['tgl_end']?></td>
                        </tr>
                        
                        
                        <?php 
                                $idxAdendum++;
                                } ?>
                       
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">f.&nbsp;&nbsp;Kelas Perusahaan</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?=$rku['kelas'];?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">g.&nbsp;&nbsp;Status Permodalan</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $permodalan->jenis ?></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">h.&nbsp;&nbsp;Jumlah Investasi Awal (Rp)</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= "Rp. ".number_format($investasi->jml_rupiah) ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">h.&nbsp;&nbsp;Jumlah Investasi Awal (USD)</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= number_format($investasi->jml_dollar)." USD" ?></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="5">i.&nbsp;&nbsp;Susunan Pengurus Perusahaan </td>
                        </tr>
                        
                        <?php foreach($komisaris as $objKomisaris){?>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;<?=$objKomisaris['jabatan'];?></td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?=$objKomisaris['nama_komisaris'];?></td>
                        </tr>
                        <?php } ?>
                        
                       <?php foreach($direksi as $objDireksi){?>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;<?=$objDireksi['jabatan'];?></td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?=$objDireksi['nama_direksi'];?></td>
                        </tr>
                        <?php } ?>
                        
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="5">j.&nbsp;&nbsp;Kepemilikan Industri </td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Terkait Dengan Industri</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Jenis Produk</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Lokasi</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"></td>
                        </tr>
                        
                        
                         <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 2.&nbsp;&nbsp;Lokasi Areal Kerja </b></h4></td>
                        </tr>
                         <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="5">a.&nbsp;&nbsp;Administrasi Pemerintahan </td>
                        </tr>
                       
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Provinsi</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $admPemerintahan->provinsi0->nama ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kabupaten</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $admPemerintahan->kabupaten0->nama ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kecamatan</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $admPemerintahan->kecamatan0->nama ?></td>
                        </tr>
                        
                         <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="5">b.&nbsp;&nbsp;Administrasi Kehutanan </td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Provinsi/KPH/CDK</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $pemangkuanHutan->dinhutProv->nama.' / '.$pemangkuanHutan->idKph->nama_kph ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bagian Hutan/Dinas Kabupaten</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?= $pemangkuanHutan->dinhutKab->nama ?></td>
                        </tr>
                        
                          <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        
                          <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 3.&nbsp;&nbsp;Tata Batas Areal Kerja </b></h4></td>
                        </tr>
                        
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">a.&nbsp;&nbsp; SK. Tata Batas (No./Tanggal)</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?php echo (($tataBatas['nomor']=='')?'-': $tataBatas['nomor']); ?></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">b.&nbsp;&nbsp; Panjang Batas (temu gelang)</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?php echo (($tataBatas['tanggal']=='')?'-': $tataBatas['tanggal']); ?></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%">c.&nbsp;&nbsp; Progres Tata Batas</td>
                            <td width="1%">:</td>
                            <td width="70%" colspan="2"><?php echo (($tataBatas['progress']=='')?'-': ''.$tataBatas['progress'].' ('.$tataBatas['keterangan'].')'); ?></td>
                        </tr>
                        
                        
                        
                        
                        
                        <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 4.&nbsp;&nbsp;Perkembangan Kepemilikan Saham </h4></td>
                        </tr>
                        
                        <?php 
                            $index=1;
                            foreach($legalitas as $ilegalitas){
                                //print_r($ilegalitas);die();
                                ?>
                        
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="27%" colspan="4"><?=$index; ?>.&nbsp;&nbsp;<?=$ilegalitas['jenis_legalitas'];?></td>
                          
                        </tr>
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a. Akta Notaris</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?=$ilegalitas['notaris'];?></td>
                            </tr>
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b. Nomor / Tanggal</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?=$ilegalitas['nomor'].' / '.$ilegalitas['tanggal'];?></td>
                            </tr>
                             <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; c. Komposisi Saham</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"></td>
                            </tr>
                            <?php   $saham = Saham::model()->findAll(array('condition' => 'id_perusahaan = ' .$perusahaan->id_perusahaan . ' AND id_legalitas = ' . $ilegalitas['id_legalitas']));
                                    if(sizeof($saham)>0){
                                    //print_r($saham->nama_pemodal);//die();
                                    foreach($saham as $isaham){
                                       // print_r($item->nama_pemodal);
                            ?>
                                    <tr>
                                       <td width="4%">&nbsp;</td>
                                       <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;<?=$isaham->nama_pemodal;?></td>
                                       <td width="1%">:</td>
                                       <td width="70%" colspan="2"><?=$isaham->jumlah;?> % </td>
                                   </tr>
                                    <?php 
                                    }
                                    } ?>
                            
                            
                            
                        <?php $index++; 
                            } 
                            ?>
                            
                     
                        
                        
                            
                            
                        <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 5.&nbsp;&nbsp;RKUPHK-HTI Periode Berjalan </b></h4></td>
                        </tr>
                        
                             <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">a.&nbsp;&nbsp; No.SK RKUPHHKHTI</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?=$rku['nomor_sk'];?></td>
                            </tr>
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">b.&nbsp;&nbsp; Tanggal</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?=$rku['tgl_sk'];?></td>
                            </tr>
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">c.&nbsp;&nbsp; Periode</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?=$rku['tahun_mulai'].' - '.$rku['tahun_sampai'];?></td>
                            </tr>
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">d.&nbsp;&nbsp; Luas Areal Efektif</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?php echo ($lindung['efektif'])?></td>
                            </tr>
                             <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">e.&nbsp;&nbsp; Tata Ruang Sesuai RKU</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"></td>
                            </tr>
                            
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">&nbsp;&nbsp;&nbsp;- Kawasan Lindung (Ha/%)</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?php echo number_format($lindung['jumlah'],2)?> Ha / <?php echo number_format(($lindung['jumlah'] / ($lindung['efektif'] + $lindung['nonefektif'] + $lindung['jumlah'])*100),2);?> %</td>
                            </tr>
                            
                            <?php foreach($efektif as $iEfektif){ ?>
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">&nbsp;&nbsp;&nbsp;- <?php echo $iEfektif['jenis']?> (Ha/%)</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?php echo number_format($iEfektif['jumlah'],2);?> Ha / <?php echo number_format(($iEfektif['jumlah'] / ($iEfektif['efektif'] + $iEfektif['nonefektif'] + $iEfektif['lindung'])*100),2);?> %</td>
                            </tr>
                            <?php } ?>
                             
                            
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">f.&nbsp;&nbsp; Delmak/Delmik</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"></td>
                            </tr>
                             <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">g.&nbsp;&nbsp; Sistem Silvikultur</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"><?php echo($silvikultur['jenis']);?></td>
                            </tr>
                            
                            
                            
                            
                            
 <!-- 6                       
                        <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 6.&nbsp;&nbsp;Kebijakan Gambut </b></h4></td>
                        </tr>
                        
                        
                             <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">Kebijakan Gambut</td>
                                <td width="1%">:</td>
                                <td width="70%" colspan="2"></td>
                            </tr>       
                            
                            
          -->                       
    <!-- 7 -->                         
                            
                         <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 6.&nbsp;&nbsp;Data Perkembangan Tanaman dan Produksi beredasarkan RKT sejak perusahaan berdiri </b></h4></td>
                        </tr>
                        
                        
                             <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%">a.&nbsp;&nbsp; Jenis Tanaman yang dikembangkan</td>
                                <td width="1%"></td>
                                <td width="70%" colspan="2">&nbsp;</td>
                            </tr>    
                            
                            <?php foreach($tanamanSilvikultur as $tanaman){ ?>
                                <tr>
                                    <td width="4%">&nbsp;</td>
                                    <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;<?=$tanaman['jenis']?></td>
                                    <td width="1%">:</td>
                                    <td width="70%" colspan="2">&nbsp;<?=$tanaman['tanaman']?></td>
                                </tr>  
                            <?php } ?>
                            
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%" colspan="4">b.&nbsp;&nbsp; Pengesahan RKTUPHHK-HTI</td>
                            </tr>   
                            
                            <?php $indexRkt=1; 
                                foreach($rkt as $iRkt){?>
                                <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;<?=$indexRkt;?>.&nbsp;&nbsp; RKT <?php echo($iRkt['tahun_mulai']);?></td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"><?=$iRkt['nomor_sk'];?></td>
                               </tr> 
                               <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tgl SK. RKTPHHK - HT</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"><?=$iRkt['tanggal_sk'];?></td>
                               </tr>
                            <?php $indexRkt++; } ?>
                           
                               <!--
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%" colspan="3">c.&nbsp;&nbsp; Penanaman</td>
                            </tr>   
                            
                            
                            <tr>
                                <td width="4%">&nbsp;</td>
                                <td width="27%" colspan="3">c.&nbsp;&nbsp; Produksi</td>
                            </tr>
                       -->
                            
  <!-- 8 -->                           
                           <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 7.&nbsp;&nbsp;Hasil Penilikan PHPL / VLK </b></h4></td>
                        </tr>      
                                
                                <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">I.&nbsp;&nbsp; VLK</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"></td>
                                </tr>      
                                <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">&nbsp;&nbsp&nbsp;&nbsp a.&nbsp;&nbsp; Nomor</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"><?php echo($vlk['nomor']);?></td>
                                </tr>
                                         <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp b.&nbsp;&nbsp; Tahun Penilaian & masa berlaku</td>
                                            <td width="1%">:</td>
                                            <td width="70%" colspan="2"><?php echo($vlk['tahun']);?> , Berlaku : <?php echo($vlk['berlaku']);?> - <?php echo($vlk['berakhir']);?></td>
                                         </tr>  
                                            <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp c.&nbsp;&nbsp; Hasil Penilaian</td>
                                            <td width="1%">:</td>
                                            <td width="70%" colspan="2"><?php echo($vlk['predikat']);?></td>
                                         </tr> 
                                         <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp d.&nbsp;&nbsp; Lembaga Penilaian</td>
                                            <td width="1%">:</td>
                                            <td width="70%" colspan="2"><?php echo($vlk['penerbit']);?></td>
                                         </tr>   
                                         <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp e.&nbsp;&nbsp; Tahapan Surveylan</td>
                                            <td width="1%">:</td>
                                            <td width="70%"></td>
                                         </tr> 
                                        
                                          <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        
                        
                                <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">II.&nbsp;&nbsp; PHPL</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"></td>
                                </tr>  
                                        <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp a.&nbsp;&nbsp; Nomor</td>
                                            <td width="1%">:</td>
                                            <td width="70%" colspan="2"><?php echo($phpl['nomor']); ?></td>
                                         </tr>  
                                         <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp b.&nbsp;&nbsp; Tahun Penilaian & masa berlaku</td>
                                            <td width="1%">:</td>
                                            <td width="70%" colspan="2"><?php echo($phpl['tahun']); ?> , Berlaku : <?php echo($phpl['tanggal_mulai']); ?> - <?php echo($phpl['tanggal_berakhir']); ?></td>
                                         </tr>  
                                            <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp c.&nbsp;&nbsp; Hasil Penilaian</td>
                                            <td width="1%">:</td>
                                            <td width="70%" colspan="2"><?php echo($phpl['predikat']); ?></td>
                                         </tr> 
                                         <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp d.&nbsp;&nbsp; Lembaga Penilaian</td>
                                            <td width="1%">:</td>
                                            <td width="70%" colspan="2"><?php echo($phpl['penerbit']); ?></td>
                                         </tr> 
                                         
                                         <tr>
                                            <td width="4%">&nbsp;</td>
                                            <td width="27%">&nbsp;&nbsp&nbsp;&nbsp e.&nbsp;&nbsp; Tahapan Surveylan</td>
                                            <td width="1%">:</td>
                                            <td width="70%"></td>
                                         </tr> 
 
                                         
                                         
                                         
   <!-- 9 -->                                       
                                         
                        <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 8.&nbsp;&nbsp;Perkembangan Investasi dan Pelaporan Keuangan </b></h4></td>
                        </tr>      
                                
                                <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">a.&nbsp;&nbsp; Tahun Laporan Keuangan</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"><?=$lapKeuangan['tahun']?></td>
                                </tr>  
                                 <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">b.&nbsp;&nbsp; Total Aset</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"><?=number_format($lapKeuangan['total_aset']);?></td>
                                </tr> 
                                 <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">c.&nbsp;&nbsp; Nilai Perolehan</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"><?=number_format($lapKeuangan['nilai_perolehan'])?></td>
                                </tr> 
                                 <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">d.&nbsp;&nbsp; Nilai Buku</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"><?=number_format($lapKeuangan['nilai_buku'])?></td>
                                </tr> 
                                
  
                                
  <!-- 10 -->                               
                                
                        <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 9.&nbsp;&nbsp;Pengenaan Sanksi </b></h4></td>
                        </tr>      
                                
                                <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">a.&nbsp;&nbsp; Surat Peringatan (No/Tanggal)</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"></td>
                                </tr>  
                                 <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="27%">b.&nbsp;&nbsp; Jenis Pelanggaran</td>
                                   <td width="1%">:</td>
                                   <td width="70%" colspan="2"></td>
                                </tr>   
                                
                                
   
                                
<!-- 11  --> 
                               
                        <tr>
                            <td width="100%" colspan="6"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="6"><h4><b>&nbsp;&nbsp; 10.&nbsp;&nbsp;Ketersediaan Tenaga Kerja </b></h4></td>
                        </tr>      
                                
                                <tr>
                                   <td width="4%">&nbsp;</td>
                                   <td width="96%" colspan="4">-&nbsp;&nbsp; Tenaga Teknis Sertifikasi PHPL</td>
                                  
                                </tr>  
                                  <tr>
                                       <td width="4%">&nbsp;</td>
                                       <td width="27%"><b>Jenis Ganis PHPL</b></td>
                                       <td width="1%"></td>
                                       <td width="15%"><b>Kebutuhan Ganis PHPL Sesuai Perdirjen PHPL 16 Tahun 2015</b></td>
                                       <td width="55%"><b>Realisasi</b></td>
                                    </tr>
                                <?php  $i=1;
                                        $jmlStnadar = 0; $jmlRealisasi=0;
  
                                        foreach($daftarGanis as $ganis){
                                            //print_r("<pre>");print_r($ganis['standar']);print_r("</pre>");//die();
                                ?>  
                               
                                    <tr>
                                       <td width="4%">&nbsp;</td>
                                       <td width="27%"><?=$i; ?>.&nbsp;&nbsp; <?=$ganis['nama_jenis']?></td>
                                       <td width="1%">:</td>
                                       <td width="15%"><?=$ganis['standar']?> Orang</td>
                                       <td width="55%"><?=$ganis['realisasi']?> Orang</td>
                                    </tr>
                                <?php 
                                    $jmlStnadar = $jmlStnadar + $ganis['standar'];
                                    $jmlRealisasi = $jmlRealisasi + $ganis['realisasi'];
                                    $i++;
                                }?>
                                 <tr>
                                       <td width="4%">&nbsp;</td>
                                       <td width="27%"><b>J u m l a h</b></td>
                                       <td width="1%"></td>
                                       <td width="15%"><b><?=$jmlStnadar;?> Orang</b></td>
                                       <td width="55%"><b><?=$jmlRealisasi; ?> Orang</b></td>
                                    </tr>
                                
                                
                                
                                
   <!-- 12  --> 

                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                    </tbody>
                </table>
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