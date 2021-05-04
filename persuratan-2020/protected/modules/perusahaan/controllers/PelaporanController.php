<?php

class PelaporanController extends Controller {

    public function actionIndex3() {
        $rku = Rku::model()->find(array(
            'condition' => 'tahun_mulai<=' . date('Y') . ' AND tahun_sampai>=' . date('Y') . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
        ));
        $id_rku = !empty($rku) ? $rku->id_rku : 0;
        $rkt = Rkt::model()->find(array(
            'condition' => 'tahun=' . date('Y') . ' AND id_rku=' . $id_rku . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
        ));
        $id_rkt = !empty($rkt) ? $rkt->id : 0;
        $laporan = PenilaianKinerja::model()->find(array(
            'condition' => 'tahun=' . date('Y') . ' AND id_rkt=' . $id_rkt . ' AND id_rku=' . $id_rku . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
        ));
        $model = new PenilaianKinerja;

        $this->render('index', array(
            'model' => $model
        ));
    }

    public function actionIndex2() {
        $aspek = Aspek::model()->findAll();
        $no = 0;
        foreach ($aspek as $value) {
            $i = $no;
            $data[$i]['aspek'] = $value->nama_aspek;
            $data[$i]['bobot'] = $value->bobot;

            if ($value->id == 1) {
                $nilai = $this->cekBatas(1, 1);
                $data[$i]['kpi'] = $nilai->nama_kriteria;
                $data[$i]['nilai'] = $nilai->bobot;
            }
            $no++;
        }
        $nilai = PenilaianKinerja::model()->with()->findByAttributes(array('tahun' => 2106));

//        print_r($data);die;
        $model = new CArrayDataProvider($data, array(
            'id' => 'lamp_permohonan',
            'keyField' => 'aspek',
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));

        $this->render('index', array(
            'model' => $model
        ));
    }

    function cekBatas($rku, $perusahaan) {

        $total = 0;
        $target = RkuTataBatas::model()->find(array(
            'condition' => 'id_rku="' . $rku . '" AND id_perusahaan="' . $perusahaan . '"'
        ));
        $pengukuran = PengukuranTataBatas::model()->find(array(
            'select' => 'sum(realisasi) as total',
            'condition' => 'id_tata_batas="' . $target->id . '" AND id_perusahaan="' . $perusahaan . '"'
        ));

        if (!empty($pengukuran)) {
            if ($pengukuran->total >= $target->target) {
                $model = Kriteria::model()->findByPk(3);
            } elseif ($pengukuran->total > 0) {
                $model = Kriteria::model()->findByPk(2);
            } else {
                $model = Kriteria::model()->findByPk(1);
            }
        } else {
            $model = Kriteria::model()->findByPk(1);
        }
        return $model;
    }
    
    public function actionIndex() {
        //die("wkwk");
        $iup = Iuphhk::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        if (!isset($iup)) {
            $message = Yii::t('app', 'Lengkapi dulu data IUPHHK .');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//perusahaan/iuphhk/index'));
        }
        $rku = Rku::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan(),'order'=>'id DESC'));
        
        //RumusPenilaianKinerja::getNilaiRealisasiPenanaman(Yii::app()->user->idPerusahaan(), date('Y'));
        
        if(!isset($rkt)) {
            /*$message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
            */
            $tahun = date('Y');
            $rkt_start = date('Y').'-01-01';
            $rkt_end = date('Y').'-12-31';
            
        } else {
            $tahun = $rkt->tahun_mulai;
            $rkt_start = $rkt->mulai_berlaku;
            $rkt_end = $rkt->akhir_berlaku;
        }
        
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));            
            if (!isset($rkt)) {
                #$message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                #Yii::app()->user->setFlash('notice', $message);
                #$this->redirect(array('//perusahaan/rkt/index'));
                $tahun = $_POST['Rkt']['tahun_mulai'];
                $rkt_start = $_POST['Rkt']['tahun_mulai'].'-01-01';
                $rkt_end = $_POST['Rkt']['tahun_mulai'].'-12-31';                
            } else {
                $tahun = $rkt->tahun_mulai;
                $rkt_start = $rkt->mulai_berlaku;
                $rkt_end = $rkt->akhir_berlaku;                            
            }
            
        }

        #if (isset($rkt)) {
            $aspek = Aspek::model()->findAll();
            $no = 0;
            foreach ($aspek as $value) {
                $i = $no;
                $data[$i]['aspek'] = $value->nama_aspek;
                $data[$i]['bobot'] = $value->bobot;
                $no++;
            }

            /*
            $kinerja = PenilaianKinerja::model()->find(array(
                'condition' => 'id_rkt=' . $rkt->id . ' AND tahun = ' . $rkt->tahun_mulai . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
            ));
            // var_dump($kinerja);die;
            if (!isset($kinerja)) {
                $this->generateReport(Yii::app()->user->idPerusahaan(), $rkt);
                $kinerja = PenilaianKinerja::model()->find(array(
                    'condition' => 'id_rkt=' . $rkt->id . ' AND tahun = ' . $rkt->tahun_mulai . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
                ));
            } else {
                $kinerja = $this->updateReport($kinerja, $rkt);
            }
            */
