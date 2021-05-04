<?php

class RkuPersyaratanController extends Controller {

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
                'actions' => array('index', 'deleteSerapanNaker','inputSerapanNaker', 'deleteBlokAreal',
                    'createBatas', 'deleteSarpras', 'deleteGanis', 'deleteBatas', 'getTahunRku',
                    'deleteArealKawasanLindung', 'deleteArealProduktif', 'deleteArealKerja','addBlokAreal', 
                    'inputJumlah','inputRktKeArealKerja', 'inputNonProduktif', 'inputJumlahProduktif', 'inputArealKerja', 
                    'inputJumlahPeralatan', 'inputTataBatas', 'inputJumlahSarpras', 'deletePeralatan', 'deletePwh', 'inputJumlahPwh'),
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

    
    
    //add blok ajax
    public function actionGetTahunRku() {
        $rkuThnKe = new RkuTahunKe;
        $idKe = $_POST['idKe'];
        
        $rkuThnKe = RkuTahunKe::model()->findByPk($idKe);

        $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => "success",
            'tahun' => $rkuThnKe->tahun 
        );
        
//        
//       print_r("<pre>");
//       print_r($data);
//       print_r("</pre>"); exit(1);
       
       
        echo json_encode($data);
        die();
    }
    
    
      //add blok ajax
    public function actionAddBlokAreal() {
        $idBlok = $_POST['idBlok'];
        $namaBlok = $_POST['txtBlok'];
        $res=array();
   
        //new
        if(isset(Yii::app()->session['arealIDBlok']) && Yii::app()->session['arealIDBlok'] ==''){
            Yii::app()->session['arealIDBlok'] = $idBlok;
            Yii::app()->session['arealNamaBlok'] = $namaBlok;
            
            $obj = array('id'=>$idBlok,'nama'=>$namaBlok);
            array_push($res, $obj);
      
        }
        else{
            Yii::app()->session['arealIDBlok'] = Yii::app()->session['arealIDBlok'].','.$idBlok;
            Yii::app()->session['arealNamaBlok'] = Yii::app()->session['arealNamaBlok'].','.$namaBlok;
            
            $IDBlokList = explode(",", Yii::app()->session['arealIDBlok']);
            $NamaBlokList = explode(",", Yii::app()->session['arealNamaBlok']);
      
            foreach($IDBlokList as $key=>$val){
                $obj = array('id'=>$val,'nama'=>$NamaBlokList[$key]);
                
                array_push($res, $obj);
            }
            
           
        }
//        print_r("<pre>");
//            print_r($res);
//            print_r("</pre>"); exit(1);
       
        $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => "success",
            'data' => $res 
        );

        echo json_encode($data);
        die();
    }
    
    
      //delete blok ajax
    public function actionDeleteBlokAreal() {
        $idBlok = $_POST['idBlok'];
        $arrID; $arrNama;
        
        $res=array();
   
        //new
        if(isset(Yii::app()->session['arealIDBlok']) && Yii::app()->session['arealIDBlok'] ==''){
            //do nothing
        }
        else{    
            
            $IDBlokList = explode(",", Yii::app()->session['arealIDBlok']);
            $NamaBlokList = explode(",", Yii::app()->session['arealNamaBlok']);
      
            Yii::app()->session['arealIDBlok']='';
            Yii::app()->session['arealNamaBlok'] ='';
            
            foreach($IDBlokList as $key=>$val){
                
                if($val != $idBlok){
                    $obj = array('id'=>$val,'nama'=>$NamaBlokList[$key]);
                    
                    if(Yii::app()->session['arealIDBlok']==''){
                        Yii::app()->session['arealIDBlok'] = $val.',';
                        Yii::app()->session['arealNamaBlok'] = $NamaBlokList[$key].',';
                    
                    }else{
                        Yii::app()->session['arealIDBlok'] = Yii::app()->session['arealIDBlok'].','.$val.',';
                        Yii::app()->session['arealNamaBlok'] = Yii::app()->session['arealNamaBlok'] .','.$NamaBlokList[$key].',';
                    
                    }
                   
                    array_push($res, $obj);
                }                
            }          
           
        }
//       
//       
//                    
//         print_r("<pre>");
//        print_r($res);
//        print_r("</pre>"); exit(1); 
                    
                    
                    
        $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => "success",
            'data' => $res 
        );

        echo json_encode($data);
        die();
    }
    
    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new MasterJenisGanis;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['MasterJenisGanis'])) {
            $model->attributes = $_POST['MasterJenisGanis'];
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

    public function actionCreateBatas() {
        $model = new RkuTataBatas;
        $rku = Rku::model()->find(array(
            'condition' => 'edit_status=1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
        ));
        $model->id_rku = $rku->id_rku;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['RkuTataBatas'])) {
            $model->attributes = $_POST['RkuTataBatas'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create_tata_batas', array(
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

        if (isset($_POST['MasterJenisGanis'])) {
            $model->attributes = $_POST['MasterJenisGanis'];
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
    public function actionDeleteBatas($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuTataBatas::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePeralatan($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuPeralatan::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteSarpras($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuSarpras::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePwh($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuPwh::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteGanis($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuGanis::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionDeleteSerapanNaker($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuSerapanTenagaKerja::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    

    public function actionDeleteArealKerja($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuArealKerja::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteArealKawasanLindung($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuKawasanLindung::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteArealProduktif($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuArealProduktif::model()->findByPk($id)->delete();

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
        $jenis_kawasan = MasterJenisKawasanLindung::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        if (!isset($rku)) {
            $message = Yii::t('app', 'Silahkan isi RKU terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/index'));
        }
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rku/index'));
            }
        }
		
		
        //$jenisGanis = MasterJenisGanis::model()->findAll();
        if (isset($rku)) {
            // RKU GANIS
            $RkuSerapanNaker = new RkuSerapanTenagaKerja();
            $RkuSerapanNaker->id_rku = $rku->id_rku;
            if (isset($_POST['RkuSerapanTenagaKerja'])) {
                $RkuSerapanNaker->attributes = $_POST['RkuSerapanTenagaKerja'];
                if ($RkuSerapanNaker->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($RkuSerapanNaker);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

            $gridSerapanNaker = new RkuSerapanTenagaKerja('search');
            $gridSerapanNaker->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuSerapanTenagaKerja']))
                $gridSerapanNaker->attributes = $_GET['RkuSerapanTenagaKerja'];
            $gridSerapanNaker->id_rku = $rku->id_rku;


//        Tata Batas
            $new_tata_batas = new RkuTataBatas;
            $new_tata_batas->id_rku = $rku->id_rku;

            if (isset($_POST['RkuTataBatas'])) {
                $new_tata_batas->attributes = $_POST['RkuTataBatas'];
                if ($new_tata_batas->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($new_tata_batas);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

            $tata_batas = new RkuTataBatas('search');
            $tata_batas->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuTataBatas']))
                $tata_batas->attributes = $_GET['RkuTataBatas'];
            $tata_batas->id_rku = $rku->id_rku;

// if()
            $tataruang = RkuKawasanLindung::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
            $nonProduktif = RkuArealNonProduktif::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
            // if (empty($tataruang)) {
            //     foreach ($jenis_kawasan as $kws) {
            //         $tataruang = new RkuKawasanLindung;
            //         $tataruang->id_rku = $rku->id_rku;
            //         $tataruang->id_jenis_kawasan_lindung = $kws->id;
            //         $tataruang->save();
            //     }
            // }
            if (empty($nonProduktif)) {
                $tataruang = new RkuArealNonProduktif;
                $tataruang->id_rku = $rku->id_rku;
                $tataruang->save();
            }


            $produktif = new RkuArealProduktif;
            $produktif->id_rku = $rku->id_rku;

            $old_produktif = new RkuArealProduktif('search');
            $old_produktif->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuArealProduktif']))
                $old_produktif->attributes = $_GET['RkuArealProduktif'];
            $old_produktif->id_rku = $rku->id_rku;

            if (isset($_POST['RkuArealProduktif'])) {
                $produktif->attributes = $_POST['RkuArealProduktif'];
                if ($produktif->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($produktif);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

//            Penataaan Areal Kerja
            $arealKerja = new RkuArealKerja;
            $arealKerja->id_rku = $rku->id_rku;

            $old_arealKerja = new RkuArealKerja('search');
            $old_arealKerja->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuArealKerja']))
                $old_arealKerja->attributes = $_GET['RkuArealKerja'];
            $old_arealKerja->id_rku = $rku->id_rku;

            if(isset($_POST['RkuArealKerja'])) {
                $arealKerja->attributes = $_POST['RkuArealKerja'];
                if ($arealKerja->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($arealKerja);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

//            Peralatan
            $addPralatan = new RkuPeralatan;
            $addPralatan->id_rku = $rku->id_rku;

            $peralatan = new RkuPeralatan('search');
            $peralatan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPeralatan']))
                $peralatan->attributes = $_GET['RkuPeralatan'];
            $peralatan->id_rku = $rku->id_rku;

            if (isset($_POST['RkuPeralatan'])) {
                $addPralatan->attributes = $_POST['RkuPeralatan'];
                if ($addPralatan->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($addPralatan);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

//            Sarpras
            $addSarpras = new RkuSarpras;
            $addSarpras->id_rku = $rku->id_rku;

            $sarpras = new RkuSarpras('search');
            $sarpras->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuSarpras']))
                $sarpras->attributes = $_GET['RkuSarpras'];
            $sarpras->id_rku = $rku->id_rku;

            if (isset($_POST['RkuSarpras'])) {
                $addSarpras->attributes = $_POST['RkuSarpras'];
                if ($addSarpras->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($addSarpras);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

//            PWH
            $addPwh = new RkuPwh;
            $addPwh->id_rku = $rku->id_rku;

            $pwh = new RkuPwh('search');
            $pwh->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPwh']))
                $pwh->attributes = $_GET['RkuPwh'];
            $pwh->id_rku = $rku->id_rku;

            if (isset($_POST['RkuPwh'])) {
                $addPwh->attributes = $_POST['RkuPwh'];
                if ($addPwh->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($addPwh);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }
        } else {
            $message = Yii::t('app', 'Silahkan isi RKU terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/index'));
        }

        $modelKawasan = new RkuKawasanLindung;
        $modelKawasan->unsetAttributes();
        if (isset($_GET['RkuKawasanLindung']))
            $modelKawasan->attributes = $_GET['RkuKawasanLindung'];
        $modelKawasan->id_rku = $rku->id_rku;

        if (isset($_POST['RkuKawasanLindung'])) {
            $modelKawasan->attributes = $_POST['RkuKawasanLindung'];
            if ($modelKawasan->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($modelKawasan);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
        
        
        
//        print_r("<pre>");
//        print_r($modelKawasan);
//        print_r("<pre>"); exit(1);

        $non_produktif = new RkuArealNonProduktif;
        $non_produktif->unsetAttributes();
        if (isset($_GET['RkuArealNonProduktif']))
            $non_produktif->attributes = $_GET['RkuArealNonProduktif'];
        $non_produktif->id_rku = $rku->id_rku;

        $this->render('index', array(
            'rku' => $rku,
            //'old_ganis' => $old_ganis,
            'naker' => $gridSerapanNaker,
            'rkuNaker'=> $RkuSerapanNaker,
            'new_tata_batas' => $new_tata_batas,
            'tata_batas' => $tata_batas,
            'modelKawasan' => $modelKawasan,
            'non_produktif' => $non_produktif,
            'old_produktif' => $old_produktif,
            'produktif' => $produktif,
            'old_arealKerja' => $old_arealKerja,
            'arealKerja' => $arealKerja,
            'addPeralatan' => $addPralatan,
            'peralatan' => $peralatan,
            'addSarpras' => $addSarpras,
            'sarpras' => $sarpras,
            'addPwh' => $pwh,
            'pwh' => $pwh
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RkuGanis::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'master-jenis-ganis-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rkuPersyaratan-tatabatas-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    public function actionInputTataBatas() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuTataBatas');
        $model->update();
    }
    
    public function actionInputJumlah() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuKawasanLindung');
        $model->update();
    }

    public function actionInputNonProduktif() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuArealNonProduktif');
        $model->update();
    }

    public function actionInputJumlahProduktif() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuArealProduktif');
        $model->update();
    }

    public function actionInputSerapanNaker() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuSerapanTenagaKerja');
        $model->update();
    }

    public function actionInputArealKerja() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuArealKerja');
        $model->update();
    }

    public function actionInputRktKeArealKerja() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuArealKerja');
        $model->update();
    }
    
    
    public function actionInputJumlahPeralatan() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPeralatan');
        $model->update();
    }

    public function actionInputJumlahSarpras() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuSarpras');
        $model->update();
    }

    public function actionInputJumlahPwh() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuPwh');
        $model->update();
    }

    protected function cekLuas($id) {
        $iuphhk = Iuphhk::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $masterGanis = MasterJenisGanis::model()->find(array('condition' => 'id = ' . $id));
        // $hasil = null;
        if (isset($iuphhk)) {
            if ($iuphhk->luas < floatval(50000)) {
                $hasil = empty($masterGanis->val1) ? null : $masterGanis->val1;
            } elseif ($iuphhk->luas >= floatval(50000) && $iuphhk->luas <= floatval(100000)) {
                $hasil = empty($masterGanis->val2) ? null : $masterGanis->val2;
            } elseif ($iuphhk->luas >= floatval(100000) && $iuphhk->luas <= floatval(200000)) {
                $hasil = empty($masterGanis->val3) ? null : $masterGanis->val3;
            } elseif ($iuphhk->luas > floatval(200000)) {
                $hasil = empty($masterGanis->val4) ? null : $masterGanis->val4;
            }
        }
        return $hasil;
        // var_dump($hasil);
    }

}
