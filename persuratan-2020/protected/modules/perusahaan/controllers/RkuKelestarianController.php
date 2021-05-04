<?php

class RkuKelestarianController extends Controller {

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
            array('allow',
                'actions' => array('index',
                    'inputPasar',
                    'deletePasar',
                    'inputPanen',
                    'inputHhbk',
                    'deletePanen',
                    'inputRktKePenanaman',
                    'inputRktKePanen',
                    'inputRktKePasar',
                    'inputPenanaman',
                    'inputPemeliharaan',
                    'inputRktKePeliharaan',
                    'deletePemeliharaan',
                    'inputRktKeHhbk',
                    'deletePenanaman',
                    'inputPembibitan',
                    'inputRktKePembibitan',
                    'inputSiapLahan',
                    'deleteBibit',
                    'deleteSiapLahan',
                    'addHhbk',
                    'inputRktKeSiapLahan',
                    'addPasarHhbk',
                    'deleteHhbk',
                    'addPenanaman',
                    'addPemasaran',
                    'inputRktKePasarHhbk',
                    'addPembibitan',
                    'addPemeliharaan',
                    'formSiapLahan',
                    'getPembibitan',
                    'addPanenKayu',
                    'deleteData',
                    'addSiapLahan',
                    'inputPasarHhbk',
                ),
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
        $model = new RkuBibit;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['RkuBibit'])) {
            $model->attributes = $_POST['RkuBibit'];
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

        if (isset($_POST['RkuBibit'])) {
            $model->attributes = $_POST['RkuBibit'];
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteBibit($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuBibit::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteSiapLahan($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuSiapLahan::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePenanaman($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuTanam::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePemeliharaan($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuPelihara::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePanen($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuPanen::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePasar($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuPasar::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actiondeleteHhbk($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuHasilHutanNonkayu::model()->findByPk($id)->delete();

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
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        //$rku = Yii::app()->session['rku_id'];
        // = Rku::model()->findByPk(Yii::app()->session['rku_id']);
        
        
        if (!isset($rku)) {
            #die("WKWKWKWK");
            $message = Yii::t('app', 'Silahkan isi RKU terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/index'));
        }
        if (isset($_POST['Rku'])) {
            #die("WKWKWKWK");
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND tahun_mulai = ' . $periode[0]));
            #debug($rku);
            #exit();
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rku/index'));
            }
        }

        // echo $rku->id_rku;
//      Pembibitan
        $bloksektor = RkuBlok::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
        $modelBibit = RkuBibit::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
        $j_tanaman = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
        $j_hhbk = RkuHasilHutanNonkayuSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
                        
        $bibit = new RkuBibit('search');
        $bibit->unsetAttributes();  // clear any default values
        $bibit->attributes = array(
            'id_rku' => $rku->id_rku
        );

        $siapLahan = new RkuPenyiapanLahan('search');
        $siapLahan->unsetAttributes();  
        $siapLahan->attributes = array(
            'id_rku' => $rku->id_rku
        );
        
        if (Yii::app()->request->isAjaxRequest && isset($_GET['aksi']) && $_GET['aksi'] === 'filterTahun' && $_GET['tahun'] != 0) {
            $penanaman = new RkuTanam('search');
            $penanaman->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuTanam']))
                $penanaman->attributes = $_GET['RkuTanam'];
            $penanaman->id_rku = $rku->id_rku;
            $penanaman->tahun = $_GET['tahun'];
        } else {
            $penanaman = new RkuTanam('search');
            $penanaman->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuTanam']))
                $penanaman->attributes = $_GET['RkuTanam'];
            $penanaman->id_rku = $rku->id_rku;
            //$penanaman->jumlah_not_null = true;
            //echo $rku->id_rku;
        }

        $pemeliharaan = new RkuPelihara('search');
        $pemeliharaan->unsetAttributes();  // clear any default values
        $pemeliharaan->attributes = array(
            'id_rku' => $rku->id_rku
        );

//      Pemanenan
        /*
        $modelPanen = RkuPanen::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
        
        if (empty($modelPanen)) {
            if ($j_tanaman) {
                $this->addPemanenan($j_tanaman, $rku);
            } else {
                $message = Yii::t('app', 'Silahkan isi pilih jenis tanaman terlebih dahulu.');
                Yii::app()->user->setFlash('error', $message);
                $this->redirect(array('//perusahaan/rkuSilvikultur/index'));
            }
        } else {
            $this->updatePemanenan($j_tanaman, $rku);
        }
        */
        
        $panen = new RkuPanen('search');
        $panen->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuPanen']))
            $panen->attributes = $_GET['RkuPanen'];
        $panen->id_rku = $rku->id_rku;

        //HHBK
        // $modelHHBK = RkuHasilHutanNonkayu::model()->findAll(array('condition' => 'id_rku=' . $rku->id_rku));
        // if (empty($modelHHBK)) {
        //     if ($j_hhbk) {
        //         $this->addHHBK($j_hhbk, $rku);
        //     } else {
        //         $message = Yii::t('app', 'Silahkan isi pilih jenis HHBK terlebih dahulu.');
        //         #Yii::app()->user->setFlash('error', $message);
        //         #$this->redirect(array('//perusahaan/rkuSilvikultur/index'));
        //     }
        // } else {
        //     $this->updateHHBK($j_hhbk, $rku);
        // }

        $hhbk = new RkuHasilHutanNonkayu('search');
        $hhbk->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuHasilHutanNonkayu'])){
            $hhbk->attributes = $_GET['RkuHasilHutanNonkayu'];
             $hhbk->id_rku = $rku->id_rku;
        }
        else{
            $hhbk->id_rku = $rku->id_rku;
            $hhbk->jumlah_not_null = true;
        }
        
        
//        print_r("<pre>");
//        print_r($_GET['RkuHasilHutanNonkayu']);
//        print_r("<pre>"); exit(1);
        
//      Pemasaran
        /*
        $modelPasar = RkuPasar::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
        $j_tanaman_pasar = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku, 'group' => 'id_jenis_tanaman'));
        $j_pasar = MasterJenisPemasaran::model()->findAll();

        if (empty($modelPasar)) {
            if ($j_tanaman_pasar) {
                $this->addPemasaran($j_tanaman_pasar, $rku, $j_pasar);
            } else {
                $message = Yii::t('app', 'Silahkan isi pilih jenis tanaman terlebih dahulu.');
                Yii::app()->user->setFlash('error', $message);
                $this->redirect(array('//perusahaan/rkuSilvikultur/index'));
            }
        } else {
            $this->updatePemasaran($j_tanaman_pasar, $rku, $j_pasar);
        }
         * 
         */

        $pasar = new RkuPasar('search');
        $pasar->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuPasar']))
            $pasar->attributes = $_GET['RkuPasar'];
        $pasar->id_rku = $rku->id_rku;


        $pasarhhbk = new RkuPasarHhbk('search');
        $pasarhhbk->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuPasarHhbk']))
            $pasarhhbk->attributes = $_GET['RkuPasarHhbk'];
        $pasarhhbk->id_rku = $rku->id_rku;
        $pasarhhbk->jumlah_not_null = true;

        $this->render('index', array(
            'rku' => $rku,
            'bibit' => $bibit,
            'siapLahan' => $siapLahan,
            'penanaman' => $penanaman,
            'pemeliharaan' => $pemeliharaan,
            'panen' => $panen,
            'pasar' => $pasar,
            'hhbk' => $hhbk,
            'pasarhhbk' => $pasarhhbk,
        ));
    }
	
	
	public function actionDeleteData($id,$modelClass) {
        if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request
            $this->loadModelData($id,$modelClass)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
	
	public function loadModelData($id,$modelClass) {
        $model = $modelClass::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
	
    public function actionAddSiapLahan($id_rku, $id_siaplahan) {
        //debug($_POST);
        //die("test");
        if ($id_siaplahan != "") {
            $model = RkuPenyiapanLahan::model()->findByPk($id_siaplahan);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuPenyiapanLahan;
        }

        if (isset($_POST['RkuPenyiapanLahan'])) {
          

            if ($id_siaplahan != "") {
                $model = RkuPenyiapanLahan::model()->findByPk($id_siaplahan);
                $model->attributes = $_POST['RkuPenyiapanLahan'];
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuPenyiapanLahan'];                               
            }

            if (!empty($model)) {
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_tanam_siap_lahan', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_siaplahan' => $id_siaplahan
        ));
    }

//    public function actionFormSiapLahan($id_rku, $id_siaplahan) {
//        
//        //debug($_POST);
//        if ($id_tanam != "") {
//            $model = RkuPenyiapanLahan::model()->findByPk($id_siaplahan);
//            $id_rku = $model->id_rku;
//        } else {
//            $model = new RkuPenyiapanLahan;
//        }
//
//        if (isset($_POST['RkuPenyiapanLahan'])) {
//          
//
//            if ($id_siaplahan != "") {
//                $model = RkuPenyiapanLahan::model()->findByPk($id_siaplahan);
//                $model->attributes = $_POST['RkuPenyiapanLahan'];  
//            } else {
//                $model->id_rku = $id_rku;
//                $model->attributes = $_POST['RkuPenyiapanLahan'];                               
//            }
//
//            if (!empty($model)) {
//                if ($model->save()) {
//                    $data = array(
//                        'header' => "Sukses",
//                        "message" => "Data Berhasil Disimpan",
//                        'status' => "success"
//                    );
//                } else {
//                    $data = array(
//                        'header' => "Error",
//                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
//                        'status' => "warning"
//                    );
//                }
//            } else {
//                $data = array(
//                    'header' => "Warning",
//                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
//                    'status' => "warning"
//                );
//            }
//
//            echo json_encode($data);
//            die();
//        }
        
//        $this->renderPartial('_form_tanam_siap_lahan', array(
//            'model' => $model,
//            'id_rku' => $id_rku,
//            'id_siaplahan' => $id_siaplahan
//        ));
//    }
    
    public function actionFormSiapLahan2($id_rku, $id_siaplahan) {
        if ($id_siaplahan != "") {
            $model = RkuPenyiapanLahan::model()->findByPk($id_siaplahan);
        } else {
            $model = new RkuPenyiapanLahan;
        }

        if (isset($_POST['RkuPenyiapanLahan'])) {
            $id_tanam_sil = $_POST['RkuPenyiapanLahan']['id_jenis_produksi_lahan'];
            $id_jenis_lahan = $_POST['RkuPenyiapanLahan']['id_jenis_lahan'];
            $tahun = $_POST['RkuPenyiapanLahan']['tahun'];
            $jumlah = $_POST['RkuPenyiapanLahan']['jumlah'];

            if ($id_siaplahan != "") {
                $model = RkuPenyiapanLahan::model()->findByPk($id_siaplahan);
            } else {
                $model = RkuPenyiapanLahan::model()->find(array(
                    'condition' => 'tahun = "' . $tahun . '" AND id_rku = "' . $id_rku . '" AND id_jenis_lahan=' . $id_jenis_lahan . " AND id_jenis_produksi_lahan=" . $id_tanam_sil
                ));
            }

            if (!empty($model)) {
                $model->daur = $_POST['RkuPenyiapanLahan']['daur'];
                $model->jumlah = $jumlah;
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_tanam_siap_lahan', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_siaplahan' => $id_siaplahan
        ));
    }
    
  
    
    public function actionAddPembibitan($id_rku, $id_bibit) {
        //debug($_POST);
        //die("test");
        if ($id_bibit != "") {
            $model = RkuBibit::model()->findByPk($id_bibit);
            $id_rku = $model->id_rku;
        
            if($model->save()){
                
            }
        } else {
            $model = new RkuBibit;
        }

        if (isset($_POST['RkuBibit'])) {
          

            if ($id_bibit != "") {
                $model = RkuBibit::model()->findByPk($id_bibit);
                $model->attributes = $_POST['RkuBibit']; 
                $model->attributes = $_POST['RkuBibit'];     
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuBibit'];                               
            }

            if (!empty($model)) {
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_bibit', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_bibit' => $id_bibit
        ));
    }

    public function actionAddPemeliharaan($id_rku, $id_pemeliharaan) {
        //debug($_POST);
        //die("test");
        if ($id_pemeliharaan != "") {
            $model = RkuPelihara::model()->findByPk($id_pemeliharaan);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuPelihara;
        }

        if (isset($_POST['RkuPelihara'])) {
          

            if ($id_pemeliharaan != "") {
                $model = RkuPelihara::model()->findByPk($id_pemeliharaan);
                $model->attributes = $_POST['RkuPelihara']; 
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuPelihara'];                               
            }

            if (!empty($model)) {
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_pemeliharaan', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_pemeliharaan' => $id_pemeliharaan
        ));
    }
    
    public function actionAddPanenKayu($id_rku, $id_panen) {
        if ($id_panen != "") {
            $model = RkuPanen::model()->findByPk($id_panen);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuPanen();
        }

        if (isset($_POST['RkuPanen'])) {
          

            if ($id_panen != "") {
                $model = RkuPanen::model()->findByPk($id_panen);
                $model->attributes = $_POST['RkuPanen']; 
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuPanen'];                               
            }

            if (!empty($model)) {
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_panen_kayu', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_panen' => $id_panen
        ));        
    }
    
    public function actionAddPemasaran($id_rku, $id_pasar) {
        //debug($_POST);
        //die("test");
        if ($id_pasar != "") {
            $model = RkuPasar::model()->findByPk($id_pasar);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuPasar();
        }

        if (isset($_POST['RkuPasar'])) {
          

            if ($id_tanam != "") {
                $model = RkuPasar::model()->findByPk($id_pasar);
                $model->attributes = $_POST['RkuPasar']; 
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuPasar'];                               
            }

            if (!empty($model)) {
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    debug($model->errors);
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_pemasaran', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_pasar' => $id_pasar
        ));
    }    
    
    public function actionAddPenanaman($id_rku, $id_tanam) {
        //debug($_POST);
        //die("test");
        if ($id_tanam != "") {
            $model = RkuTanam::model()->findByPk($id_tanam);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuTanam;
        }

        if (isset($_POST['RkuTanam'])) {
          

            if ($id_tanam != "") {
                $model = RkuTanam::model()->findByPk($id_tanam);
                $model->attributes = $_POST['RkuTanam'];
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuTanam'];                               
            }

            if (!empty($model)) {
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_tanam', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_tanam' => $id_tanam
        ));
    }

    
    
    
    public function actionAddTumpangsari($id_rku, $id_tanam) {
        //debug($_POST);
        //die("test");
        if ($id_tanam != "") {
            $model = RkuTumpangsari::model()->findByPk($id_tanam);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuTumpangsari;
        }

        if (isset($_POST['RkuTanam'])) {
          

            if ($id_tanam != "") {
                $model = RkuTumpangsari::model()->findByPk($id_tanam);
                $model->attributes = $_POST['RkuTanam'];
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuTanam'];                               
            }

            if (!empty($model)) {
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_tanam', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_tanam' => $id_tanam
        ));
    }
    
    
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RkuBibit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    // public function actionDeleteHhbk($id) {
    //     $model = RkuHasilHutanNonkayu::model()->findByPk($id);
    //     $model->jumlah = null;
    //     $model->save();
    // }

    public function actionAddHhbk($id_rku, $id_hhbk) {
        //debug($_POST);
        //die("test");
        if ($id_hhbk != "") {
            $model = RkuHasilHutanNonkayu::model()->findByPk($id_hhbk);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuHasilHutanNonkayu;
        }


        if (isset($_POST['RkuHasilHutanNonkayu'])) {
            //debug($_POST);
            //$id_hhbk_sil = $_POST['RkuHasilHutanNonkayu']['id_hasil_hutan_nonkayu_silvikultur'];
            //$tahun = $_POST['RkuHasilHutanNonkayu']['tahun'];
            //$luas = $_POST['RkuHasilHutanNonkayu']['luas'];
            //$jumlah = $_POST['RkuHasilHutanNonkayu']['jumlah'];

            if ($id_hhbk != "") {
                $model = RkuHasilHutanNonkayu::model()->findByPk($id_hhbk);
                $model->attributes = $_POST['RkuHasilHutanNonkayu'];
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuHasilHutanNonkayu'];
                //$model = RkuHasilHutanNonkayu::model()->find(array(
                //    'condition' => 'id_hasil_hutan_nonkayu_silvikultur = ' . $id_hhbk_sil . ' AND tahun = "' . $tahun . '" AND id_rku = "' . $id_rku . '"'
                //));
            }

            if (!empty($model)) {
                //$model->jumlah = $jumlah;
                //$model->luas = $luas;
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU HHBK Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_hhbk', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_hhbk' => $id_hhbk
        ));
    }


    public function actionAddPasarHhbk($id_rku, $id_pasar_hhbk="") {
        //debug($_POST);
        //die("test");
        if ($id_pasar_hhbk != "") {
            $model = RkuPasarHhbk::model()->findByPk($id_pasar_hhbk);
            $id_rku = $model->id_rku;
        } else {
            $model = new RkuPasarHhbk;
        }


        if (isset($_POST['RkuPasarHhbk'])) {
            //debug($_POST);
            //$id_hhbk_sil = $_POST['RkuHasilHutanNonkayu']['id_hasil_hutan_nonkayu_silvikultur'];
            //$tahun = $_POST['RkuHasilHutanNonkayu']['tahun'];
            //$luas = $_POST['RkuHasilHutanNonkayu']['luas'];
            //$jumlah = $_POST['RkuHasilHutanNonkayu']['jumlah'];

            if ($id_pasar_hhbk != "") {
                $model = RkuPasarHhbk::model()->findByPk($id_pasar_hhbk);
                $model->attributes = $_POST['RkuPasarHhbk'];
            } else {
                $model->id_rku = $id_rku;
                $model->attributes = $_POST['RkuPasarHhbk'];
                //$model = RkuHasilHutanNonkayu::model()->find(array(
                //    'condition' => 'id_hasil_hutan_nonkayu_silvikultur = ' . $id_hhbk_sil . ' AND tahun = "' . $tahun . '" AND id_rku = "' . $id_rku . '"'
                //));
            }

            if (!empty($model)) {
                //$model->jumlah = $jumlah;
                //$model->luas = $luas;
                if ($model->save()) {
                    $data = array(
                        'header' => "Sukses",
                        "message" => "Data Berhasil Disimpan",
                        'status' => "success"
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Terdapat kesalahan saat menyimpan, harap cek data masukan",
                        'status' => "warning"
                    );
                }
            } else {
                $data = array(
                    'header' => "Warning",
                    "message" => "Data RKU HHBK Silvikultur Tidak Ditemukan",
                    'status' => "warning"
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_pasar_hhbk', array(
            'model' => $model,
            'id_rku' => $id_rku,
            'id_pasar_hhbk' => $id_pasar_hhbk
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rku-bibit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionInputPembibitan() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuBibit');
        $model->update();
    }

    
    public function actionInputRktKePembibitan() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuBibit');
        $model->update();
    }
    
    public function actionInputRktKePenanaman() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuTanam');
        $model->update();
    }

    public function actionInputRktKeSiapLahan() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPenyiapanLahan');
        $model->update();
    }
    
     public function actionInputRktKePeliharaan() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPelihara');
        $model->update();
    }
    
    public function actionInputRktKePanen() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPanen');
        $model->update();
    }
    
     public function actionInputRktKeHhbk() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuHasilHutanNonkayu');
        $model->update();
    }
    
    public function actionInputRktKePasarHhbk() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPasarHhbk');
        $model->update();
    }
    
    public function actionInputRktKePasar() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPasar');
        $model->update();
    }
    
    public function actionInputSiapLahan() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPenyiapanLahan');
        $model->update();
    }

    public function actionInputPenanaman() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuTanam');
        $model->update();
    }

    public function actionInputPemeliharaan() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPelihara');
        $model->update();
    }

    public function actionInputPanen() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPanen');
        $model->update();
    }

    public function actionInputHhbk() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuHasilHutanNonkayu');
        $model->update();
    }

    public function actionInputPasar() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPasar');
        $model->update();
    }

    public function actionInputPasarHhbk() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPasarHhbk');
        $model->update();
    }
    
    protected function addBibit($j_tanaman, $rku) {
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $add_bibit = new RkuBibitNew;
                $add_bibit->id_rku = $rku->id_rku;
                $add_bibit->id_tanaman_silvikultur = $value->id;
                $add_bibit->tahun = $i;
                $add_bibit->save();
            }
        }
    }

    protected function updateBibit($j_tanaman, $rku) {
        $md = RkuBibitNew::model()->findAll(array('condition' => 'tahun < ' . $rku->tahun_mulai . ' OR tahun > ' . $rku->tahun_sampai));
        foreach ($md as $d) {
            $d->delete();
        }
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $cek_bibit = RkuBibitNew::model()->find(array('condition' => 'id_rku = ' . $rku->id_rku . ' AND id_tanaman_silvikultur = ' . $value->id . ' AND tahun = ' . $i));
                if (empty($cek_bibit)) {
                    $add_bibit = new RkuBibitNew;
                    $add_bibit->id_rku = $rku->id_rku;
                    $add_bibit->id_tanaman_silvikultur = $value->id;
                    $add_bibit->tahun = $i;
                    $add_bibit->save();
                }
            }
        }
    }

    protected function addSiapLahan2($j_tanaman, $rku, $j_lahan, $bloksektor) {
        $id_produksi_lahan = [];
        foreach ($j_tanaman as $value) {
            $id_produksi_lahan[] = $value['id_jenis_produksi_lahan'];
        }
        $id_produksi_lahan = array_unique($id_produksi_lahan);
        foreach ($id_produksi_lahan as $key => $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                foreach ($j_lahan as $lahan) {
                    foreach ($bloksektor as $keyblok => $vblok) {
                        $add_penyiapan_lahan = new RkuPenyiapanLahan;
                        $add_penyiapan_lahan->id_rku = $rku->id_rku;
                        $add_penyiapan_lahan->id_jenis_produksi_lahan = $value;
                        $add_penyiapan_lahan->id_jenis_lahan = $lahan->id;
                        $add_penyiapan_lahan->tahun = $i;
                        $add_penyiapan_lahan->id_blok = $vblok->id;
                        $add_penyiapan_lahan->save();
                    }
                }
            }
        }
    }

    protected function updateSiapLahan($j_tanaman, $rku, $j_lahan, $bloksektor) {
        $md = RkuPenyiapanLahan::model()->findAll(array('condition' => 'tahun < ' . $rku->tahun_mulai . ' OR tahun > ' . $rku->tahun_sampai));
        foreach ($md as $d) {
            $d->delete();
        }
        $id_produksi_lahan = [];
        foreach ($j_tanaman as $value) {
            $id_produksi_lahan[] = $value['id_jenis_produksi_lahan'];
        }

        $id_produksi_lahan = array_unique($id_produksi_lahan);
        foreach ($id_produksi_lahan as $key => $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                foreach ($j_lahan as $lahan) {
                    foreach ($bloksektor as $keyblok => $vblok) {
                        $cek_siap_lahan = RkuPenyiapanLahan::model()->find(
                                array(
                                    'condition' => 'id_rku = ' . $rku->id_rku .
                                    ' AND id_jenis_produksi_lahan = ' . $value .
                                    ' AND tahun = ' . $i .
                                    ' AND id_jenis_lahan = ' . $lahan->id .
                                    ' AND id_blok = ' . $vblok->id
                        ));

                        if (empty($cek_siap_lahan)) {
                            $add_penyiapan_lahan = new RkuPenyiapanLahan;
                            $add_penyiapan_lahan->id_rku = $rku->id_rku;
                            $add_penyiapan_lahan->id_jenis_produksi_lahan = $value;
                            $add_penyiapan_lahan->tahun = $i;
                            $add_penyiapan_lahan->id_jenis_lahan = $lahan->id;
                            $add_penyiapan_lahan->save();
                        }
                    }
                }
            }
        }
    }

    protected function addPenanaman($j_tanaman, $rku, $j_lahan, $bloksektor) {
        //die("KWKWKWKWKWK");
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                foreach ($j_lahan as $lahan) {
                    foreach ($bloksektor as $keyblok => $vblok) {
                        $add_penyiapan_lahan = new RkuTanam;
                        $add_penyiapan_lahan->id_rku = $rku->id_rku;
                        //$add_penyiapan_lahan->id_tanaman_silvikultur = $value->id;
                        $add_penyiapan_lahan->tahun = $i;
                        $add_penyiapan_lahan->id_jenis_lahan = $lahan->id;
                        $add_penyiapan_lahan->id_blok = $vblok->id;
                        $add_penyiapan_lahan->save();
                    }
                }
            }
        }
    }

    protected function updatePenanaman($j_tanaman, $rku, $j_lahan, $bloksektor) {
        $md = RkuTanam::model()->findAll(array('condition' => 'tahun < ' . $rku->tahun_mulai . ' OR tahun > ' . $rku->tahun_sampai));
        foreach ($md as $d) {
            $d->delete();
        }
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                foreach ($j_lahan as $lahan) {
                    foreach ($bloksektor as $keyblok => $vblok) {
                        $cek_penanaman = RkuTanam::model()->find(array(
                            'condition' => 'id_rku = ' . $rku->id_rku .
                            //' AND id_tanaman_silvikultur = ' . $value->id .
                            ' AND tahun = ' . $i .
                            ' AND id_jenis_lahan = ' . $lahan->id .
                            ' AND id_blok = ' . $vblok->id
                        ));
                        if (empty($cek_penanaman)) {
                            $model = new RkuTanam;
                            $model->id_rku = $rku->id_rku;
                            //$model->id_tanaman_silvikultur = $value->id;
                            $model->tahun = $i;
                            $model->id_jenis_lahan = $lahan->id;
                            $model->id_blok = $vblok->id;
                            $model->save();
                        }
                    }
                }
            }
        }
    }

    protected function addPemeliharaan($j_tanaman, $rku) {
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $model = new RkuPelihara;
                $model->id_rku = $rku->id_rku;
                $model->id_tanaman_silvikultur = $value->id;
                $model->tahun = $i;
                $model->save();
            }
        }
    }

    protected function updatePemeliharaan($j_tanaman, $rku) {
        $md = RkuPelihara::model()->findAll(array('condition' => 'tahun < ' . $rku->tahun_mulai . ' OR tahun > ' . $rku->tahun_sampai));
        foreach ($md as $d) {
            $d->delete();
        }
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $cek_pemeliharaan = RkuPelihara::model()->find(array('condition' => 'id_rku = ' . $rku->id_rku . ' AND id_tanaman_silvikultur = ' . $value->id . ' AND tahun = ' . $i));
                if (empty($cek_pemeliharaan)) {
                    $model = new RkuPelihara;
                    $model->id_rku = $rku->id_rku;
                    $model->id_tanaman_silvikultur = $value->id;
                    $model->tahun = $i;
                    $model->save();
                }
            }
        }
    }

    protected function addPemanenan($j_tanaman, $rku) {
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $model = new RkuPanen;
                $model->id_rku = $rku->id_rku;
                $model->id_tanaman_silvikultur = $value->id;
                $model->tahun = $i;
                $model->save();
            }
        }
    }

    protected function updatePemanenan($j_tanaman, $rku) {
        $md = RkuPanen::model()->findAll(array('condition' => 'tahun < ' . $rku->tahun_mulai . ' OR tahun > ' . $rku->tahun_sampai));
        foreach ($md as $d) {
            $d->delete();
        }
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $cek_panen = RkuPanen::model()->find(array('condition' => 'id_rku = ' . $rku->id_rku . ' AND id_tanaman_silvikultur = ' . $value->id . ' AND tahun = ' . $i));
                if (empty($cek_panen)) {
                    $model = new RkuPanen;
                    $model->id_rku = $rku->id_rku;
                    $model->id_tanaman_silvikultur = $value->id;
                    $model->tahun = $i;
                    $model->save();
                }
            }
        }
    }

    protected function addHHBK($j_hhbk, $rku) {
        foreach ($j_hhbk as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $model = new RkuHasilHutanNonkayu;
                $model->id_rku = $rku->id_rku;
                $model->id_hasil_hutan_nonkayu_silvikultur = $value->id;
                $model->tahun = $i;
                $model->save();
            }
        }
    }

    protected function updateHHBK($j_hhbk, $rku) {
        $md = RkuHasilHutanNonkayu::model()->findAll(array('condition' => 'tahun < ' . $rku->tahun_mulai . ' OR tahun > ' . $rku->tahun_sampai));
        foreach ($md as $d) {
            $d->delete();
        }
        foreach ($j_hhbk as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                $cek_panen = RkuHasilHutanNonkayu::model()->find(array('condition' => 'id_rku = ' . $rku->id_rku . ' AND id_hasil_hutan_nonkayu_silvikultur = ' . $value->id . ' AND tahun = ' . $i));
                if (empty($cek_panen)) {
                    $model = new RkuHasilHutanNonkayu;
                    $model->id_rku = $rku->id_rku;
                    $model->id_hasil_hutan_nonkayu_silvikultur = $value->id;
                    $model->tahun = $i;
                    $model->save();
                }
            }
        }
    }

    protected function addPemasaran($j_tanaman, $rku, $j_pasar) {
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                foreach ($j_pasar as $pasar) {
                    $model = new RkuPasar;
                    $model->id_rku = $rku->id_rku;
                    $model->id_jenis_tanaman = $value->id_jenis_tanaman;
                    $model->tahun = $i;
                    $model->id_jenis_pasar = $pasar->id;
                    $model->save();
                }
            }
        }
    }

    protected function updatePemasaran($j_tanaman, $rku, $j_pasar) {
        $md = RkuPasar::model()->findAll(array('condition' => 'tahun < ' . $rku->tahun_mulai . ' OR tahun > ' . $rku->tahun_sampai));
        foreach ($md as $d) {
            $d->delete();
        }
        foreach ($j_tanaman as $value) {
            for ($i = $rku->tahun_mulai; $i <= $rku->tahun_sampai; $i++) {
                foreach ($j_pasar as $pasar) {
                    $cek_pemasaran = RkuPasar::model()->find(array('condition' => 'id_rku = ' . $rku->id_rku . ' AND id_jenis_tanaman = ' . $value->id_jenis_tanaman . ' AND tahun = ' . $i . ' AND id_jenis_pasar = ' . $pasar->id));
                    if (empty($cek_pemasaran)) {
                        $model = new RkuPasar;
                        $model->id_rku = $rku->id_rku;
                        $model->id_jenis_tanaman = $value->id_jenis_tanaman;
                        $model->tahun = $i;
                        $model->id_jenis_pasar = $pasar->id;
                        $model->save();
                    }
                }
            }
        }
    }

}
