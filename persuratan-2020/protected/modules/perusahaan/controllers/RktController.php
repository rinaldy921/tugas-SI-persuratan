<?php

class RktController extends Controller {

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
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update','revisi','indexRev','revProduksi','revLingkungan','revSosial'),
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
        $model = new Rkt;
        
        $file_error = 0;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        $ngepathShp = Yii::app()->params->uploadPath . '/SHP/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
               
        $model->setScenario('create');
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
        $rku = Rku::model()->find(array(
            'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan() . ' AND edit_status=1'
        ));

        if (isset($_POST['Rkt'])) {
            // var_dump($_POST['Rkt']);die;
            $model->attributes = $_POST['Rkt'];
            $model->id_perusahaan = Yii::app()->user->idPerusahaan();
            $last_report = array();
            
               if ($_FILES["pdf_sk"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_sk']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_sk');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);
                $new_name1 = "RKT_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) . $new_path1;
                
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->file_doc = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SK RKT harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            
            
            if ($_FILES["shp_map"]["error"] == 0) {
                $ukuran_file2 = $_FILES['shp_map']['size'];
                $file2 = CUploadedFile::getInstanceByName('shp_map');
                $ran2 = rand();
                $ext2 = $file2->getExtensionName();
                $realName2 = pathinfo($file2->name, PATHINFO_FILENAME);
                $replaceFile2 = str_replace(' ', '_', $realName2);

                $new_name2 = "RKT_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/SHP/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) . $new_path2;
                
                if (!empty($file2) && strtolower($ext2) == "zip" && $ukuran_file2 <= 20971520) {
                    $file2->saveAs($name2);
                    $model->file_shp = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SHP Peta RKT harus ZIP dengan ukuran maksimal 20 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
                       
            if ($rku) {
                $model->id_rku = $rku->id_rku;
            }
            if ($model->validate()) {
                $th = $model->tahun_mulai;
                $ml = date('Y', strtotime($model->mulai_berlaku));
                // echo $th.' '.$ml;die;
                // if($ml < $th ) {
                //     $model->addError('mulai_berlaku','Tanggal mulai berlaku kurang dari tahun yang sudah ditentukan.');
                //     $this->render('create', array(
                //         'model' => $model,
                //         'rku'=>$rku
                //     ));
                //     Yii::app()->end();
                // }
                $rkt = Rkt::model()->findAll(array(
                    'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan() . ' AND status=1 AND id_rku=' . $model->id_rku
                ));
                if ($rkt) {
                    foreach($rkt as $cari) {
                        // $cr = strtotime($model->tahun_mulai);
                        // $start = strtotime($cari->tahun_mulai);
                        // $end = strtotime($cari->tahun_sampai);
                        // var_dump($start);die;
                        // if(($cr >= $start) && ($cr <= $end)) {
                        if($cari->tahun_mulai == $model->tahun_mulai) {
                            $model->addError('tahun_mulai','Data RKT dengan tahun mulai '.$model->tahun_mulai.' sudah ada.');
                            $this->render('create', array(
                                'model' => $model,
                                'rku'=>$rku
                            ));
                            Yii::app()->end();
                            // $message = Yii::t('app', 'Data RKT dengan tahun mulai '.$model->tahun_mulai.' sudah ada. Silahkan input tahun RKT baru.');
                            // Yii::app()->user->setFlash('error', $message);
                            // $this->redirect(array('create'));
                        }
                    }
                    // // $rkt->status = 2;
                    // // $rkt->update(array('status'));
                    // $last_report = PenilaianKinerja::model()->find(array(
                    //     'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan() . ' AND id_rkt=' . $rkt->id
                    //     // . ' AND id_rku=' . $model->id_rku
                    // ));
                }
            }
            
            
            if ($file_error == 0) {
                if ($model->save()) {
                    $idRkt = $model->id;
                    $message = Yii::t('app', 'Data berhasil disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                } else {
                    $message = Yii::t('app', 'Data gagal disimpan karena file error.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('create'));
                }
            }
//            if ($model->save()) {
//                $idRkt = $model->id;
//
////                $this->generateGanis($model->id);
////                $this->generateBibit($model->id);
////                $this->generateDungtan($model->id);
////                $this->generateInfraMukim($model->id);
//                // $this->generateNonKayu($model->id);
//
//                // $this->generateReport($model, $last_report);
//                $message = Yii::t('app', 'Data berhasil disimpan.');
//                Yii::app()->user->setFlash('success', $message);
//                $this->redirect(array('index'));
//            }
        }

        $this->render('create', array(
            'model' => $model,
            'rku'=>$rku
        ));
    }

    public function actionRevisi($id)
    {
        $model = new Rkt;
        $rkt_sebelum = Rkt::model()->findByPk($id);
        
//        $file_error = 0;
//        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
//        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
//        $ngepath = Yii::app()->params->uploadPath . '/SHP/' . $p;
//        if (!is_dir($ngepath)) {
//            mkdir($ngepath, 0777, true);
//        }
        
        $rku = Rku::model()->find(array(
            'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan() . ' AND edit_status=1'
        ));

        if (isset($_POST['Rkt'])) {
            // var_dump($_POST['Rkt']);die;
            $model->attributes = $_POST['Rkt'];
            $model->id_rev = $id;
            $model->id_perusahaan = Yii::app()->user->idPerusahaan();
            $last_report = array();
            
               if ($_FILES["pdf_sk"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_sk']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_sk');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);
                $new_name1 = "RKT_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) . $new_path1;
                
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->file_doc = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SK RKT harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            
            
            if ($_FILES["shp_map"]["error"] == 0) {
                $ukuran_file2 = $_FILES['shp_map']['size'];
                $file2 = CUploadedFile::getInstanceByName('shp_map');
                $ran2 = rand();
                $ext2 = $file2->getExtensionName();
                $realName2 = pathinfo($file2->name, PATHINFO_FILENAME);
                $replaceFile2 = str_replace(' ', '_', $realName2);

                $new_name2 = "RKT_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/SHP/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) . $new_path2;
                
                if (!empty($file2) && strtolower($ext2) == "zip" && $ukuran_file2 <= 20971520) {
                    $file2->saveAs($name2);
                    $model->file_shp = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SHP Peta RKT harus ZIP dengan ukuran maksimal 20 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
            
            if ($rku) {
                $model->id_rku = $rku->id_rku;
            }
            if ($model->validate()) {
                $th = $model->tahun_mulai;
                $ml = date('Y', strtotime($model->mulai_berlaku));
                // echo $th.' '.$ml;die;
                if($ml < $th ) {
                    $model->addError('mulai_berlaku','Tanggal mulai berlaku kurang dari tahun yang sudah ditentukan.');
                    $this->render('create', array(
                        'model' => $model,
                        'rku'=>$rku
                    ));
                    Yii::app()->end();
                }
            }
            
            if ($file_error == 0) {
                if($model->insert()) {
                    $this->revisiRktGanis($rkt_sebelum->id, $model->id);
                    $this->revisiRktBibit($rkt_sebelum->id, $model->id);
                    $this->revisiRktDungtan($rkt_sebelum->id, $model->id);
                    $this->revisiRktInfraMukim($rkt_sebelum->id, $model->id);
                    // $this->revisiProgresTataBatas($rkt_sebelum->id, $model->id);
                    $this->revisiKinerja($rkt_sebelum->id, $model);

                    $rkt_sebelum->status = '2';

                        if($rkt_sebelum->save()) {
                            $message = Yii::t('app', 'Data berhasil disimpan.');
                            Yii::app()->user->setFlash('success', $message);
                            $this->redirect(array('index'));
                } else {
                    $message = Yii::t('app', 'Data gagal disimpan karena file error.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('create'));
                }
                        
                        
                        
            }
            }
        }

        $this->render('revisi', array(
            'model' => $model,
            'rktSebelum' => $rkt_sebelum,
            'rku'=>$rku
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Rkt'])) {
            $model->attributes = $_POST['Rkt'];
            
            $file_error = 0;

            $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
            $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
            $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
            $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
            $ngepath = Yii::app()->params->uploadPath . '/SHP/' . $p;

            if (!is_dir($ngepath)) {
                mkdir($ngepath, 0777, true);
            }

            if (isset($_POST['Rkt'])) {
                $model->attributes = $_POST['Rkt'];

               if ($_FILES["pdf_sk"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_sk']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_sk');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);
                $new_name1 = "RKT_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) . $new_path1;
                
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->file_doc = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SK RKT harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            
            
            if ($_FILES["shp_map"]["error"] == 0) {
                $ukuran_file2 = $_FILES['shp_map']['size'];
                $file2 = CUploadedFile::getInstanceByName('shp_map');
                $ran2 = rand();
                $ext2 = $file2->getExtensionName();
                $realName2 = pathinfo($file2->name, PATHINFO_FILENAME);
                $replaceFile2 = str_replace(' ', '_', $realName2);

                $new_name2 = "RKT_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/SHP/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) . $new_path2;
                
                if (!empty($file2) && strtolower($ext2) == "zip" && $ukuran_file2 <= 20971520) {
                    $file2->saveAs($name2);
                    $model->file_shp = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SHP Peta RKT harus ZIP dengan ukuran maksimal 20 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
//                    $idRkt = $model->id;
                    $message = Yii::t('app', 'Data berhasil disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                } else {
                    $message = Yii::t('app', 'Data gagal disimpan karena file error.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('create'));
                }
            }
//                if ($model->save()) {
//                    $message = Yii::t('app', 'Data berhasil disimpan.');
//                    Yii::app()->user->setFlash('success', $message);
//                    $this->redirect(array('index'));
//                }
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
    public function actionDelete($id){
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            if($model->id_rev !== null) {
                // var_dump($model->id_rev);die;
                $rkt_sebelum = Rkt::model()->findByPk($model->id_rev);
            }
            
            $tmpKawasan = RktKawasanLindung::model()->deleteByRktId($id);
            
            if($model->delete()) {
                if(!empty($rkt_sebelum)) {
                    $rkt_sebelum->status = '1';
                    $rkt_sebelum->save();
                }
            }

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
        $rku = Rku::model()->find(array('condition'=>'edit_status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()));
       
        
        if(isset($rku)) {
            $model = new Rkt('search');
            $model->unsetAttributes();  // clear any default values
            $model->id_perusahaan = $rku->id_perusahaan;
            $model->id_rku = $rku->id_rku;
        } else {
            $message = Yii::t('app', 'Silahkan lengkapi data RKU terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/index'));
        }

        if (isset($_GET['Rkt']))
            $model->attributes = $_GET['Rkt'];

        $this->render('index', array(
            'model' => $model,
            'rku'=>$rku
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Rkt::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rkt-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // public function generateReport($data, $data2) {
    //     $model = new PenilaianKinerja;
    //     $model->id_perusahaan = $data->id_perusahaan;
    //     $model->id_rkt = $data->id;
    //     $model->tahun = $data->tahun_mulai;
    //     $model->aspek_1 = isset($data2->aspek_1) ? $data2->aspek_1 : 1;
    //     $model->aspek_2 = isset($data2->aspek_2) ? $data2->aspek_2 : 6;
    //     $model->aspek_3 = isset($data2->aspek_3) ? $data2->aspek_3 : 8;
    //     $model->aspek_4 = isset($data2->aspek_4) ? $data2->aspek_4 : 9;
    //     $model->aspek_5 = isset($data2->aspek_5) ? $data2->aspek_5 : 12;
    //     $model->aspek_6 = isset($data2->aspek_6) ? $data2->aspek_6 : 15;
    //     $model->save();
    // }

    protected function cekLuas($id) {
        $iuphhk = Iuphhk::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
        $masterGanis = MasterJenisGanis::model()->find(array('condition'=>'id = '.$id));
        // $hasil = null;
        if(isset($iuphhk)) {
            if($iuphhk->luas < floatval(50000)) {
                $hasil = empty($masterGanis->val1) ? null : $masterGanis->val1;
            } elseif($iuphhk->luas >= floatval(50000) && $iuphhk->luas <= floatval(100000)) {
                $hasil = empty($masterGanis->val2) ? null : $masterGanis->val2;
            } elseif($iuphhk->luas >= floatval(100000) && $iuphhk->luas <= floatval(200000)) {
                $hasil = empty($masterGanis->val3) ? null : $masterGanis->val3;
            } elseif($iuphhk->luas > floatval(200000)) {
                $hasil = empty($masterGanis->val4) ? null : $masterGanis->val4;
            }
        }
        return $hasil;
        // var_dump($hasil);
    }

    protected function generateGanis($rkt_id) {
        $bloksektor = BlokSektor::model()->findAll(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
        $jenisProduksiLahan = MasterJenisProduksiLahan::model()->findAll();
        $jenisPwh = MasterJenisPwh::model()->findAll();
        $jenisPeralatan = MasterJenisPeralatan::model()->findAll(array('condition'=>'id_perusahaan = 0 OR id_perusahaan = '.Yii::app()->user->idPerusahaan()));
        $jenisSarpras = MasterJenisSarpras::model()->findAll(array('condition'=>'id_perusahaan = 0 OR id_perusahaan = '.Yii::app()->user->idPerusahaan()));
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $jenisBatas = MasterJenisBatas::model()->findAll();

        $ganis = RktGanis::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $tatabatas = RktTataBatas::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $tataruang = RktKawasanLindung::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $arealNonProduktif = RktArealNonProduktif::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $arealProduktif = RktArealProduktif::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $arealKerja = RktArealKerja::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $invent = RktInventarisasi::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $pwh = RktPwh::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $masukGunaAlat = RktMasukGunaAlat::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $bangunSarpras = RktSarpras::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        // if(empty($ganis)) {
        //     foreach($jenisGanis as $jg) {
        //         // echo $this->cekLuas($iuphhk->luas, $jg->id);die;
        //         $ganis = new RktGanis;
        //         $ganis->id_rkt = $rkt_id;
        //         $ganis->id_ganis = $jg->id;
        //         $ganis->jumlah = $this->cekLuas($jg->id);
        //         $ganis->save();
        //     }
        // }
        // if(empty($tatabatas)) {
        //     foreach($jenisBatas as $jb) {
        //         $tatabatas = new RktTataBatas;
        //         $tatabatas->id_rkt = $rkt_id;
        //         $tatabatas->id_jenis_batas = $jb->id;
        //         $tatabatas->save();
        //     }
        // }
        // if(empty($tataruang)) {
        //     foreach($bloksektor as $bs) {
        //         $tataruang = new RktKawasanLindung;
        //         $tataruang->id_rkt = $rkt_id;
        //         $tataruang->id_blok = $bs->id;
        //         $tataruang->save();
        //     }
        // }
        // if(empty($arealNonProduktif)) {
        //     foreach($bloksektor as $bs) {
        //         $arealNonProduktif = new RktArealNonProduktif;
        //         $arealNonProduktif->id_rkt = $rkt_id;
        //         $arealNonProduktif->id_blok = $bs->id;
        //         $arealNonProduktif->save();
        //     }
        // }
        // if(empty($arealProduktif)) {
        //     foreach($bloksektor as $bs) {
        //         foreach($jenisProduksiLahan as $jpl) {
        //             $arealProduktif = new RktArealProduktif;
        //             $arealProduktif->id_rkt = $rkt_id;
        //             $arealProduktif->id_blok = $bs->id;
        //             $arealProduktif->id_jenis_produksi_lahan = $jpl->id;
        //             $arealProduktif->save();
        //         }
        //     }
        // }
        // if(empty($invent)) {
        //     // foreach($bloksektor as $bs) {
        //         foreach($jenisProduksiLahan as $jpl) {
        //             $invent = new RktInventarisasi;
        //             $invent->id_rkt = $rkt_id;
        //             // $arealProduktif->id_blok = $bs->id_blok;
        //             $invent->id_jenis_produksi = $jpl->id;
        //             $invent->save();
        //         }
        //     // }
        // }
        // if(empty($arealKerja)) {
        //     foreach($bloksektor as $bs) {
        //         foreach($jenisProduksiLahan as $jpl) {
        //             $arealKerja = new RktArealKerja;
        //             $arealKerja->id_rkt = $rkt_id;
        //             $arealKerja->id_blok = $bs->id;
        //             $arealKerja->id_jenis_produksi_lahan = $jpl->id;
        //             $arealKerja->save();
        //         }
        //     }
        // }
        // if(empty($pwh)){
        //     foreach($jenisPwh as $jpwh) {
        //         $pwh = new RktPwh;
        //         $pwh->id_rkt = $rkt_id;
        //         $pwh->id_pwh = $jpwh->id;
        //         $pwh->save();
        //     }
        // }
        // if(empty($masukGunaAlat)){
        //     foreach($jenisPeralatan as $jpr) {
        //         $masukGunaAlat = new RktMasukGunaAlat;
        //         $masukGunaAlat->id_rkt = $rkt_id;
        //         $masukGunaAlat->id_jenis_peralatan = $jpr->id;
        //         $masukGunaAlat->save();
        //     }
        // }
        // if(empty($bangunSarpras)){
        //     foreach($jenisSarpras as $js) {
        //         $bangunSarpras = new RktSarpras;
        //         $bangunSarpras->id_rkt = $rkt_id;
        //         $bangunSarpras->id_jenis_sarpras = $js->id;
        //         $bangunSarpras->save();
        //     }
        // }
    }

    protected function generateBibit($rkt_id) {
        $rkt = Rkt::model()->find(array('condition' => 'id=' .$rkt_id));
        $rku = Rku::model()->find(array('condition' => 'edit_status=1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        
        $bloksektor = RkuBlok::model()->findAll(array('condition'=>'id_rku = '.$rku->id_rku));
        $jenisProduksiLahan = MasterJenisProduksiLahan::model()->findAll();
        $jenisTanamanBibit = MasterJenisTanamanBibit::model()->findAll();
        $jenisLahan = MasterJenisLahan::model()->findAll(array('condition'=>'id IN(1,2)'));
        $jenisPasar = MasterJenisPemasaran::model()->findAll();
        $jenisKayu = MasterJenisKayu::model()->findAll();
        $jenisKelKayu = MasterJenisKelompokKayu::model()->findAll();

        $rkuTanSil = RkuTanamanSilvikultur::model()->findAll(array('condition'=>'id_rku = '. $rku->id_rku));
        $rkuTanam = RkuTanam::model()->findAll(array('condition'=>'id_rku='.$rku->id_rku));
        
        $bibit = RktBibit::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id));
        $siapLahan = RktSiapLahan::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $tanam = RktTanam::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $sulam = RktSulam::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $jarang = RktJarang::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $dangir = RktDangir::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $panenAreal = RktPanenAreal::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $panenTanaman = RktPanenVolumeTanaman::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $panenSiapLahan = RktPanenVolumeSiapLahan::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $pasar = RktPasar::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        if(empty($bibit)) {
            if(isset($rkuTanSil)) {
                foreach($rkuTanSil as $rts) {
                    $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$rts->id_jenis_produksi_lahan));
                    $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$rts->id_jenis_tanaman));

                    $bibit = new RktBibit;
                    $bibit->id_rkt = $rkt_id;
                    $bibit->id_rku_bibit - $rts->id;
                   // $bibit->id_produksi_lahan = $jplz->id;
                    $bibit->id_jenis_tanaman = $jptz->id;
                    $bibit->save();
                }
            }
        }
        if(empty($siapLahan)) {
            foreach($jenisLahan as $key => $jl) {
                foreach($bloksektor as $bs) {
                    if($jl->id === 3) {
                        return;
                    }
                    $siapLahan = new RktSiapLahan;
                    $siapLahan->id_rkt = $rkt_id;
                    $siapLahan->id_jenis_lahan = $jl->id;
                    $siapLahan->id_blok = $bs->id;
                    // $bibit->id_jenis_tanaman = $jt->id;
                    $siapLahan->save();
                }
            }
        }
        if(empty($tanam)) {
            if(isset($rkuTanSil)) {
                foreach($jenisLahan as $key => $jl) {
                    foreach($rkuTanSil as $jtb) {
                        foreach($bloksektor as $bs) {
                            $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$jtb->id_jenis_produksi_lahan));
                            $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$jtb->id_jenis_tanaman));
                            // echo $jtb->id_rku.'<br>';
                            $tanamz = new RktTanam;
                            $tanamz->id_rkt = $rkt_id;
                            
                            $rkuTanamRef = RkuTanam::model()->find(array('condition'=>'id_rku ='.$rku->id_rku.' AND rkt_ke ='.$rkt->rkt_ke));
                            $tanamz->id_rku_tanam = $rkuTanamRef->id;
                            
                            $tanamz->id_jenis_lahan = $jl->id;
                            $tanamz->id_jenis_produksi_lahan = $jplz->id;
                            $tanamz->id_jenis_tanaman = $jptz->id;
                            // $tanam->id_blok = $bs->id;
                            $tanamz->id_blok = $bs->id;
                            // $bibit->id_jenis_tanaman = $jt->id;
                            if(!$tanamz->save()){
                                var_dump($tanamz->getErrors());die;
                            }
                        }
                    }
                }
            }
        }
        // $rkuHHBKSil = RkuHasilHutanNonkayuSilvikultur::model()->findAll(array('condition' => 'id_rku='.$rku->id_rku));
        // $nonkayu = RktHasilHutanNonkayu::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));


        if(empty($sulam)) {
            foreach($jenisProduksiLahan as $jpl) {
                $sulam = new RktSulam;
                $sulam->id_rkt = $rkt_id;
                $sulam->id_jenis_produksi_lahan = $jpl->id;
                $sulam->save();
            }
        }
        if(empty($jarang)) {
            foreach($jenisProduksiLahan as $jpl) {
                $jarang = new RktJarang;
                $jarang->id_rkt = $rkt_id;
                $jarang->id_jenis_produksi_lahan = $jpl->id;
                $jarang->save();
            }
        }
        if(empty($dangir)) {
            foreach($jenisProduksiLahan as $jpl) {
                $dangir = new RktDangir;
                $dangir->id_rkt = $rkt_id;
                $dangir->id_jenis_produksi_lahan = $jpl->id;
                $dangir->save();
            }
        }
        if(empty($pasar)) {
            foreach($jenisPasar as $jps) {
                $pasar = new RktPasar;
                $pasar->id_rkt = $rkt_id;
                $pasar->id_pemasaran = $jps->id;
                $pasar->save();
            }
        }
        if(empty($panenAreal)) {
            if(isset($rkuTanSil)) {
                // echo 'here';die;
                foreach($jenisLahan as $key => $jl) {
                    // if($key > 1) {
                    //     return;
                    // }
                    foreach($rkuTanSil as $jtb) {
                        foreach($bloksektor as $bs) {
                            $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$jtb->id_jenis_produksi_lahan));
                            $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$jtb->id_jenis_tanaman));
                            // echo $jtb->id_rku.'<br>';
                            $panenz = new RktPanenAreal;
                            $panenz->id_rkt = $rkt_id;
                            $panenz->id_rku_tansil = $jtb->id;
                            $panenz->id_jenis_lahan = $jl->id;
                            $panenz->id_produksi_lahan = $jplz->id;
                            $panenz->id_jenis_tanaman = $jptz->id;
                            // $tanam->id_blok = $bs->id;
                            $panenz->id_blok = $bs->id;
                            // $bibit->id_jenis_tanaman = $jt->id;
                            if(!$panenz->save()){
                                var_dump($panenz->getErrors());die;
                            }
                        }
                    }
                }
            }
        }
        // if(empty($panenAreal)) {
        //     foreach($jenisLahan as $jl) {
        //         foreach($jenisProduksiLahan as $jpl) {
        //             // foreach($bloksektor as $bs) {
        //                 // if($jl->id === 3) {
        //                 //     return;
        //                 // }
        //                 $panenAreal = new RktPanenAreal;
        //                 $panenAreal->id_rkt = $rkt_id;
        //                 $panenAreal->id_jenis_lahan = $jl->id;
        //                 $panenAreal->id_jenis_produksi_lahan = $jpl->id;
        //                 // $tanam->id_blok = $bs->id;
        //                 // $panenAreal->id_blok = $bs->id;
        //                 // $bibit->id_jenis_tanaman = $jt->id;
        //                 $panenAreal->save();
        //             // }
        //         }
        //     }
        // }

        if(empty($panenTanaman)) {
            if(isset($rkuTanSil)) {
                // echo 'here';die;
                foreach($jenisLahan as $key => $jl) {
                    // if($key > 1) {
                    //     return;
                    // }
                    foreach($rkuTanSil as $jtb) {
                        foreach($bloksektor as $bs) {
                            $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$jtb->id_jenis_produksi_lahan));
                            $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$jtb->id_jenis_tanaman));
                            // echo $jtb->id_rku.'<br>';
                            $panenz = new RktPanenVolumeTanaman;
                            $panenz->id_rkt = $rkt_id;
                            $panenz->id_rku_tansil = $jtb->id;
                            $panenz->id_jenis_lahan = $jl->id;
                            $panenz->id_produksi_lahan = $jplz->id;
                            $panenz->id_jenis_tanaman = $jptz->id;
                            // $tanam->id_blok = $bs->id;
                            $panenz->id_blok = $bs->id;
                            // $bibit->id_jenis_tanaman = $jt->id;
                            if(!$panenz->save()){
                                var_dump($panenz->getErrors());die;
                            }
                        }
                    }
                }
            }
        }
        // if(empty($panenTanaman)) {
        //     foreach($jenisProduksiLahan as $jpl) {
        //         $panenTanaman = new RktPanenVolumeTanaman;
        //         $panenTanaman->id_rkt = $rkt_id;
        //         $panenTanaman->id_jenis_produksi_lahan = $jpl->id;
        //         $panenTanaman->save();
        //     }
        // }
        if(empty($panenSiapLahan)) {
            foreach($jenisKayu as $jk) {
                foreach($jenisKelKayu as $jkk) {
                    $panenSiapLahan = new RktPanenVolumeSiapLahan;
                    $panenSiapLahan->id_rkt = $rkt_id;
                    $panenSiapLahan->id_jenis_kayu = $jk->id;
                    $panenSiapLahan->id_jenis_kelompok_kayu = $jkk->id;
                    $panenSiapLahan->save();
                }
            }
        }
    }

    protected function generateDungtan($rkt_id) {
        $jenisDalkar = MasterJenisDalkar::model()->findAll();

        $dungtan = RktLingkunganDungtan::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $dalmakit = RktLingkunganDalmakit::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $dalkar = RktLingkunganDalkar::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));

