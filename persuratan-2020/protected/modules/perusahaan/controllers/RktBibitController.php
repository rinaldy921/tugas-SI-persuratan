<?php

class RktBibitController extends Controller {

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

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'inputJumlahBibit',
                    'inputJumlahSiapLahan',
                    'inputJumlahTanam',
                    'inputJumlahSulam',
                    'inputJumlahJarang',
                    'inputJumlahDangir',
                    'inputJumlahPanenAreal',
                    'inputJumlahPanenTanaman',
                    'inputJumlahPanenSiapLahan',
                    'inputJumlahPasar',
                    'inputJumlahNonKayu',
                    'formNonKayu',
                    'deleteDeleteNonKayu',
                    'formAlasanTanam',
                    'formRKTnotRelated',
					'showAlasan',
                ),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array(Yii::app()->user->perusahaanRole()),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new RktBibit;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['RktBibit'])) {
            $model->attributes = $_POST['RktBibit'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['RktBibit'])) {
            $model->attributes = $_POST['RktBibit'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    public function actionFormRKTTanamByRKU() {
                
    }
    
    public function actionFormAlasanTanam()
    {
        $model = new RktTanamRkuNotrelated;
        if (isset($_POST['RktTanamRkuNotrelated'])) {
            $model->attributes = $_POST['RktTanamRkuNotrelated'];
            $file_error = 0;
            $msg        = "";
            $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
            $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
            $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
            $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
            if (!is_dir($ngepath)) {
                mkdir($ngepath, 0777, true);
            }

            if ($_FILES["pdf_alasan"]["error"] == 0) {
                $file1 = CUploadedFile::getInstanceByName('pdf_alasan');
                $ran = rand();
                $ext = $file1->getExtensionName();
                $realName = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "ARKT_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name4 = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file1) && strtolower($ext) == "pdf") {
                    $file1->saveAs($name4);
                    $model->file = $new_path;
                } else {
                    $file_error++;
                    $msg = "File harus PDF";
                }
            }

            if($file_error == 0) {
                if ($model->save()) {
                    $_SESSION['id_alasan_rkt'] = $model->id;
                    $data = array(
                        'header' => "Sukses",
                        'message'=> "Data Berhasil Disimpan",
                        'status' => "success",
                        'id'     => $model->id
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        'message'=> "Data Gagal Disimpan",
                        'status' => "error",
                        'id'     => 0
                    );
                }
            } else {
                $data = array(
                    'header' => "Gagal Menyimpan Data",
                    'message'=> $msg,
                    'status' => "information",
                    'id'     => 0
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_alasan_tanam', array(
            'model' => $model,
        ));
    }

    public function actionFormRKTnotRelated()
    {
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku, 'order' => 'tahun_mulai DESC'));
        $bloksektor = BlokSektor::model()->findAll(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku));

        $model = new RktTanam;
        if (isset($_POST['RktTanam'])) {
            // echo "<pre>";
            // print_r($_POST);
            // die();

            $model->attributes = $_POST['RktTanam'];
            $model->id_rkt     = $_GET['id_rkt'];
            $model->rku_related     = 0;

            if ($model->save()) {
                $id_rkt_tanam = $model->id;
                $modelAlasan = RktTanamRkuNotrelated::model()->findByPk($_SESSION['id_alasan_rkt']);
                $modelAlasan->id_rkt_tanam = $id_rkt_tanam;
                $modelAlasan->save(false);

                $_SESSION['id_alasan_rkt'] = 0;

                $data = array(
                    'header' => "Sukses",
                    'message'=> "Data Berhasil Disimpan",
                    'status' => "success"
                );
            } else {
                $data = array(
                    'header' => "Error",
                    'message'=> "Data Gagal Disimpan",
                    'status' => "error",
                    'id'     => 0
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_rkt_tanam_not_related', array(
            'model' => $model,
            'rku'   => $rku,
            'rkt'   => $rkt,
            'bloksektor' => $bloksektor
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku, 'order' => 'tahun_mulai DESC'));
        // echo "<pre>";
        // var_dump($rkt->id_rku);
        // die();
        if (!isset($rkt)) {
            $message = Yii::t('app', 'Data RKT belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
        }
//        $tahun = $rkt->tahun_mulai;
        $tahun = $rkt->rkt_ke;
        
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND status = 1 AND rkt_ke = ' . $_POST['Rkt']['tahun_mulai'] . ' AND id_rku = ' . $rku->id_rku, 'order' => 'tahun_mulai DESC'));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT rkt_ke ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rkt/index'));
            }