//            debug(Yii::app()->user->idPerusahaan());debug($rkt_start);
//            debug($rkt_end);


            $ProgressTataBatas = RumusPenilaianKinerja::getNilaiProgresTataBatas(Yii::app()->user->idPerusahaan(), $rkt_start, $rkt_end);
            $RKU = RumusPenilaianKinerja::getNilaiPersetujuanRKU(Yii::app()->user->idPerusahaan(), $tahun);
            $RKT = RumusPenilaianKinerja::getNilaiPengesahanRKT(Yii::app()->user->idPerusahaan(), $tahun);
            $Ganis = RumusPenilaianKinerja::getNilaiGanisBersertifikat(Yii::app()->user->idPerusahaan(), $tahun, $rkt_start, $rkt_end);
            $Penanaman = RumusPenilaianKinerja::getNilaiRealisasiPenanaman(Yii::app()->user->idPerusahaan(), $tahun);    
            $PHPLorVLK = RumusPenilaianKinerja::getNilaiPHPLorVLK(Yii::app()->user->idPerusahaan(), $tahun, $rkt_start, $rkt_end);
            
// print_r("<pre>");
//            print_r($rkt_start);print_r($rkt_end);
//            print_r("</pre>"); die();
            
            
            $data[0]['kpi'] = $ProgressTataBatas['kriteria'];
            $data[1]['kpi'] = $RKU['kriteria'];
            $data[2]['kpi'] = $RKT['kriteria'];
            $data[3]['kpi'] = $Ganis['kriteria'];
            $data[4]['kpi'] = $Penanaman['kriteria'];
            $data[5]['kpi'] = $PHPLorVLK['kriteria'];

            $data[0]['nilai'] = $ProgressTataBatas['nilai'];
            $data[1]['nilai'] = $RKU['nilai'];
            $data[2]['nilai'] = $RKT['nilai'];
            $data[3]['nilai'] = $Ganis['nilai'];
            $data[4]['nilai'] = $Penanaman['nilai'];
            $data[5]['nilai'] = $PHPLorVLK['nilai'];

            for ($j = 0; $j < 6; $j++) {
                $total = $ProgressTataBatas['nilai']+$RKU['nilai']+$RKT['nilai']+$Ganis['nilai']+$Penanaman['nilai']+$PHPLorVLK['nilai'];
                $gradeRekom = RumusPenilaianKinerja::getNilaiGradeAndRekomendasi($total);
                $data[$j]['total'] = $total;
                $data[$j]['grade'] = $gradeRekom['grade'];
                $data[$j]['rekom'] = $gradeRekom['rekomendasi'];
            }
            $model = new CArrayDataProvider($data, array(
                'id' => 'lamp_permohonan',
                'keyField' => 'aspek',
                'pagination' => array(
                    'pageSize' => 50,
                ),
            ));
            
            
                       
