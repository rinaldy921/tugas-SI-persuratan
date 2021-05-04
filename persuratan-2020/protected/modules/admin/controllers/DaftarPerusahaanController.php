<?php

class DaftarPerusahaanController extends Controller {

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
                'actions' => array('index', 'view', 'data','formCabutIjin','cabutijin'),
                'users' => array(Yii::app()->user->adminRole(),),
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
    public function actionView($id) {
        $perusahaan = Perusahaan::model()->findByPk($id);
        // $cabang = PerusahaanCabang::model()->findAll(array(
        //     'condition' => 'perusahaan_id=' . $id
        // ));
        // $cabang = !empty($cabang) ? $cabang : new PerusahaanCabang;
        $cabang = new PerusahaanCabang('search');
        $cabang->unsetAttributes();
        $cabang->perusahaan_id = $id;

        $modelLegalitas = new LegalitasPerusahaan('search');
        $modelLegalitas->unsetAttributes();
        $modelLegalitas->perusahaan_id = $id;

        $permodalan = Permodalan::model()->find(array('condition' => 'id_perusahaan = ' . $id));
        if (empty($permodalan))
            $permodalan = array();

        $modelSaham = new Saham('search');
        $modelSaham->unsetAttributes();
        $modelSaham->id_perusahaan = $id;

        $modelDireksi = new Direksi('search');
        $modelDireksi->unsetAttributes();
        $modelDireksi->perusahaan_id = $id;

        $modelKomisaris = new Komisaris('search');
        $modelKomisaris->unsetAttributes();
        $modelKomisaris->perusahaan_id = $id;

        $modelTeknis = TenagaKerja::model()->find(array(
            'condition' => 'perusahaan_id=' . $id . ' AND kategori="Teknis"'
        ));
        if (empty($modelTeknis))
            $modelTeknis = array();

        $modelNonTeknis = TenagaKerja::model()->find(array(
            'condition' => 'perusahaan_id=' . $id . ' AND kategori="Non Teknis"'
        ));
        if (empty($modelNonTeknis))
            $modelNonTeknis = array();

        $modelPhpl = new SertifikasiPhpl('search');
        $modelPhpl->unsetAttributes();  // clear any default values
        $modelPhpl->id_perusahaan = $id;

        $modelVlk = new SertifikasiVlk('search');
        $modelVlk->unsetAttributes();  // clear any default values
        $modelVlk->id_perusahaan = $id;

        $this->render('view', array(
            'perusahaan' => $perusahaan,
            'cabang' => $cabang,
            'modelLegalitas' => $modelLegalitas,
            'permodalan' => $permodalan,
            'modelSaham' => $modelSaham,
            'modelDireksi' => $modelDireksi,
            'modelKomisaris' => $modelKomisaris,
            'modelTeknis' => $modelTeknis,
            'modelNonTeknis' => $modelNonTeknis,
            'modelPhpl' => $modelPhpl,
            'modelVlk' => $modelVlk
        ));
    }

