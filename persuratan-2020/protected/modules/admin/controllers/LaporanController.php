<?php

class LaporanController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array(Yii::app()->user->adminRole()),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */

    /**
     * Manages all models.
     */
    public function actionIndex($id) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk' . $id));
        }
        $rku = Rku::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '.$iup->id_perusahaan));
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_rku = ' . $rku->id_rku,'order'=>'id DESC'));
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_rku = ' . $rku->id_rku . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rkt/' . $id));
            }
        }

        if (isset($rkt)) {
            //        Data Laporan 
            $aspek = Aspek::model()->findAll();
            $no = 0;
            foreach ($aspek as $value) {
                $i = $no;
                $data[$i]['aspek'] = $value->nama_aspek;
                $data[$i]['bobot'] = $value->bobot;
                $no++;
            }

            $kinerja = PenilaianKinerja::model()->find(array(
                'condition' => 'id_rkt=' . $rkt->id . ' AND tahun = ' . $rkt->tahun_mulai . ' AND id_perusahaan=' . $iup->id_perusahaan
            ));
            if (!isset($kinerja)) {
                $this->generateReport($iup->id_perusahaan, $rkt);
                $kinerja = PenilaianKinerja::model()->find(array(
                    'condition' => 'id_rkt=' . $rkt->id . ' AND tahun = ' . $rkt->tahun_mulai . ' AND id_perusahaan=' . $iup->id_perusahaan
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
            $laporan = new CArrayDataProvider($data, array(
                'id' => 'lamp_permohonan',
                'keyField' => 'aspek',
                'pagination' => array(
                    'pageSize' => 50,
                ),
            ));
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rkt/' . $id));
        }

        $this->render('index', array(
            'model' => $laporan,
            'iup' => $iup,
            'rkt'=>$rkt,
            'rku'=>$rku,
            'id'=>$id
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

        //cek tata batas
        $modelTataBatas = new RktTataBatas;
        $modelTataBatas->unsetAttributes();
        $modelTataBatas->id_rkt = $rkt->id;

        $tata_batas = RktTanam::model()->getTotalPersen($modelTataBatas->search()->getData(), 'persentase');

        if ($tata_batas > 50) {
            $model->aspek_1 = 14;
        } elseif ($tata_batas >= 1 && $tata_batas <= 50) {
            $model->aspek_1 = 13;
        } else {
            $model->aspek_1 = 12;
        }

        $status_batas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if($status_batas){
            if($status_batas->status==1){
                $model->aspek_1 = 1;
            }elseif ($status_batas->status==2) {
                $model->aspek_1 = 2;
            }  else {
                $model->aspek_1 = 3;
            }
        }else{
            $p_tb = new ProgresTataBatas;
            $p_tb->id_rkt = $rkt->id;
            $p_tb->status = 1;
            $p_tb->save();
            $model->aspek_1 = 1;
        }
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

        //cek tata batas
        $modelTataBatas = new RktTataBatas;
        $modelTataBatas->unsetAttributes();
        $modelTataBatas->id_rkt = $rkt->id;

        $tata_batas = RktTanam::model()->getTotalPersen($modelTataBatas->search()->getData(), 'persentase');

        if ($tata_batas > 50) {
            $model->aspek_1 = 14;
        } elseif ($tata_batas >= 1 && $tata_batas <= 50) {
            $model->aspek_1 = 13;
        } else {
            $model->aspek_1 = 12;
        }

        $status_batas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if($status_batas){
            if($status_batas->status==1){
                $model->aspek_1 = 1;
            }elseif ($status_batas->status==2) {
                $model->aspek_1 = 2;
            }  else {
                $model->aspek_1 = 3;
            }
        }else{
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
