<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RekapLaporan  {
    public static function getRekapAdmin() {
        $query = "                            
            SELECT
            perusahaan.nama_perusahaan AS perusahaan
            FROM
            perusahaan       
        ";
//        $usertype = Yii::app()->user->type;
//        if($usertype == 3){
//            $query .= " INNER JOIN bphp_wilayah_kerja ON bphp_wilayah_kerja.id_provinsi = provinsi_perusahaan.id_provinsi "
//                      ." AND bphp_wilayah_kerja.id_master_bphp = ".Yii::app()->user->id_bphp;
//        }
//        if(!empty($provinsi)){
//            $query .= " WHERE provinsi_perusahaan.id_provinsi = ".$provinsi;
//        }
//        $query .= " ORDER BY provinsi_perusahaan.id_provinsi";
        //die($query);
        $data = Yii::app()->db->createCommand($query)->queryAll();
        
//        foreach($data as $idx => $val){
//            //die($val['id_perusahaan']);
//            $ProgressTataBatas = RumusPenilaianKinerja::getNilaiProgresTataBatas($val['id_perusahaan'], $val['rkt_start'], $val['rkt_end']);
//            //die(debug($ProgressTataBatas));
//            $RKU = RumusPenilaianKinerja::getNilaiPersetujuanRKU($val['id_perusahaan'], $tahun);
//            $RKT = RumusPenilaianKinerja::getNilaiPengesahanRKT($val['id_perusahaan'], $tahun);
//            $Ganis = RumusPenilaianKinerja::getNilaiGanisBersertifikat($val['id_perusahaan'], $tahun, $val['rkt_start'], $val['rkt_end']);
//            $Penanaman = RumusPenilaianKinerja::getNilaiRealisasiPenanaman($val['id_perusahaan'], $tahun);    
//            $PHPLorVLK = RumusPenilaianKinerja::getNilaiPHPLorVLK($val['id_perusahaan'], $tahun, $val['rkt_start'], $val['rkt_end']);            
//            $total = $ProgressTataBatas['nilai']+$RKU['nilai']+$RKT['nilai']+$Ganis['nilai']+$Penanaman['nilai']+$PHPLorVLK['nilai'];
//            $gradeRekom = RumusPenilaianKinerja::getNilaiGradeAndRekomendasi($total);                        
//            
//            $data[$idx]['eval'] = $gradeRekom;
//            if($data[$idx]['realisasi_produksi'] > 0){
//                $data[$idx]['persentase_produksi'] = ($data[$idx]['realisasi_produksi']/$data[$idx]['target_produksi']) * 100;
//            } else {
//                $data[$idx]['persentase_produksi'] = 0;
//            }
//            if($data[$idx]['realisasi_penanaman'] > 0){
//                $data[$idx]['persentase_'] = ($data[$idx]['realisasi_penanaman']/$data[$idx]['target_penanaman']) * 100;
//            } else {
//                $data[$idx]['persentase_penanaman'] = 0;
//            }
//            
//            $data[$idx]['evaluasi'] = $gradeRekom['grade'].' - '.$gradeRekom['rekomendasi'];
//        }
//        return $data;
    }
}