//            $tahun = $rkt->tahun_mulai;
            $tahun = $rkt->rkt_ke;
            
        }
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['aksi']) && $_GET['aksi'] === 'updateGrid') {
                $tahun = $_GET['tahun'];
                $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND status = 1 AND tahun_mulai = ' . $tahun . ' AND id_rku = ' . $rku->id_rku, 'order' => 'tahun_mulai DESC'));
                //$tahun = $tahun;
                $tahun = $rkt->rkt_ke;
                
            }
           
        }       
       

        if (isset($rkt)) {
            $j_tanaman = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
            if (empty($j_tanaman)) {
                $message = Yii::t('app', 'Silahkan isi jenis tanaman terlebih dahulu.');
                Yii::app()->user->setFlash('error', $message);
                $this->redirect(array('//perusahaan/rkuSilvikultur/create/', 'tab' => '2'));
            }
            $idRkt = $rkt->id;
            $rkuTanSil = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
            $rkuHHBKSil = RkuHasilHutanNonkayuSilvikultur::model()->findAll(array('condition' => 'id_rku=' . $rku->id_rku));

            $rkuBibit = RkuBibitNew::model()->findAll(array(
                'condition'=>'id_rku='.$rku->id_rku.' AND tahun='.$tahun.' AND (jumlah != NULL OR jumlah != 0)'
            ));
            $all_id_rku_bibit = "";
            foreach ($rkuBibit as $kb => $vb) {
                $all_id_rku_bibit .= $vb['id_tanaman_silvikultur'];
                if($kb < count($rkuBibit)-1) $all_id_rku_bibit .= ",";
            }
            if(empty($rkuBibit)) $all_id_rku_bibit = 0;

            $modelBibit = new RktBibit;
            $modelBibit->unsetAttributes();
            
            if (isset($_GET['RktBibit']))
                $modelBibit->attributes = $_GET['RktBibit'];
            //$modelBibit->id_rkt    = $rkt->id;
            //$modelBibit->id_tansil = $all_id_rku_bibit;
            // var_dump($tahun);
            // var_dump($rku->id_rku);

            if (Yii::app()->request->isAjaxRequest && isset($_GET['aksi']) && $_GET['aksi'] === 'filterSektorRktSiapLahan' && $_GET['sektor'] != 0) {
                $sektor = $_GET['sektor'];
                $c = new CDbCriteria();
                // $c->distinct=true;
                $c->condition = "id_sektor = " . $sektor . ' AND id_rku = ' . $rku->id_rku;
                $c->select = 'id';
                $rb = BlokSektor::model()->findAll($c);
                $idb = [];
                foreach ($rb as $kb => $vb) {
                    $idb[] = $vb['id'];
                }
                $modelSiapLahan = new RktSiapLahan;
                // $modelSiapLahan->with('MasterJenisLahan');
                $modelSiapLahan->unsetAttributes();
                if (isset($_GET['RktSiapLahan']))
                    $modelSiapLahan->attributes = $_GET['RktSiapLahan'];
                $modelSiapLahan->id_rkt = $rkt->id;
                $modelSiapLahan->id_blok = $idb;
                $modelSiapLahan->jumlah_not_null  = true;
            } else {
                $modelSiapLahan = new RktSiapLahan;
                $modelSiapLahan->unsetAttributes();
                if (isset($_GET['RktSiapLahan']))
                    $modelSiapLahan->attributes = $_GET['RktSiapLahan'];
                $modelSiapLahan->id_rkt = $rkt->id;
                $modelSiapLahan->id_rkt = $rkt->id;
            }

            if (Yii::app()->request->isAjaxRequest && isset($_GET['aksi']) && $_GET['aksi'] === 'filterSektorpanenareal' && $_GET['sektor'] != 0) {
                $sektor = $_GET['sektor'];
                $c = new CDbCriteria();
                // $c->distinct=true;
                $c->condition = "id_sektor = " . $sektor . ' AND id_rku = ' . $rku->id_rku;
                $c->select = 'id';
                $rb = BlokSektor::model()->findAll($c);
                $idb = [];
                foreach ($rb as $kb => $vb) {
                    $idb[] = $vb['id'];
                }
                $modelPanenAreal = new RktPanenAreal;
                $modelPanenAreal->unsetAttributes();
                if (isset($_GET['RktPanenAreal']))
                    $modelPanenAreal->attributes = $_GET['RktPanenAreal'];
                $modelPanenAreal->id_rkt = $rkt->id;
                $modelPanenAreal->id_blok = $idb;
            } else {
                $modelPanenAreal = new RktPanenAreal;
                $modelPanenAreal->unsetAttributes();
                if (isset($_GET['RktPanenAreal']))
                    $modelPanenAreal->attributes = $_GET['RktPanenAreal'];
                $modelPanenAreal->id_rkt = $rkt->id;
            }

            //
            if (Yii::app()->request->isAjaxRequest && isset($_GET['aksi']) && $_GET['aksi'] === 'panenvolumetanaman' && $_GET['sektor'] != 0) {
                $sektor = $_GET['sektor'];
                $c = new CDbCriteria();
                // $c->distinct=true;
                $c->condition = "id_sektor = " . $sektor . ' AND id_rku = ' . $rku->id_rku;
                $c->select = 'id';
                $rb = BlokSektor::model()->findAll($c);
                $idb = [];
                foreach ($rb as $kb => $vb) {
                    $idb[] = $vb['id'];
                }
                $modelPanenTanaman = new RktPanenVolumeTanaman;
                $modelPanenTanaman->unsetAttributes();
                if (isset($_GET['RktPanenVolumeTanaman']))
                    $modelPanenTanaman->attributes = $_GET['RktPanenVolumeTanaman'];
                $modelPanenTanaman->id_rkt = $rkt->id;
                $modelPanenTanaman->id_blok = $idb;
            } else {
                $modelPanenTanaman = new RktPanenVolumeTanaman;
                $modelPanenTanaman->unsetAttributes();
                if (isset($_GET['RktPanenVolumeTanaman']))
                    $modelPanenTanaman->attributes = $_GET['RktPanenVolumeTanaman'];
                $modelPanenTanaman->id_rkt = $rkt->id;
            }


            $modelPanenSiapLahan = new RktPanenVolumeSiapLahan;
            $modelPanenSiapLahan->unsetAttributes();
            if (isset($_GET['RktPanenVolumeSiapLahan']))
                $modelPanenSiapLahan->attributes = $_GET['RktPanenVolumeSiapLahan'];
            $modelPanenSiapLahan->id_rkt = $rkt->id;
            // echo $rkt->id;
         


            // echo "ID RKU = ".$rku->id_rku;
            // echo "<br> ID RKT = ".$rkt->id;
            // echo "<br> Tahun = ".$tahun;
            $cariRkuTanam = RkuTanam::model()->findAll(array(
                'condition' => 'id_rku='.$rku->id_rku.' AND tahun='.$tahun.' AND (jumlah != NULL OR jumlah != 0)'
            ));
            $all_id_rku_tanam = array();
            $i = 0;
            
            if (Yii::app()->request->isAjaxRequest && isset($_GET['aksi']) && $_GET['aksi'] === 'filterSektor' && $_GET['sektor'] != 0) {
                $sektor = $_GET['sektor'];
                $c = new CDbCriteria();
                $c->condition = "id_sektor = " . $sektor . ' AND id_rku = ' . $rku->id_rku;
                $c->select = 'id';
                $rb = BlokSektor::model()->findAll($c);
                $idb = [];
                foreach ($rb as $kb => $vb) {
                    $idb[] = $vb['id'];
                }
                $modelTanam = new RktTanam;
                // $modelTanam->with('MasterJenisLahan');
                $modelTanam->unsetAttributes();
                if (isset($_GET['RktTanam']))
                    $modelTanam->attributes = $_GET['RktTanam'];
                $modelTanam->id_rkt = $rkt->id;
                $modelTanam->id_blok = $idb;
                //$modelTanam->in_id   = $all_id;
            } else {
                $modelTanam = new RktTanam;
                $modelTanam->unsetAttributes();
                if (isset($_GET['RktTanam']))
                    $modelTanam->attributes = $_GET['RktTanam'];
                    $modelTanam->id_rkt = $rkt->id;
                    //$modelTanam->in_id   = $all_id;

            }
            //echo $rkt->id;
           

            
        
            
            
        }

        $this->render('index', array(
            'rku'   => $rku,
            'rkt' => $rkt,
            'tahun' => $tahun,
            'modelBibit' => $modelBibit,
            'modelSiapLahan' => $modelSiapLahan,
            'modelTanam' => $modelTanam,
            'modelSulam' => $modelSulam,
            'modelJarang' => $modelJarang,
            'modelDangir' => $modelDangir,
            'modelPanenAreal' => $modelPanenAreal,
            'modelPanenTanaman' => $modelPanenTanaman,
            'modelPanenSiapLahan' => $modelPanenSiapLahan,
            'modelPasar' => $modelPasar,
            'modelNonKayu' => $modelNonKayu
        ));
    }
    
    public function actionformByRKUPenanaman($param) {
        
    }

    public function actionFormNonKayu($id) {
        //$id = id rkt
        $id_pk = isset($_GET['id_pk']) ? $_GET['id_pk'] : "";
        $id_sil = isset($_GET['id_rkt_sil']) ? $_GET['id_rkt_sil'] : "";
        if ($id_pk != "") {
            $model = RktHasilHutanNonkayu::model()->findByPk($id_pk);
        } else {
            $model = new RktHasilHutanNonkayu;
        }
        $model->id_rkt = $id;

        if (isset($_POST['RktHasilHutanNonkayu'])) {
            if ($id_pk != "") {
                $model = RktHasilHutanNonkayu::model()->findByPk($id_pk);
            } else {
                $model = RktHasilHutanNonkayu::model()->find(array(
                    'condition' => 'id_rkt = '.$id.
                                   // ' AND id_rku_hasil_hutan_nonkayu_silvikultur = '.$id_sil.
                                   ' AND id_jenis_lahan = '.$_POST['RktHasilHutanNonkayu']['id_jenis_lahan'].
                                   ' AND id_jenis_produksi_lahan = '.$_POST['RktHasilHutanNonkayu']['id_jenis_produksi_lahan'].
                                   ' AND id_blok = '.$_POST['RktHasilHutanNonkayu']['id_blok'] .
                                   ' AND id_hasil_hutan_nonkayu = '.$_POST['RktHasilHutanNonkayu']['id_hasil_hutan_nonkayu'].
                                   ' AND id_satuan_volume_nonkayu = '.$_POST['RktHasilHutanNonkayu']['id_satuan_volume_nonkayu']
                ));
            }

            if(!empty($model)) {
                // $model->id_ = $_POST['RktHasilHutanNonkayu']['jumlah'];
                $model->jumlah = $_POST['RktHasilHutanNonkayu']['jumlah'];
                if (!is_null($model->realisasi)) {
                    $model->persentase = ($model->realisasi / $model->jumlah) * 100;
                }
                if ($model->save(false)) {
                    $data = array(
                        'header' => "Success",
                        "message" => "Data berhasil disimpan",
                        'status' => "success",
                    );
                } else {
                    // var_dump($model->errors);
                    $data = array(
                        'header' => "Error",
                        "message" => "Data gagal disimpan",
                        'status' => "error",
                    );
                }
            } else {
                $data = array(
                    'header' => "Error",
                    "message" => "Data RKU Tidak Ditemukan",
                    'status' => "error",
                );
            }
            // $model->attributes = $_POST['RktHasilHutanNonkayu'];



            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_non_kayu', array(
            'model' => $model,
            'id_pk' => $id_pk
        ));
    }

    public function actionDeleteDeleteNonKayu($id) {
        $mdoel2 = RealisasiRktHasilHutanNonkayu::model()->findAllByAttributes(['id_rkt_hasil_hutan_nonkayu' => $id]);
        foreach ($mdoel2 as $key => $value) {
            $del = RealisasiRktHasilHutanNonkayu::model()->findByPk($value->id)->delete();
        }
        $model = RktHasilHutanNonkayu::model()->findByPk($id);
        $model->jumlah = null;
        $model->realisasi = null;
        $model->persentase = null;
        $model->save();
    }

    public function actionInputJumlahNonKayu() {
        $post = $_POST['pk'];
        $md = RktHasilHutanNonkayu::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktHasilHutanNonkayu');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktHasilHutanNonkayu::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahBibit() {
        $post = $_POST['pk'];
        $md = RktBibit::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktBibit');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktBibit::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahSiapLahan() {
        $post = $_POST['pk'];
        $md = RktSiapLahan::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktSiapLahan');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktSiapLahan::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahTanam() {
        $post = $_POST['pk'];
        $md = RktTanam::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktTanam');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktTanam::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahSulam() {
        $post = $_POST['pk'];
        $md = RktSulam::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktSulam');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktSulam::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahJarang() {
        $post = $_POST['pk'];
        $md = RktJarang::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktJarang');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktJarang::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahDangir() {
        $post = $_POST['pk'];
        $md = RktDangir::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktDangir');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktDangir::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahPanenAreal() {
        $post = $_POST['pk'];
        $md = RktPanenAreal::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPanenAreal');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktPanenAreal::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahPanenTanaman() {
        $post = $_POST['pk'];
        $md = RktPanenVolumeTanaman::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPanenVolumeTanaman');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktPanenVolumeTanaman::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahPanenSiapLahan() {
        $post = $_POST['pk'];
        $md = RktPanenVolumeSiapLahan::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPanenVolumeSiapLahan');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktPanenVolumeSiapLahan::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahPasar() {
        $post = $_POST['pk'];
        $md = RktPasar::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPasar');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // }
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktPasar::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RktBibit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rkt-bibit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
	
    public function actionShowAlasan($id,$model) {
       
//	    $data = $model::model()->findByPk($id);
//		$id_rkt_form_alasan = $data->id_rkt_form_alasan;
	   
	    //$alasan = RktFormAlasan::model()->findAllByAttributes(array('id'=>$id_rkt_form_alasan));
		$alasan = RktFormAlasan::model()->findByPk($id);

        $cs = Yii::app()->clientScript;
        $cs->reset();
        $cs->scriptMap = array(
            'jquery.js' => false, // prevent produce jquery.js in additional javascript data
            'jquery.min.js' => false,
        );

//        debug($alasan->idBlok->nama_blok); die;
        
        $this->renderPartial('showAlasan', array(
            'alasan' => $alasan,
                //'model2' => $model2,
                ), false, true); // bagian ini biasanaya yang perlu di perhatikan saat render partial ajax
    }

}