//            
//            
        #} else {
        #    $message = Yii::t('app', 'Data RKT Belum ada');
        #    Yii::app()->user->setFlash('error', $message);
        #    $this->redirect(array('//perusahaan/rkt/index'));
        #}
        $this->render('index_1', array(
            'model' => $model,
            'tahun' => $tahun,
            'rku' => $rku
        ));
    }

    public function __actionIndex() {
        //die("wkwk");
        $iup = Iuphhk::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        if (!isset($iup)) {
            $message = Yii::t('app', 'Lengkapi dulu data IUPHHK .');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//perusahaan/iuphhk/index'));
        }
        $rku = Rku::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan(),'order'=>'id DESC'));
        if(!isset($rkt)) {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
        }
        $tahun = $rkt->tahun_mulai;
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rkt/index'));
            }
            $tahun = $rkt->tahun_mulai;
        }

        if (isset($rkt)) {
            $aspek = Aspek::model()->findAll();
            $no = 0;
            foreach ($aspek as $value) {
                $i = $no;
                $data[$i]['aspek'] = $value->nama_aspek;
                $data[$i]['bobot'] = $value->bobot;
                $no++;
            }

            $kinerja = PenilaianKinerja::model()->find(array(
                'condition' => 'id_rkt=' . $rkt->id . ' AND tahun = ' . $rkt->tahun_mulai . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
            ));
            // var_dump($kinerja);die;
            if (!isset($kinerja)) {
                $this->generateReport(Yii::app()->user->idPerusahaan(), $rkt);
                $kinerja = PenilaianKinerja::model()->find(array(
                    'condition' => 'id_rkt=' . $rkt->id . ' AND tahun = ' . $rkt->tahun_mulai . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
                ));
            } else {
                $kinerja = $this->updateReport($kinerja, $rkt);
            }

            $data[0]['kpi'] = isset($kinerja->aspek_1) ? $this->getKriteria($kinerja->aspek_1) : null;
            $data[1]['kpi'] = isset($kinerja->aspek_2) ? $this->getKriteria($kinerja->aspek_2) : null;
            $data[2]['kpi'] = isset($kinerja->aspek_3) ? $this->getKriteria($kinerja->aspek_3) : null;
            $data[3]['kpi'] = isset($kinerja->aspek_4) ? $this->getKriteria($kinerja->aspek_4) : null;
            $data[4]['kpi'] = isset($kinerja->aspek_5) ? $this->getKriteria($kinerja->aspek_5) : null;
            $data[5]['kpi'] = isset($kinerja->aspek_6) ? $this->getKriteria($kinerja->aspek_6) : null;

            $data[0]['nilai'] = isset($kinerja->aspek_1) ? $this->getNilai($kinerja->aspek_1) : null;
            $data[1]['nilai'] = isset($kinerja->aspek_2) ? $this->getNilai($kinerja->aspek_2) : null;
            $data[2]['nilai'] = isset($kinerja->aspek_3) ? $this->getNilai($kinerja->aspek_3) : null;
            $data[3]['nilai'] = isset($kinerja->aspek_4) ? $this->getNilai($kinerja->aspek_4) : null;
            $data[4]['nilai'] = isset($kinerja->aspek_5) ? $this->getNilai($kinerja->aspek_5) : null;
            $data[5]['nilai'] = isset($kinerja->aspek_6) ? $this->getNilai($kinerja->aspek_6) : null;

            for ($j = 0; $j < 6; $j++) {
                $data[$j]['total'] = isset($kinerja->id) ? $this->total($kinerja) : null;
                $data[$j]['grade'] = isset($kinerja->id) ? $this->grade($kinerja) : null;
                $data[$j]['rekom'] = isset($kinerja->id) ? $this->rekom($kinerja) : null;
            }
            $model = new CArrayDataProvider($data, array(
                'id' => 'lamp_permohonan',
                'keyField' => 'aspek',
                'pagination' => array(
                    'pageSize' => 50,
                ),
            ));
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
        }
        $this->render('index_1', array(
            'model' => $model,
            'tahun' => $tahun,
            'rku' => $rku
        ));
    }

    private function getKriteria($id) {
        $model = Kriteria::model()->findByPk($id);
        return $model->nama_kriteria;
    }

    private function getNilai($id) {
        $model = Kriteria::model()->findByPk($id);
        return $model->bobot;
    }

    private function total($id) {
        $model_1 = Kriteria::model()->findByPk($id->aspek_1);
        $model_2 = Kriteria::model()->findByPk($id->aspek_2);
        $model_3 = Kriteria::model()->findByPk($id->aspek_3);
        $model_4 = Kriteria::model()->findByPk($id->aspek_4);
        $model_5 = Kriteria::model()->findByPk($id->aspek_5);
        $model_6 = Kriteria::model()->findByPk($id->aspek_6);

        $total = $model_1->bobot + $model_2->bobot + $model_3->bobot + $model_4->bobot + $model_5->bobot + $model_6->bobot;
        return $total;
    }

    private function rekom($id) {
        $nilai = $this->total($id);
        if ($nilai >= 76 AND $nilai <= 100) {
            $rekomendasi = 'Layak dilanjutkan (LD)';
        } elseif ($nilai >= 50 AND $nilai <= 75) {
            $rekomendasi = 'Layak dilanjutkan dengan catatan (LDC)';
        } elseif ($nilai >= 21 AND $nilai <= 49) {
            $rekomendasi = 'Layak dilanjutkan dengan pengawasan (LDP)';
        } else {
            $rekomendasi = 'Layak dievaluasi (LE)';
        }
        return $rekomendasi;
    }

    private function grade($id) {
        $nilai = $this->total($id);
        if ($nilai >= 76 AND $nilai <= 100) {
            $mark = 'A';
        } elseif ($nilai >= 50 AND $nilai <= 75) {
            $mark = 'B';
        } elseif ($nilai >= 21 AND $nilai <= 49) {
            $mark = 'C';
        } else {
            $mark = 'D';
        }
        return $mark;
    }

    protected function generateReport($id_perusahaan, $rkt) {

        $model = new PenilaianKinerja;
        $model->id_perusahaan = $id_perusahaan;
        $model->id_rkt = $rkt->id;
        $model->tahun = $rkt->tahun_mulai;

        // //cek tata batas
        // $modelTataBatas = new RktTataBatas;
        // $modelTataBatas->unsetAttributes();
        // $modelTataBatas->id_rkt = $rkt->id;

        // $tata_batas = RktTanam::model()->getTotalPersen($modelTataBatas->search()->getData(), 'persentase');

        // if ($tata_batas > 50) {
        //     $model->aspek_1 = 14;
        // } elseif ($tata_batas >= 1 && $tata_batas <= 50) {
        //     $model->aspek_1 = 13;
        // } else {
        //     $model->aspek_1 = 12;
        // }

        $status_batas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if ($status_batas) {
            if ($status_batas->status == 1) {
                $model->aspek_1 = 1;
            } elseif ($status_batas->status == 2) {
                $model->aspek_1 = 2;
            } else {
                $model->aspek_1 = 3;
            }
        } else {
            $p_tb = new ProgresTataBatas;
            $p_tb->id_rkt = $rkt->id;
            $p_tb->status = 1;
            $p_tb->save();
            $model->aspek_1 = 1;
        }
        // proses tata batas
        $model->aspek_2 = 6;
        $model->aspek_3 = 8;

        //cek ganis
        $modelGanis = new RktGanis;
        $modelGanis->unsetAttributes();
        $modelGanis->id_rkt = $rkt->id;

        $ganis = RktTanam::model()->getTotalPersen($modelGanis->search()->getData(), 'persentase');

        if ($ganis > 50) {
            $model->aspek_4 = 11;
        } elseif ($ganis >= 1 && $ganis <= 50) {
            $model->aspek_4 = 10;
        } else {
            $model->aspek_4 = 9;
        }

        //cek penanaman
        $modelPenanaman = new RktTanam;
        $modelPenanaman->unsetAttributes();
        $modelPenanaman->id_rkt = $rkt->id;

        $penanaman = RktTanam::model()->getTotalPersen($modelPenanaman->search()->getData(), 'persentase');

        if ($penanaman > 50) {
            $model->aspek_5 = 14;
        } elseif ($penanaman >= 1 && $penanaman <= 50) {
            $model->aspek_5 = 13;
        } else {
            $model->aspek_5 = 12;
        }

        //cek sertifikasi
        if (date('Y') == $rkt->tahun_mulai) {
            $condition_phpl = 'id_perusahaan = ' . $id_perusahaan . ' AND tanggal_mulai <= "' . date('Y-m-d') . '" AND tanggal_berakhir >= "' . date('Y-m-d') . '"';
            $condition_vlk = 'id_perusahaan = ' . $id_perusahaan . ' AND year(berlaku) <= "' . date('Y-m-d') . '" AND year(berakhir) >= "' . date('Y-m-d') . '"';
        } else {
            $condition_phpl = 'id_perusahaan = ' . $id_perusahaan . ' AND year(tanggal_mulai) <= ' . $rkt->tahun_mulai . ' AND year(tanggal_berakhir) >= ' . $rkt->tahun_mulai;
            $condition_vlk = 'id_perusahaan = ' . $id_perusahaan . ' AND year(berlaku) <= ' . $rkt->tahun_mulai . ' AND year(berakhir) >= ' . $rkt->tahun_mulai;
        }

        $phpl = SertifikasiPhpl::model()->find(array(
            'condition' => $condition_phpl
        ));
        if ($phpl) {
            $model->aspek_6 = 17;
        } else {
            $vlk = SertifikasiVlk::model()->find(array(
                'condition' => $condition_vlk
            ));
            if ($vlk) {
                $model->aspek_6 = 16;
            } else {
                $model->aspek_6 = 15;
            }
        }

        $model->save();
    }

    protected function updateReport($model, $rkt) {

        // //cek tata batas
        // $modelTataBatas = new RktTataBatas;
        // $modelTataBatas->unsetAttributes();
        // $modelTataBatas->id_rkt = $rkt->id;

        // $tata_batas = RktTanam::model()->getTotalPersen($modelTataBatas->search()->getData(), 'persentase');

        // if ($tata_batas > 50) {
        //     $model->aspek_1 = 14;
        // } elseif ($tata_batas >= 1 && $tata_batas <= 50) {
        //     $model->aspek_1 = 13;
        // } else {
        //     $model->aspek_1 = 12;
        // }

        $status_batas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if ($status_batas) {
            if ($status_batas->status == 1) {
                $model->aspek_1 = 1;
            } elseif ($status_batas->status == 2) {
                $model->aspek_1 = 2;
            } else {
                $model->aspek_1 = 3;
            }
        } else {
            $p_tb = new ProgresTataBatas;
            $p_tb->id_rkt = $rkt->id;
            $p_tb->status = 1;
            $p_tb->save();
            $model->aspek_1 = 1;
        }
//        $model->aspek_2 = isset($data2->aspek_2) ? $data2->aspek_2 : 6;
//        $model->aspek_3 = isset($data2->aspek_3) ? $data2->aspek_3 : 8;
        //cek ganis
        $modelGanis = new RktGanis;
        $modelGanis->unsetAttributes();
        $modelGanis->id_rkt = $rkt->id;

        $ganis = RktTanam::model()->getTotalPersen($modelGanis->search()->getData(), 'persentase');

        if ($ganis > 50) {
            $model->aspek_4 = 11;
        } elseif ($ganis >= 1 && $ganis <= 50) {
            $model->aspek_4 = 10;
        } else {
            $model->aspek_4 = 9;
        }

        //cek penanaman
        $modelPenanaman = new RktTanam;
        $modelPenanaman->unsetAttributes();
        $modelPenanaman->id_rkt = $rkt->id;

        $penanaman = RktTanam::model()->getTotalPersen($modelPenanaman->search()->getData(), 'persentase');

        if ($penanaman > 50) {
            $model->aspek_5 = 14;
        } elseif ($penanaman >= 1 && $penanaman <= 50) {
            $model->aspek_5 = 13;
        } else {
            $model->aspek_5 = 12;
        }

        //cek sertifikasi
        if (date('Y') == $rkt->tahun_mulai) {
            $condition_phpl = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND tanggal_mulai <= "' . date('Y-m-d') . '" AND tanggal_berakhir >= "' . date('Y-m-d') . '"';
            $condition_vlk = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND year(berlaku) <= "' . date('Y-m-d') . '" AND year(berakhir) >= "' . date('Y-m-d') . '"';
        } else {
            $condition_phpl = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND year(tanggal_mulai) <= ' . $rkt->tahun_mulai . ' AND year(tanggal_berakhir) >= ' . $rkt->tahun_mulai;
            $condition_vlk = 'id_perusahaan = ' . $rkt->id_perusahaan . ' AND year(berlaku) <= ' . $rkt->tahun_mulai . ' AND year(berakhir) >= ' . $rkt->tahun_mulai;
        }

        $phpl = SertifikasiPhpl::model()->find(array(
            'condition' => $condition_phpl
        ));
        if ($phpl) {
            $model->aspek_6 = 17;
        } else {
            $vlk = SertifikasiVlk::model()->find(array(
                'condition' => $condition_vlk
            ));
            if ($vlk) {
                $model->aspek_6 = 16;
            } else {
                $model->aspek_6 = 15;
            }
        }

        $model->save();

        return $model;
    }

}