        if(empty($dalkar)) {
            foreach($jenisDalkar as $jd) {
                // foreach($jenisTanaman as $jt) {
                    $dalkar = new RktLingkunganDalkar;
                    $dalkar->id_rkt = $rkt_id;
                    $dalkar->id_dalkar = $jd->id;
                    // $bibit->id_jenis_tanaman = $jt->id;
                    if(!$dalkar->save()) {
                        print_r($dalkar->getErrors());
                    }
                // }
            }
        }
    }

    protected function generateInfraMukim($rkt_id) {
        $jenisInfraMukim = MasterJenisInfraMukim::model()->findAll();
        $jenisSdm = MasterJenisPeningkatanSdm::model()->findAll();
        $inframukim = RktInfraMukim::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $sdm = RktPeningkatanSdm::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $kerjasama = RktKerjasamaKoperasi::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $bangunMitra = RktBangunMitra::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        if(empty($inframukim)) {
            foreach($jenisInfraMukim as $jim) {
                // foreach($jenisTanaman as $jt) {
                $inframukim = new RktInfraMukim;
                $inframukim->id_rkt = $rkt_id;
                $inframukim->id_infra_mukim = $jim->id;
                // $bibit->id_jenis_tanaman = $jt->id;
                $inframukim->save();
                // }
            }
        }
        if(empty($sdm)) {
            foreach($jenisSdm as $jsdm) {
                // foreach($jenisTanaman as $jt) {
                $sdm = new RktPeningkatanSdm;
                $sdm->id_rkt = $rkt_id;
                $sdm->id_peningkatan_sdm = $jsdm->id;
                // $bibit->id_jenis_tanaman = $jt->id;
                $sdm->save();
                // }
            }
        }
    }

    protected function revisiRktGanis($rkt_id, $rkt_new_id) {
        $ganis = RktGanis::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $tatabatas = RktTataBatas::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $tataruang = RktKawasanLindung::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $arealNonProduktif = RktArealNonProduktif::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $arealProduktif = RktArealProduktif::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $arealKerja = RktArealKerja::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $invent = RktInventarisasi::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $pwh = RktPwh::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $masukGunaAlat = RktMasukGunaAlat::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $bangunSarpras = RktSarpras::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));

        foreach($ganis as $gn) {
            $data = new RktGanis;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($tatabatas as $gn) {
            $data = new RktTataBatas;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($tataruang as $gn) {
            $data = new RktKawasanLindung;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($arealNonProduktif as $gn) {
            $data = new RktArealNonProduktif;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($arealProduktif as $gn) {
            $data = new RktArealProduktif;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($arealKerja as $gn) {
            $data = new RktArealKerja;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($pwh as $gn) {
            $data = new RktPwh;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($masukGunaAlat as $gn) {
            $data = new RktMasukGunaAlat;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($bangunSarpras as $gn) {
            $data = new RktSarpras;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
    }

    protected function revisiRktBibit($rkt_id, $rkt_new_id) {
        $bibit = RktBibit::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id));
        $siapLahan = RktSiapLahan::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $tanam = RktTanam::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $sulam = RktSulam::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $jarang = RktJarang::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $dangir = RktDangir::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $panenAreal = RktPanenAreal::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $panenTanaman = RktPanenVolumeTanaman::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $panenSiapLahan = RktPanenVolumeSiapLahan::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $pasar = RktPasar::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));

        foreach($bibit as $gn) {
            $data = new RktBibit;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($siapLahan as $gn) {
            $data = new RktSiapLahan;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($tanam as $gn) {
            $data = new RktTanam;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($sulam as $gn) {
            $data = new RktSulam;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($jarang as $gn) {
            $data = new RktJarang;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($dangir as $gn) {
            $data = new RktDangir;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($panenAreal as $gn) {
            $data = new RktPanenAreal;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($panenTanaman as $gn) {
            $data = new RktPanenVolumeTanaman;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($panenSiapLahan as $gn) {
            $data = new RktPanenVolumeSiapLahan;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach($pasar as $gn) {
            $data = new RktPasar;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
    }

    protected function revisiRktDungtan($rkt_id, $rkt_new_id) {
        $dungtan = RktLingkunganDungtan::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $dalmakit = RktLingkunganDalmakit::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $dalkar = RktLingkunganDalkar::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $pantau = RktPemantauanLingkungan::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));

        if(!empty($dungtan)) {
            foreach($dungtan as $gn) {
                $data = new RktLingkunganDungtan;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if(!empty($dalmakit)) {
            foreach($dalmakit as $gn) {
                $data = new RktLingkunganDalmakit;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if(!empty($dalkar)) {
            foreach($dalkar as $gn) {
                $data = new RktLingkunganDalkar;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if(!empty($pantau)) {
            foreach($pantau as $gn) {
                $data = new RktPemantauanLingkungan;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
    }

    protected function revisiRktInfraMukim($rkt_id, $rkt_new_id) {
        $inframukim = RktInfraMukim::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $sdm = RktPeningkatanSdm::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $kerjasama = RktKerjasamaKoperasi::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $bangunMitra = RktBangunMitra::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));
        $konflik = RktKonflikSosial::model()->findAll(array('condition'=>'id_rkt = '.$rkt_id ));

        if(!empty($inframukim)) {
            foreach($inframukim as $gn) {
                $data = new RktInfraMukim;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if(!empty($sdm)) {
            foreach($sdm as $gn) {
                $data = new RktPeningkatanSdm;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if(!empty($kerjasama)) {
            foreach($kerjasama as $gn) {
                $data = new RktKerjasamaKoperasi;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if(!empty($bangunMitra)) {
            foreach($bangunMitra as $gn) {
                $data = new RktBangunMitra;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if(!empty($konflik)) {
            foreach($konflik as $gn) {
                $data = new RktKonflikSosial;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
    }

    // protected function revisiProgresTataBatas($rkt_id, $rkt_new_id) {
    //     $tatabatas = ProgresTataBatas::model()->find(array('condition'=>'id_rkt = '.$rkt_id));
    //     if(!empty($tatabatas)) {
    //         $data = new ProgresTataBatas;
    //         $data->attributes = $tatabatas->attributes;
    //         $data->id_rkt = $rkt_new_id;
    //         if(!$data->save()) {
    //             print_r($data->getErrors());die;
    //         }
    //     }
    // }

    protected function revisiKinerja($rkt_id, $rkt_new_id) {
        $kinerja = PenilaianKinerja::model()->find(array(
            'condition' => 'id_rkt=' . $rkt_new_id->id. ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
        ));

        if (!isset($kinerja)) {
            $this->generateReport(Yii::app()->user->idPerusahaan(), $rkt_new_id);
            $kinerja = PenilaianKinerja::model()->find(array(
                'condition' => 'id_rkt=' . $rkt_new_id->id . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
            ));
        } else {
            $kinerja = $this->updateReport($kinerja, $rkt_new_id);
        }
    }

    public function actionIndexRev($id) {
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id));
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rkt/'));
            }
        }
        $bloksektor = BlokSektor::model()->findAll(array('condition' => 'id_perusahaan = ' . $rkt->id_perusahaan));
        if (isset($rkt)) {
            $idRkt = $rkt->id;

            $modelGanis = new RktGanis;
            $modelGanis->unsetAttributes();
            if (isset($_GET['RktGanis']))
                $modelGanis->attributes = $_GET['RktGanis'];
            $modelGanis->id_rkt = $rkt->id;

            $modelTataBatas = new RktTataBatas;
            $modelTataBatas->unsetAttributes();
            if (isset($_GET['RktTataBatas']))
                $modelTataBatas->attributes = $_GET['RktTataBatas'];
            $modelTataBatas->id_rkt = $rkt->id;

            $modelKawasan = new RktKawasanLindung;
            $modelKawasan->unsetAttributes();
            if (isset($_GET['RktKawasanLindung']))
                $modelKawasan->attributes = $_GET['RktKawasanLindung'];
            $modelKawasan->id_rkt = $rkt->id;

            $modelArealNonProduktif = new RktArealNonProduktif;
            $modelArealNonProduktif->unsetAttributes();
            if (isset($_GET['RktArealNonProduktif']))
                $modelArealNonProduktif->attributes = $_GET['RktArealNonProduktif'];
            $modelArealNonProduktif->id_rkt = $rkt->id;

            $modelArealProduktif = new RktArealProduktif('search');
            $modelArealProduktif->unsetAttributes();
            if (isset($_GET['RktArealProduktif']))
                $modelArealProduktif->attributes = $_GET['RktArealProduktif'];
            $modelArealProduktif->id_rkt = $rkt->id;

            $modelArealKerja = new RktArealKerja;
            $modelArealKerja->unsetAttributes();
            if (isset($_GET['RktArealKerja']))
                $modelArealKerja->attributes = $_GET['RktArealKerja'];
            $modelArealKerja->id_rkt = $rkt->id;

            $modelInventarisasi = new RktInventarisasi;
            $modelInventarisasi->unsetAttributes();
            if (isset($_GET['RktInventarisasi']))
                $modelInventarisasi->attributes = $_GET['RktInventarisasi'];
            $modelInventarisasi->id_rkt = $rkt->id;

            $modelPwh = new RktPwh;
            $modelPwh->unsetAttributes();
            if (isset($_GET['RktPwh']))
                $modelPwh->attributes = $_GET['RktPwh'];
            $modelPwh->id_rkt = $rkt->id;

            $modelMasterJenisPeralatan = new MasterJenisPeralatan;
            $modelMasterJenisSarpras = new MasterJenisSarpras;

            $modelMasukGunaAlat = new RktMasukGunaAlat('search');
            $modelMasukGunaAlat->unsetAttributes();
            if (isset($_GET['RktMasukGunaAlat']))
                $modelMasukGunaAlat->attributes = $_GET['RktMasukGunaAlat'];
            $modelMasukGunaAlat->id_rkt = $rkt->id;

            $modelBangunSarpras = new RktSarpras;
            $modelBangunSarpras->unsetAttributes();
            if (isset($_GET['RktSarpras']))
                $modelBangunSarpras->attributes = $_GET['RktSarpras'];
            $modelBangunSarpras->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rkt/'.$id));
        }

        $this->render('test/index', array(
            // 'iup' => $iup,
            'model' => $rkt,
            'ganis' => $modelGanis,
            'tatabatas' => $modelTataBatas,
            'tataruang' => $modelKawasan,
            'arealProduktif' => $modelArealProduktif,
            'arealKerja' => $modelArealKerja,
            'arealNonProduktif' => $modelArealNonProduktif,
            'inventarisasi' => $modelInventarisasi,
            'pwh' => $modelPwh,
            'masukGunaAlat' => $modelMasukGunaAlat,
            'bangunSarpras' => $modelBangunSarpras,
            'bloksektor' => $bloksektor,
            'idRkt' => $idRkt
        ));
    }

    public function actionRevProduksi($id) {
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id));
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rkt/' . $id));
            }
        }
        if (isset($rkt)) {
            $modelBibit = new RktBibit;
            $modelBibit->unsetAttributes();
            if (isset($_GET['RktBibit']))
                $modelBibit->attributes = $_GET['RktBibit'];
            $modelBibit->id_rkt = $rkt->id;

            $modelSiapLahan = new RktSiapLahan;
            $modelSiapLahan->unsetAttributes();
            if (isset($_GET['RktSiapLahan']))
                $modelSiapLahan->attributes = $_GET['RktSiapLahan'];
            $modelSiapLahan->id_rkt = $rkt->id;

            $modelTanam = new RktTanam;
            $modelTanam->unsetAttributes();
            if (isset($_GET['RktTanam']))
                $modelTanam->attributes = $_GET['RktTanam'];
            $modelTanam->id_rkt = $rkt->id;

            $modelSulam = new RktSulam;
            $modelSulam->unsetAttributes();
            if (isset($_GET['RktSulam']))
                $modelSulam->attributes = $_GET['RktSulam'];
            $modelSulam->id_rkt = $rkt->id;

            $modelJarang = new RktJarang;
            $modelJarang->unsetAttributes();
            if (isset($_GET['RktJarang']))
                $modelJarang->attributes = $_GET['RktJarang'];
            $modelJarang->id_rkt = $rkt->id;

            $modelDangir = new RktDangir;
            $modelDangir->unsetAttributes();
            if (isset($_GET['RktDangir']))
                $modelDangir->attributes = $_GET['RktDangir'];
            $modelDangir->id_rkt = $rkt->id;

            $modelPasar = new RktPasar;
            $modelPasar->unsetAttributes();
            if (isset($_GET['RktPasar']))
                $modelPasar->attributes = $_GET['RktPasar'];
            $modelPasar->id_rkt = $rkt->id;

            $modelPanenAreal = new RktPanenAreal;
            $modelPanenAreal->unsetAttributes();
            if (isset($_GET['RktPanenAreal']))
                $modelPanenAreal->attributes = $_GET['RktPanenAreal'];
            $modelPanenAreal->id_rkt = $rkt->id;

            $modelPanenTanaman = new RktPanenVolumeTanaman;
            $modelPanenTanaman->unsetAttributes();
            if (isset($_GET['RktPanenVolumeTanaman']))
                $modelPanenTanaman->attributes = $_GET['RktPanenVolumeTanaman'];
            $modelPanenTanaman->id_rkt = $rkt->id;

            $modelPanenSiapLahan = new RktPanenVolumeSiapLahan;
            $modelPanenSiapLahan->unsetAttributes();
            if (isset($_GET['RktPanenVolumeSiapLahan']))
                $modelPanenSiapLahan->attributes = $_GET['RktPanenVolumeSiapLahan'];
            $modelPanenSiapLahan->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/' . $id));
        }

        $this->render('rktProduksi/index', array(
            // 'iup' => $iup,
            'model' => $rkt,
            'modelBibit' => $modelBibit,
            'modelSiapLahan' => $modelSiapLahan,
            'modelTanam' => $modelTanam,
            'modelSulam' => $modelSulam,
            'modelJarang' => $modelJarang,
            'modelDangir' => $modelDangir,
            'modelPanenAreal' => $modelPanenAreal,
            'modelPanenTanaman' => $modelPanenTanaman,
            'modelPanenSiapLahan' => $modelPanenSiapLahan,
            'modelPasar' => $modelPasar
        ));
    }

    public function actionRevLingkungan($id) {
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id));
        // if (isset($_POST['Rkt'])) {
        //     $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . $id . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
        //     if (!isset($rkt)) {
        //         $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
        //         Yii::app()->user->setFlash('notice', $message);
        //         $this->redirect(array('//admin/rkt/' . $id));
        //     }
        // }
        if (isset($rkt)) {
            $dungtan = RktLingkunganDungtan::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
            if (empty($dungtan))
                $dungtan = new RktLingkunganDungtan;

            $dalmakit = RktLingkunganDalmakit::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
            if (empty($dalmakit))
                $dalmakit = new RktLingkunganDalmakit;

            $modelDalkar = new RktLingkunganDalkar;
            $modelDalkar->unsetAttributes();
            if (isset($_GET['RktLingkunganDalkar']))
                $modelDalkar->attributes = $_GET['RktLingkunganDalkar'];
            $modelDalkar->id_rkt = $rkt->id;

            $modelPantau = new RktPemantauanLingkungan;
            $modelPantau->unsetAttributes();
            if (isset($_GET['RktPemantauanLingkungan']))
                $modelPantau->attributes = $_GET['RktPemantauanLingkungan'];
            $modelPantau->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/' . $id));
        }

        $this->render('rktLingkungan/index', array(
            // 'iup' => $iup,
            'model' => $rkt,
            'modelDungtan' => $dungtan,
            'modelDalmakit' => $dalmakit,
            'modelDalkar' => $modelDalkar,
            'modelPantau' => $modelPantau,
        ));
    }

    public function actionRevSosial($id) {
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id));
        // if (isset($_POST['Rkt'])) {
        //     $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . $iup->id_perusahaan . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
        //     if (!isset($rkt)) {
        //         $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
        //         Yii::app()->user->setFlash('notice', $message);
        //         $this->redirect(array('//admin/rkt/' . $id));
        //     }
        // }
        if (isset($rkt)) {
            $modelInfraMukim = new RktInfraMukim;
            $modelInfraMukim->unsetAttributes();
            if (isset($_GET['RktInfraMukim']))
                $modelInfraMukim->attributes = $_GET['RktInfraMukim'];
            $modelInfraMukim->id_rkt = $rkt->id;

            $modelSdm = new RktPeningkatanSdm;
            $modelSdm->unsetAttributes();
            if (isset($_GET['RktPeningkatanSdm']))
                $modelSdm->attributes = $_GET['RktPeningkatanSdm'];
            $modelSdm->id_rkt = $rkt->id;


            $modelKonflikSosial = new RktKonflikSosial;
            $modelKonflikSosial->unsetAttributes();
            if (isset($_GET['RktKonflikSosial']))
                $modelKonflikSosial->attributes = $_GET['RktKonflikSosial'];
            $modelKonflikSosial->id_rkt = $rkt->id;

            $kerjasama = RktKerjasamaKoperasi::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
            if(empty($kerjasama))
                $kerjasama = new RktKerjasamaKoperasi;

            $bangunMitra = RktBangunMitra::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
            if(empty($bangunMitra))
                $bangunMitra = new RktBangunMitra;

        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/' . $id));
        }

        $this->render('rktSosial/index', array(
            // 'iup' => $iup,
            'model' => $rkt,
            'modelKonflikSosial' => $modelKonflikSosial,
            'modelInfraMukim' => $modelInfraMukim,
            'modelKerjasama' => $kerjasama,
            'modelSdm' => $modelSdm,
            'modelBangunMitra' => $bangunMitra,
        ));
    }
}