    public function actionData($id) {
        $iup = Iuphhk::model()->findByPk($id);

        $adendum = new AdendumSk('search');
        $adendum->unsetAttributes();
        $adendum->id_iuphhk = $id;

        $pokhut = new KelompokHutan('search');
        $pokhut->unsetAttributes();
        $pokhut->id_iuphhk = $id;

        $admPemerintahan = new AdmPemerintahan('search');
        $admPemerintahan->unsetAttributes();
        $admPemerintahan->id_iuphhk = $id;

        $admPemangkuan = new AdmPemangkuanHutan('search');
        $admPemangkuan->unsetAttributes();
        $admPemangkuan->id_iuphhk = $id;

        $lahan = KeadaanLahan::model()->with(array('idIuphhk'))->find(array('condition' => 't.id_iuphhk=' . $id));
        $d_lahan = array();
        if ($lahan) {
            $total = $lahan->lahan_kering + $lahan->basah + $lahan->payau;
            $d_lahan[0]['jenis'] = 'Lahan Kering';
            $d_lahan[0]['jml'] = $lahan->lahan_kering;
            $d_lahan[0]['persen'] = ($lahan->lahan_kering != 0) ? Yii::app()->numberFormatter->formatPercentage($lahan->lahan_kering / $total) : "-";

            $d_lahan[1]['jenis'] = 'Basah';
            $d_lahan[1]['jml'] = $lahan->basah;
            $d_lahan[1]['persen'] = ($lahan->basah != 0) ? Yii::app()->numberFormatter->formatPercentage($lahan->basah / $total) : "-";

            $d_lahan[2]['jenis'] = 'Payau';
            $d_lahan[2]['jml'] = $lahan->payau;
            $d_lahan[2]['persen'] = ($lahan->payau != 0) ? Yii::app()->numberFormatter->formatPercentage($lahan->payau / $total) : "-";
        }

        $keadaan_lahan = new CArrayDataProvider($d_lahan, array(
            'keyField' => 'jenis',
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));

        $topografi = Topografi::model()->with(array('idIuphhk'))->find(array('condition' => 't.id_iuphhk=' . $id));
        if (empty($topografi))
            $topografi = new Topografi;

//        Data Laporan
        $aspek = Aspek::model()->findAll();
        $no = 0;
        foreach ($aspek as $value) {
            $i = $no;
            $data[$i]['aspek'] = $value->nama_aspek;
            $data[$i]['bobot'] = $value->bobot;
            $no++;
        }

        $rku = Rku::model()->find(array(
            'condition' => 'status=1 AND id_perusahaan=' . $iup->id_perusahaan
        ));
        $id_rku = !empty($rku) ? $rku->id_rku : 0;
        $rkt = Rkt::model()->find(array(
            'condition' => 'status=1 AND id_perusahaan=' . $iup->id_perusahaan
        ));
        $id_rkt = !empty($rkt) ? $rkt->id : 0;
        $kinerja = PenilaianKinerja::model()->find(array(
            'condition' => 'id_rkt=' . $id_rkt . ' AND id_rku=' . $id_rku . ' AND id_perusahaan=' . $iup->id_perusahaan
        ));
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

        $this->render('data', array(
            'iup' => $iup,
            'adendum' => $adendum,
            'pokhut' => $pokhut,
            'rku' => $rku,
            'rkt' => $rkt,
            'laporan' => $laporan,
            'admPemerintahan' => $admPemerintahan,
            'admPemangkuan' => $admPemangkuan,
            'keadaan_lahan' => $keadaan_lahan,
            'topografi' => $topografi
        ));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        // debug(Yii::app()->user->type);
        // debug(Yii::app()->user->id_bphp);
        $model = new Perusahaan('searchByIupkhh');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Perusahaan']))
            $model->attributes = $_GET['Perusahaan'];

        $result = $model->searchByIupkhh();
        
        
        
//        print_r($result);
//        die();
        
        $this->render('index', array(
            'model' => $result,
        ));
    }

    public function actionFormcabutijin($id)
    {
        $model = $this->loadModel($id);

        $this->renderPartial('_form_cabut_ijin', array(
            'model' => $model
        ));
    }

    public function actionCabutijin($id)
    {
        $model = $this->loadModel($id);
        $model->is_dicabut = 1;
        $model->no_sk_pencabutan = $_POST['Iuphhk']['no_sk_pencabutan'];
        $model->tgl_dicabut = $_POST['Iuphhk']['tgl_dicabut'];
        $model->keterangan_dicabut = $_POST['Iuphhk']['keterangan_dicabut'];
        if($model->save()) {
            $data = array(
                'header' => "Sukses",
                'message' => "Ijin Berhasil Dicabut",
                'status' => "success"
            );
        } else {
            $data = array(
                'header' => "Error",
                'message' => "Ijin Gagal Dicabut",
                'status' => "error"
            );
        }
        echo json_encode($data);
        die();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Iuphhk::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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

//    public function getTotal($records){
//        $tottal = 0;
//        foreach ($records as $rec)
//            $total+=$rec->[$colName];
//        return Yii::app()->numberFormatter->formatDecimal($total);
//
//    }
}
