<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RumusPenilaianKinerja  {
    
    public static $bobotRKU = 15;
    
    public static $bobotProgresTataBatas = 15;
    
    public static $bobotRKT = 10;
    
    public static $bobotRealisasiPenanaman = 25;
    
    public static $bobotNakerBersertifikat = 15;
    
    public static $bobotPHPLorVLK = 20;
    
    public static $ganis_kriteria = '';
    
    public static $ganis_nilai = 0;
    
        
    public static function getRekapAdmin($provinsi='', $tahun) {
        $query = "                            
            SELECT  
                provinsi_perusahaan.nama_provinsi as provinsi,
                perusahaan.id_perusahaan,
                perusahaan.nama_perusahaan,
                (
                    SELECT tanggal FROM progres_tata_batas 
                    WHERE id_perusahaan = perusahaan.id_perusahaan  AND DATE_FORMAT(tanggal, '%Y') <= ".$tahun." 
                    ORDER BY tanggal DESC LIMIT 1
                ) AS tanggal_tb,                
                (
                    SELECT master_progres_tata_batas.nama_progres_tata_batas FROM progres_tata_batas
                    INNER JOIN master_progres_tata_batas ON progres_tata_batas.id_progres_tata_batas = master_progres_tata_batas.id_progres_tata_batas
		    WHERE id_perusahaan = perusahaan.id_perusahaan  AND DATE_FORMAT(tanggal, '%Y') <= ".$tahun." 
                    ORDER BY tanggal DESC LIMIT 1
                ) AS progres_tb,
                rkt.mulai_berlaku as rkt_start,
                rkt.akhir_berlaku as rkt_end,   
                rku.nomor_sk as sk_rku,
                rku.tgl_sk as tgl_sk_rku,
                (
                    SELECT luas FROM iuphhk 
                    WHERE id_perusahaan = perusahaan.id_perusahaan AND status = 1 
                    ORDER BY id_iuphhk DESC LIMIT 1
                ) as luas_izin,
/*                (
                    SELECT IF(status = 1,'Aktif', 'Tidak Aktif') FROM iuphhk 
                    WHERE id_perusahaan = perusahaan.id_perusahaan  AND status = 1
                    ORDER BY id_iuphhk DESC LIMIT 1
                ) as status_izin, */
                (
                    SELECT nomor FROM iuphhk 
                    WHERE id_perusahaan = perusahaan.id_perusahaan AND status = 1 
                    ORDER BY id_iuphhk DESC LIMIT 1
                ) as no_sk_izin,                
                /*(
                    SELECT IF(SUM(jumlah) IS NULL,0,SUM(jumlah)) FROM realisasi_serapan_tenaga_kerja 
                    WHERE id_perusahaan = perusahaan.id_perusahaan AND tahun = '".$tahun."'
                ) as jml_naker ,  */
                (
                    SELECT 
                      IF(
                            SUM(realisasi_rkt_serapan_tenaga_kerja.realisasi) IS NULL,0,
                            SUM(realisasi_rkt_serapan_tenaga_kerja.realisasi)
                      ) 
                    FROM 
                      realisasi_rkt_serapan_tenaga_kerja 
                    WHERE 
                      realisasi_rkt_serapan_tenaga_kerja.id_rkt_serapan_tenaga_kerja IN (
                            SELECT rkt_serapan_tenaga_kerja.id FROM rkt_serapan_tenaga_kerja 
                            WHERE rkt_serapan_tenaga_kerja.id_rkt = rkt.id
                      )                
                ) as jml_naker,
                (
                    SELECT SUM(jml_rupiah) FROM investasi
                    WHERE id_perusahaan = perusahaan.id_perusahaan AND DATE_FORMAT(tgl_invest, '%Y') <= ".$tahun." 
                ) as investasi, 
                rkt.nomor_sk as no_sk_rkt,
                rkt.tanggal_sk as tgl_sk_rkt,
                (
                    (   SELECT IF(SUM(jumlah_produksi) IS NULL,0,SUM(jumlah_produksi)) as jml FROM rkt_panen_lahan 
                        WHERE id_rkt = rkt.id  ) +  
                    ( 
                        SELECT IF(SUM(jumlah_produksi) IS NULL,0,SUM(jumlah_produksi)) as jml FROM rkt_panen_produksi  
                        WHERE id_rkt = rkt.id 
                    ) 
                ) as target_produksi,
                (
                    (
                        SELECT IF(SUM(realisasi_produksi) IS NULL,0,SUM(realisasi_produksi)) FROM realisasi_rkt_panen_lahan 
                        WHERE id_rkt_panen_lahan IN (
                            SELECT id FROM rkt_panen_lahan   
                            WHERE id_rkt = rkt.id
                        )
                    ) + 
                    (
                        SELECT IF(SUM(realisasi_produksi) IS NULL,0,SUM(realisasi_produksi)) FROM realisasi_rkt_panen_produksi  
                        WHERE id_rkt_panen_produksi IN (
                            SELECT id FROM rkt_panen_produksi  
                            WHERE id_rkt = rkt.id
                        )
                    )
                ) as realisasi_produksi,
                (
                    SELECT IF(SUM(jumlah) IS NULL,0,SUM(jumlah)) as jml FROM rkt_tanam
                    WHERE id_rkt = rkt.id
                ) as target_penanaman,         
                (
                    SELECT IF(SUM(realisasi) IS NULL,0,SUM(realisasi)) FROM realisasi_rkt_tanam   
                    WHERE id_rkt_tanam IN (
                        SELECT id FROM rkt_tanam   
                        WHERE id_rkt = rkt.id
                    )
                ) as realisasi_penanaman,
		(
                    SELECT DATE_FORMAT(sertifikasi_phpl.tanggal_mulai,'%Y') FROM sertifikasi_phpl
                    WHERE id_perusahaan = perusahaan.id_perusahaan AND '".$tahun."' BETWEEN DATE_FORMAT(sertifikasi_phpl.tanggal_mulai,'%Y')
                    AND DATE_FORMAT(tanggal_berakhir,'%Y')
                    ORDER BY tanggal DESC LIMIT 1
                ) as tahun_phpl,
/*		(
//                    SELECT nomor FROM sertifikasi_phpl
//                    WHERE id_perusahaan = perusahaan.id_perusahaan AND '".$tahun."' BETWEEN DATE_FORMAT(sertifikasi_phpl.tanggal_mulai,'%Y')
//                    AND DATE_FORMAT(tanggal_berakhir,'%Y')
//                    ORDER BY tanggal DESC LIMIT 1
                ) as nomor_phpl, */
		(
                    SELECT predikat FROM sertifikasi_phpl
                    WHERE id_perusahaan = perusahaan.id_perusahaan AND '".$tahun."' BETWEEN DATE_FORMAT(sertifikasi_phpl.tanggal_mulai,'%Y')
                    AND DATE_FORMAT(tanggal_berakhir,'%Y')
                    ORDER BY tanggal DESC LIMIT 1
                ) as predikat_phpl,                     
		(
                    SELECT DATE_FORMAT(sertifikasi_phpl.tanggal_berakhir,'%Y') FROM sertifikasi_phpl
                    WHERE id_perusahaan = perusahaan.id_perusahaan AND '".$tahun."' BETWEEN DATE_FORMAT(sertifikasi_phpl.tanggal_mulai,'%Y')
                    AND DATE_FORMAT(tanggal_berakhir,'%Y')
                    ORDER BY tanggal DESC LIMIT 1
                ) as berakhir_phpl,
/*              DATE_FORMAT(sertifikasi_phpl.tanggal_mulai,'%Y') as tahun_phpl,
//              sertifikasi_phpl.predikat as predikat_phpl,
//              DATE_FORMAT(sertifikasi_phpl.tanggal_berakhir,'%Y') as berakhir_phpl,*/
                DATE_FORMAT(sertifikasi_vlk.berlaku,'%Y') as tahun_vlk,
                sertifikasi_vlk.predikat as predikat_vlk,
                DATE_FORMAT(sertifikasi_vlk.berakhir,'%Y') as berakhir_vlk   
            FROM 
                perusahaan                 
            INNER JOIN (
                    SELECT 
                        DISTINCT 
                        iuphhk_adm_pemerintahan.provinsi as id_provinsi, 
                        iuphhk_adm_pemerintahan.id_iuphhk,    
                        provinsi.nama as nama_provinsi,
                        iuphhk.id_perusahaan 
                    FROM 
                        iuphhk_adm_pemerintahan 
                    INNER JOIN provinsi ON (
                        iuphhk_adm_pemerintahan.provinsi = provinsi.id_provinsi  
                    )             
                    INNER JOIN iuphhk ON (
                        iuphhk.id_iuphhk = iuphhk_adm_pemerintahan.id_iuphhk
                    )
            ) as provinsi_perusahaan ON (
                perusahaan.id_perusahaan = provinsi_perusahaan.id_perusahaan 
            )            
            LEFT JOIN rkt ON (
                rkt.id_perusahaan = perusahaan.id_perusahaan AND 
                rkt.status = 1 AND 
                rkt.tahun_mulai = '".$tahun."'	
            )
 /*           LEFT JOIN sertifikasi_phpl ON (
                sertifikasi_phpl.id_perusahaan = perusahaan.id_perusahaan AND 
                '".$tahun."' BETWEEN DATE_FORMAT(sertifikasi_phpl.tanggal_mulai,'%Y') AND DATE_FORMAT(sertifikasi_phpl.tanggal_berakhir,'%Y')
            )*/
            LEFT JOIN sertifikasi_vlk ON (
                sertifikasi_vlk.id_perusahaan = perusahaan.id_perusahaan AND 
                '".$tahun."' BETWEEN DATE_FORMAT(sertifikasi_vlk.berlaku,'%Y') AND DATE_FORMAT(sertifikasi_vlk.berakhir,'%Y')
            )
            LEFT JOIN rku ON (
                rku.id_perusahaan = perusahaan.id_perusahaan AND 
                '".$tahun."' BETWEEN rku.tahun_mulai AND rku.tahun_sampai AND rku.status = 1
            )            
        ";
        $usertype = Yii::app()->user->type;
        if($usertype == 3){
            $query .= " INNER JOIN bphp_wilayah_kerja ON bphp_wilayah_kerja.id_provinsi = provinsi_perusahaan.id_provinsi "
                      ." AND bphp_wilayah_kerja.id_master_bphp = ".Yii::app()->user->id_bphp;
        }
        if(!empty($provinsi)){
            $query .= " WHERE provinsi_perusahaan.id_provinsi = ".$provinsi;
        }
        $query .= " ORDER BY provinsi_perusahaan.id_provinsi";
        
//        print_r("<pre>");print_r($query);print_r("</pre>");
//        die();
        
        $data = Yii::app()->db->createCommand($query)->queryAll();
        
        foreach($data as $idx => $val){
            //die($val['id_perusahaan']);
            $ProgressTataBatas = RumusPenilaianKinerja::getNilaiProgresTataBatas($val['id_perusahaan'], $val['rkt_start'], $val['rkt_end']);
            //die(debug($ProgressTataBatas));
            $RKU = RumusPenilaianKinerja::getNilaiPersetujuanRKU($val['id_perusahaan'], $tahun);
            $RKT = RumusPenilaianKinerja::getNilaiPengesahanRKT($val['id_perusahaan'], $tahun);
            $Ganis = RumusPenilaianKinerja::getNilaiGanisBersertifikat($val['id_perusahaan'], $tahun, $val['rkt_start'], $val['rkt_end']);
            $Penanaman = RumusPenilaianKinerja::getNilaiRealisasiPenanaman($val['id_perusahaan'], $tahun);    
            $PHPLorVLK = RumusPenilaianKinerja::getNilaiPHPLorVLK($val['id_perusahaan'], $tahun, $val['rkt_start'], $val['rkt_end']);            
            $total = $ProgressTataBatas['nilai']+$RKU['nilai']+$RKT['nilai']+$Ganis['nilai']+$Penanaman['nilai']+$PHPLorVLK['nilai'];
            $gradeRekom = RumusPenilaianKinerja::getNilaiGradeAndRekomendasi($total);                        
            
            $data[$idx]['eval'] = $gradeRekom;
            if($data[$idx]['realisasi_produksi'] > 0){
                $data[$idx]['persentase_produksi'] = ($data[$idx]['realisasi_produksi']/$data[$idx]['target_produksi']) * 100;
            } else {
                $data[$idx]['persentase_produksi'] = 0;
            }
            if($data[$idx]['realisasi_penanaman'] > 0){
                $data[$idx]['persentase_'] = ($data[$idx]['realisasi_penanaman']/$data[$idx]['target_penanaman']) * 100;
            } else {
                $data[$idx]['persentase_penanaman'] = 0;
            }
            
            $data[$idx]['evaluasi'] = $gradeRekom['grade'].' - '.$gradeRekom['rekomendasi'];
        }
        return $data;
    }

    public static function getNilaiProgresTataBatas($idPerusahaan, $RktStart, $RktEnd)
    {
        $currentDate = self::setmktime(date('Y-m-d'));
        $EndRktDate  = self::setmktime($RktEnd);
        $RktStartTime = self::setmktime($RktStart);
        
        
        if($currentDate > $RktStartTime && $currentDate <= $EndRktDate){
            $endTime = date('Y-m-d');            
        } else {
            $endTime = $RktEnd;            
        }
        //debug($endTime);
        //debug("id_perusahaan = ".$idPerusahaan." AND tanggal <= '".$endTime."'");
        $model = ProgresTataBatas::model()->find([
            'condition' => "id_perusahaan = ".$idPerusahaan." AND tanggal <= '".$endTime."'",
            'order' => "tanggal DESC"
        ]);
        //debug($model);
        //exit();
        if(isset($model)){
            $mdlNilai = MasterProgresTataBatas::model()->find([
                'condition' => "id_progres_tata_batas=".$model->id_progres_tata_batas
            ]);
        //debug($mdlNilai);
        //exit();            
            $kriteria = $mdlNilai->nama_progres_tata_batas;
            switch ($model->id_progres_tata_batas){
                case 1 :
                    $nilai = 0;
                    break;
                case 2 :
                    $nilai = 7;
                    break;
                case 3 :
                    $nilai = 15;
                    break;                
            }
        } else {
            $kriteria = 'Belum Ada Proses';
            $nilai = 0;
        }
        return [
            'bobot' => self::$bobotProgresTataBatas, 
            'kriteria' => $kriteria,
            'nilai' => $nilai
        ];
    }
    
    public static function getNilaiPersetujuanRKU($idPerusahaan, $tahun) {
        $model = Rku::model()->find([
            'condition' => "id_perusahaan=".$idPerusahaan." AND tahun_mulai <= ".$tahun." AND tahun_sampai >= ".$tahun
        ]);
        
        if(isset($model)){
            return [
                'bobot' => self::$bobotRKU, 
                'kriteria' => 'Sudah Persetujuan',
                'nilai' => self::$bobotRKU
            ];                        
        }  else {
            return [
                'bobot' => self::$bobotRKU, 
                'kriteria' => 'Belum Persetujuan',
                'nilai' => 0
            ];                                   
        }
        
    }
    
    public static function getNilaiPengesahanRKT($idPerusahaan, $tahun) {
        $model = Rkt::model()->find([
            'condition' => "id_perusahaan=".$idPerusahaan." AND tahun_mulai = ".$tahun
        ]);
        $tahunMin = $tahun-1;
        $model2 = Rkt::model()->find([
            'condition' => "id_perusahaan=".$idPerusahaan." AND tahun_mulai = ".$tahunMin
        ]);
        
        if(isset($model) || isset($model2)) {
            return [
                'bobot' => self::$bobotRKT, 
                'kriteria' => 'Sudah Pengesahan',
                'nilai' => self::$bobotRKT
            ];                                               
        } else {
            return [
                'bobot' => self::$bobotRKT, 
                'kriteria' => 'Belum Pengesahan',
                'nilai' => 0
            ];                                                           
        }        
    }
    
    public static function setmktime($date) {
        return mktime(0,0,0,substr($date,5,2), substr($date, 8,2), substr($date, 0,4));
    }
    
    public static function compareStandarGanis($idPerusahaann, $luasIzin, $RktStart, $RktEnd) {
        $standarGanis = MasterJenisGanis::model()->findAll();                
        $currentDate = self::setmktime(date('Y-m-d'));
        $EndRktDate  = self::setmktime($RktEnd);
        $RktStartTime = self::setmktime($RktStart);
        
        
        if($currentDate > $RktStartTime && $currentDate <= $EndRktDate){
            $endTime = date('Y-m-d');
            $forceToCurrdate = true;
        } else {
            $endTime = $RktEnd;
            $forceToCurrdate = false;
        }
        
        $query = "select t.* 
                                from iuphhk_tenaga_kerja t
                                join sertifikat_ganis s
                                on t.id = s.id_iuphhk_tenaga_kerja
                                where t.id_perusahaan=".$idPerusahaann." and t.is_aktif='1' 
                                     AND s.approval_status=1
                                     AND '".$endTime."' BETWEEN s.tgl_awal_sk  and s.tgl_akhir_sk";
        
        
       
        $ganisPerusahaan = Yii::app()->db->createCommand($query)->queryAll() ;
        

        /*
        $ganisPerusahaan = IuphhkTenagaKerja::model()->findAll(array(
            "condition" => "id_perusahaan = ".$idPerusahaann." AND is_aktif = '1' AND (
                '".$endTime."' BETWEEN tgl_awal_sertifikat AND tgl_akhir_sertifikat
             )"
        ));
         * 
         */                                        
        /*
        if($forceToCurrdate){
            $ganisPerusahaan = IuphhkTenagaKerja::model()->findAll(array(
                "condition" => "id_perusahaan = ".$idPerusahaann." AND is_aktif = '1' AND (
                    '".$endTime."' BETWEEN tgl_awal_sertifikat AND tgl_akhir_sertifikat
                 )"
            ));                                
        } else {
            $ganisPerusahaan = IuphhkTenagaKerja::model()->findAll(array(
                "condition" => "id_perusahaan = ".$idPerusahaann." AND is_aktif = '1' AND (
                    ('".$RktStart."' BETWEEN tgl_awal_sertifikat AND tgl_akhir_sertifikat) OR 
                    ('".$endTime."' BETWEEN tgl_awal_sertifikat AND tgl_akhir_sertifikat) OR 
                    (tgl_awal_sertifikat BETWEEN '".$RktStart."' AND '".$endTime."') OR 
                    (tgl_akhir_sertifikat BETWEEN '".$RktStart."' AND '".$endTime."')
                 )"
            ));                    
        }
         * 
         */
        #debug($ganisPerusahaan);;
        //echo $ganisPerusahaan->get;
        
         
         
        
        if(empty($ganisPerusahaan)) return 0;
        
        if($luasIzin < 25000){
            $divGanis = 'val1';
        } else if($luasIzin >= 25000 && $luasIzin < 50000){
            $divGanis = 'val2';
        } else if($luasIzin >= 50000 && $luasIzin < 100000){
            $divGanis = 'val3';            
        } else if($luasIzin >= 100000 && $luasIzin < 200000){
            $divGanis = 'val4';
        } else if($luasIzin >= 200000){
            $divGanis = 'val5';
        }            
        $totalPersen = 0;
        $persenGanis = 0; 
        
       
        
        foreach($standarGanis as $idx => $value){
            $totalPersen += 100;
            $found[$idx] = 0;                
            foreach($ganisPerusahaan as $idxPrshn => $valPershn){
                if($value->id == $valPershn['id_jenis_tenaga_kerja']){
                    if($found[$idx] < $value->$divGanis){
                        $found[$idx] += 1;
                    }
                   
                }
            }
            
            $persenGanis += ( $found[$idx] / $value->$divGanis ) * 100;
        }        
        
       
        
        $result = ( $persenGanis / $totalPersen ) * 100;        
        return $result;
    }
    
    
    
    
    
    
    public static function getNilaiGanisBersertifikat($idPerusahaan, $tahun, $RktStart, $RktEnd) {
       // echo ($tahun);
        // get Luas izin
        $model = Iuphhk::model()->find([
            'condition' => "id_perusahaan = ".$idPerusahaan
        ]);        
        if(isset($model)){
            $luasIzin = $model->luas;
            $prosenGanis = self::compareStandarGanis($idPerusahaan, $luasIzin, $RktStart, $RktEnd);
            if($prosenGanis <= 50 && $prosenGanis >= 1) {
                $nilai = 7;
                $kriteria = 'Tersedia tenaga teknis PHPL '. number_format($prosenGanis,2, ',','.').'%';
            } else if($prosenGanis > 50) {
                $nilai = 15; 
                $kriteria = 'Tersedia tenaga teknis PHPL '. number_format($prosenGanis,2, ',','.').'%';
            } else {
                $nilai = 0;
                $kriteria = 'Tidak ada tenaga teknis PHPL';
            }
            return [
                'bobot' => self::$bobotNakerBersertifikat, 
                'kriteria' => $kriteria,
                'nilai' => $nilai
            ];                                                                                               
        } else {
            return [
                'bobot' => self::$bobotNakerBersertifikat, 
                'kriteria' => 'Tidak ada tenaga teknis PHPL',
                'nilai' => 0
            ];                                                                                   
        }
        
    }
    
    public static function getNilaiRealisasiPenanaman($idPerusahaan, $tahunRKT) {
        //debug($tahunRKT);
        $rkuAktif = Rku::model()->find(array(
            'condition' => "id_perusahaan=".$idPerusahaan." AND status=1 AND tahun_mulai <= '".$tahunRKT."' AND tahun_sampai >= '".$tahunRKT."'"
        ));
        $nilaiRKU = [];
        $Realisasi = [];
        $RKT = [];
        
        if(isset($rkuAktif)){
            $tahun = [];
            for($x=0; $x<5; $x++){
                //echo $x."<br />";
                $tahun[] = date('Y', mktime(0,0,0,date('m'), date('d'), $tahunRKT-$x));
            }
            
            //debug($tahun);            
            $idrku = $rkuAktif->id_rku;
            $RKU = Yii::app()->db->createCommand()
                    ->select("SUM(jumlah) as total_rku, tahun")
                    ->from("rku_tanam")
                    ->where("id_rku = ".$idrku." AND tahun IN (".implode(",", $tahun).")")
                    ->group("tahun")
                    ->queryAll();
             //debug($RKU);       
             foreach($RKU as $idx => $val){
                 $_tahun             = $val['tahun'];
                 $nilaiRKU[$_tahun]  = $val['total_rku'];
             }
             
             $RKT = Yii::app()->db->createCommand("
                 SELECT 
                    SUM(rkt_tanam.jumlah) as total_rkt,
                    rkt.tahun_mulai as tahun 
                 FROM 
                    rkt_tanam 
                 INNER JOIN rkt ON (
                    rkt_tanam.id_rkt = rkt.id 
                 ) 
                 WHERE 
                    rkt.tahun_mulai IN (".implode(",", $tahun).") AND 
                    rkt.id_perusahaan = ".$idPerusahaan." 
                 GROUP BY 
                    rkt.tahun_mulai                    
             ")->queryAll();             
             foreach($RKT as $idx => $val){
                 $_tahun             = $val['tahun'];
                 $nilaiRKT[$_tahun]  = $val['total_rkt'];
             }
                         
             $Realisasi = Yii::app()->db->createCommand("
                 SELECT 
                    SUM(realisasi_rkt_tanam.realisasi) as total_realisasi, 
                    rkt.tahun_mulai as tahun 
                 FROM 
                    realisasi_rkt_tanam 
                 INNER JOIN rkt_tanam  ON (
                    rkt_tanam.id = realisasi_rkt_tanam.id_rkt_tanam  
                 ) 
                 INNER JOIN rkt ON (
                    rkt_tanam.id_rkt = rkt.id 
                 )
                 WHERE 
                    rkt.tahun_mulai IN (".implode(",", $tahun).") AND 
                    rkt.id_perusahaan = ".$idPerusahaan." 
                 GROUP BY rkt.tahun_mulai 
             ")->queryAll();
             //debug($Realisasi);
             foreach($Realisasi as $idx => $val){
                 $_tahun             = $val['tahun'];
                 $nilaiRealisasi[$_tahun]  = $val['total_realisasi'];
             }
             //debug($nilaiRealisasi);
             #debug($nilaiRKU);
             //debug($nilaiRKT);
             //debug($nilaiRealisasi);
            
             $total_rencana     = 0;
             $total_realisasi   = 0;
            foreach($tahun as $periodeTahun){
                if(array_key_exists($periodeTahun, $nilaiRKT)){
                    $total_rencana += $nilaiRKT[$periodeTahun];
                    if(array_key_exists($periodeTahun, $nilaiRealisasi)){
                        $total_realisasi += $nilaiRealisasi[$periodeTahun];
                    }
                } else {
                    if(array_key_exists($periodeTahun, $nilaiRKU)){
                        $total_rencana += $nilaiRKU[$periodeTahun];
                    }
                }
            }
            #debug($total_realisasi);
            #debug($total_rencana);
            $prosenRealisasi = ($total_realisasi/$total_rencana) * 100;
            #debug($prosenRealisasi);
            if($prosenRealisasi <= 50 && $prosenRealisasi > 0){
                return [
                    'rencana' => number_format($total_rencana,2, ',','.'),
                    'realisasi' => number_format($total_realisasi,2, ',','.'),
                    'persentase' => number_format($prosenRealisasi,2, ',','.').'%',
                    'bobot' => self::$bobotRealisasiPenanaman, 
                    'kriteria' => 'Realisasi Penanaman '. number_format($prosenRealisasi,2, ',','.').'%',
                    'nilai' => 10
                ];                                                                                                   
            } else if($prosenRealisasi > 50){
                return [
                    'rencana' => number_format($total_rencana,2, ',','.'),
                    'realisasi' => number_format($total_realisasi,2, ',','.'),
                    'persentase' => number_format($prosenRealisasi,2, ',','.').'%',
                    'bobot' => self::$bobotRealisasiPenanaman, 
                    'kriteria' => 'Realisasi Penanaman '.number_format($prosenRealisasi,2, ',','.'),
                    'nilai' => self::$bobotRealisasiPenanaman
                ];                                                                                                                   
            } else {
                return [
                    'rencana' => number_format($total_rencana,2, ',','.'),
                    'realisasi' => number_format($total_realisasi,2, ',','.'),
                    'persentase' => number_format($prosenRealisasi,2, ',','.').'%',
                    'bobot' => self::$bobotRealisasiPenanaman, 
                    'kriteria' => 'Belum Ada Penanaman',
                    'nilai' => 0
                ];                                                                                                   
            }            
        } else {
            return [
                'bobot' => self::$bobotRealisasiPenanaman, 
                'kriteria' => 'Belum Ada Penanaman',
                'nilai' => 0
            ];                                                                                   
        }
    }
    
    public static function getNilaiPHPLorVLK($idPerusahaan, $tahun, $RktStart, $RktEnd) {
                
        $currentDate = self::setmktime(date('Y-m-d'));
        $EndRktDate  = self::setmktime($RktEnd);        
        $RktStartTime = self::setmktime($RktStart);
        
        
        if($currentDate > $RktStartTime && $currentDate <= $EndRktDate){
            $endTime = date('Y-m-d');
        } else {
            $endTime = $RktEnd;
        }
                
        $model = Iuphhk::model()->find([
            'condition' => "id_perusahaan = ".$idPerusahaan." AND tgl_end >= '".$endTime."'"
        ]);
        if(isset($model)){
            $datetime1 = new DateTime($endTime);
            $datetime2 = new DateTime($model->tgl_start);
            //debug($datetime1);
            //debug($datetime2);
            $difference = $datetime1->diff($datetime2);
            $diffYear = $difference->y;
            //debug($difference);
            //die("test");
            if(($difference->y >= 3 && $difference->d > 0) || ($difference->y > 3)){
                $cekPHPL = SertifikasiPhpl::model()->find([
                    'condition' => "id_perusahaan = ".$idPerusahaan." AND (              
                        '".$endTime."' BETWEEN tanggal_mulai AND tanggal_berakhir
                    )"
                ]);
                $cekVLK = SertifikasiVlk::model()->find([
                    'condition' => "id_perusahaan = ".$idPerusahaan." AND (                                                
                        '".$endTime."' BETWEEN berlaku AND berakhir
                    )"
                ]);                
                if(isset($cekPHPL)){
                    return [
                        'bobot' => self::$bobotPHPLorVLK, 
                        'kriteria' => 'Sudah Sertifikasi PHPL',
                        'nilai' => 20                        
                    ];
                } elseif (isset($cekVLK)){
                    return [
                        'bobot' => self::$bobotPHPLorVLK, 
                        'kriteria' => 'Sudah Sertifikasi VLK',
                        'nilai' => 10                        
                    ];
                } else {
                    return [
                        'bobot' => self::$bobotPHPLorVLK, 
                        'kriteria' => 'Belum Sertifikasi',
                        'nilai' => 0                        
                    ];                    
                }
            } else {
                $cekPHPL = SertifikasiPhpl::model()->find([
                    'condition' => "id_perusahaan = ".$idPerusahaan." AND (                                                
                        '".$endTime."' BETWEEN tanggal_mulai AND tanggal_berakhir
                    )"
                ]);
                $cekVLK = SertifikasiVlk::model()->find([
                    'condition' => "id_perusahaan = ".$idPerusahaan." AND (                                                
                        '".$endTime."' BETWEEN berlaku AND berakhir
                    )"
                ]);                
                if(isset($cekPHPL)){
                    return [
                        'bobot' => self::$bobotPHPLorVLK, 
                        'kriteria' => 'Sudah Sertifikasi PHPL',
                        'nilai' => 20
                    ];
                } elseif(isset($cekVLK)){
                    return [
                        'bobot' => self::$bobotPHPLorVLK, 
                        'kriteria' => 'Sudah Sertifikasi VLK (Izin UM < 3 Tahun)',
                        'nilai' => 20
                    ];
                } else {
                    return [
                        'bobot' => self::$bobotPHPLorVLK, 
                        'kriteria' => 'Belum Sertifikasi',
                        'nilai' => 0                        
                    ];                    
                }                
            }
        } else {
            //die("test");
            return [
                'bobot' => self::$bobotPHPLorVLK, 
                'kriteria' => 'Belum Sertifikasi',
                'nilai' => 0
            ];                                                                       
        }
    }
    
    public static function getNilaiGradeAndRekomendasi($total) {
        
        if($total >= 76 && $total <= 100 ){
            $grade = 'A';
            $rekomendasi = 'Layak Dilanjutkan (LD)';
        } else if($total >= 50 && $total <= 75 ){
            $grade = 'B';
            $rekomendasi = 'Layak Dilanjutkan dengan Catatan (LDC)';            
        } else if($total >= 21 && $total <= 49 ){
            $grade = 'C';
            $rekomendasi = 'Layak Dilanjutkan dengan Pengawasan (LDP)';            
        } else if($total >= 1 && $total <= 20 ){
            $grade = 'D';
            $rekomendasi = 'Layak Dievaluasi (LE)';            
        }
        return [
            'grade' => $grade,
            'rekomendasi' => $rekomendasi
        ];
    }
    
}