<table border="1" width="100%">  
    <tr>
        <th style="text-align:center">No</th>
        <th style="text-align:center">Jenis Ganis PHPL</th>
        <th style="text-align:center">Kebutuhan Ganis PHPL <br> Sesuai Perdirjen PHPL 16 Tahun 2015</th>
        <th style="text-align:center">Realisasi</b></th>
    </tr>
    <?php  $i=1;
            $jmlStnadar = 0; $jmlRealisasi=0;
            foreach($syaratGanis as $ganis){
                //print_r("<pre>");print_r($ganis['standar']);print_r("</pre>");//die();
    ?>  

    <tr>
       <td style="text-align:center"><?=$i; ?></td>
       <td style="text-align:left"><?=$ganis['nama_jenis']?></td>
       <td style="text-align:center"><?=$ganis['standar']?> Orang</td>
       <td style="text-align:center"><?=$ganis['realisasi']?> Orang</td>
    </tr>
    <?php 
        $jmlStnadar = $jmlStnadar + $ganis['standar'];
        $jmlRealisasi = $jmlRealisasi + $ganis['realisasi'];
        $i++;
    }?>
    <tr>
      <td style="text-align:center">&nbsp;</td>
      <td style="text-align:center"><b>J u m l a h</b></td>
      <td style="text-align:center"><b><?=$jmlStnadar;?> Orang</b></td>
      <td style="text-align:center"><b><?=$jmlRealisasi; ?> Orang</b></td>
   </tr>
</table> 
