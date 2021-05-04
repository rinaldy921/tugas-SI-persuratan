<?php

class RkuController extends Controller {

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
                'actions' => array(
                    'create', 'update', 'print', 'revisi', 'cekData', 'indexRev','aktifasiRKU','kelolaBlokSektor',
                    'viewPrasyarat', 'viewProduksi', 'viewLingkungan', 'viewSosial', 'AddBlokSektor',
                    'rktIndex', 'detailRkt', 'rktIndexRev', 'rktProduksiRev', 'rktLingkunganRev', 'rktSosialRev',
                    'bloksektor', 'Deletebloksektor','Deletesektor','addNewSektor','getbloksektor'
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
        
//        print_r($id); exit(1);
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }
    
    /**
     * author : Dian Purnomo
     * date  : 29 February 2019
     * @param type $id
     */
    public function actionKelolaBlokSektor($id){
       //$id = Yii::app()->session['rku_id'];
       $model = $this->loadModel($id);
        // echo Yii::app()->user->idPerusahaan();
        $sql = "
        SELECT
            b.id,
            b.nama_blok,
            b.nama_sektor
        FROM
            blok_sektor b
        WHERE
            b.id_perusahaan = :id_perusahaan AND
            b.id_rku = :id_rku
        ORDER by b.id_sektor, b.id_blok
        ";
        $query = Yii::app()->db->createCommand($sql);
        $query->params = array(
            ':id_perusahaan' => Yii::app()->user->idPerusahaan(),
            ':id_rku' => $id
        );
        $row = $query->queryAll();
        $modelblok = new CArrayDataProvider($row, array(
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));

//        print_r("<pre>");
//        print_r(Yii::app()->user->idPerusahaan());
//        print_r("</pre>");exit(1);
        
        $this->render('kelolabloksektor', array(
            'model' => $model,
            'modelblok' => $modelblok
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Rku;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

 
        if (isset($_POST['Rku'])) {
            $model->attributes = $_POST['Rku'];
            $model->id_perusahaan = Yii::app()->user->idPerusahaan();
            $file_error = 0;

            $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
            $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
            $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
            $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
            $ngepathShp = Yii::app()->params->uploadPath . '/SHP/' . $p;
            if (!is_dir($ngepath)) {
                mkdir($ngepath, 0777, true);
            }

            if ($_FILES["pdf_sk"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_sk']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_sk');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);
                $new_name1 = "RKU_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) . $new_path1;
                
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->file_doc = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SK RKU harus PDF dengan ukuran maksimal 2 Mb');
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

                $new_name2 = "RKU_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/SHP/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) . $new_path2;
                
                if (!empty($file2) && strtolower($ext2) == "zip" && $ukuran_file2 <= 20971520) {
                    $file2->saveAs($name2);
                    $model->file_shp = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SHP Peta RKU harus ZIP dengan ukuran maksimal 20 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
            
            
            
            if ($model->validate()) {
                $rku = Rku::model()->find(array(
                    'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan() . ' AND status=1'
                ));
                if ($rku) {
                    $cariTaun = Rku::model()->findAll(array('condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan() . ' AND status=1'));
                    foreach ($cariTaun as $cari) {
                        if ($cari->tahun_mulai == $model->tahun_mulai) {
                            $model->addError('tahun_mulai', 'Data RKU dengan tahun mulai ' . $model->tahun_mulai . ' sudah ada.');
                            $this->render('create', array(
                                'model' => $model,
                                'rku' => $rku
                            ));
                            Yii::app()->end();
                            // $message = Yii::t('app', 'Data RKT dengan tahun mulai '.$model->tahun_mulai.' sudah ada. Silahkan input tahun RKT baru.');
                            // Yii::app()->user->setFlash('error', $message);
                            // $this->redirect(array('create'));
                        }
                    }
                    $rku->status = 3;
                    $rku->update(array('status'));

                    // $rkt = Rkt::model()->find(array(
                    //     'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan() . ' AND status=1 AND id_rku=' . $rku->id_rku
                    // ));
                    // if ($rkt) {
                    //     $rkt->status = 2;
                    //     $rkt->update(array('status'));
                    // }
                }
            }
            if ($file_error == 0) {
                if ($model->save()) {
                    $this->generatePrasyarat($model->id_rku);
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

        $file_error = 0;
        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        $ngepath = Yii::app()->params->uploadPath . '/SHP/' . $p;
        
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }

        if (isset($_POST['Rku'])) {
            $model->attributes = $_POST['Rku'];

                if ($_FILES["pdf_sk"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_sk']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_sk');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);
                $new_name1 = "RKU_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) . $new_path1;
                
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->file_doc = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SK RKU harus PDF dengan ukuran maksimal 2 Mb');
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

                $new_name2 = "RKU_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/SHP/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) . $new_path2;
                
                if (!empty($file2) && strtolower($ext2) == "zip" && $ukuran_file2 <= 20971520) {
                    $file2->saveAs($name2);
                    $model->file_shp = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SHP Peta RKU harus ZIP dengan ukuran maksimal 20 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
            
            if ($file_error == 0) {
                if ($model->save()) {
                    $this->generatePrasyarat($model->id_rku);
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

        $this->render('update', array(
            'model' => $model,
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
            $model = $this->loadModel($id);
            if ($model->id_rev !== null) {
                // var_dump($model->id_rev);die;
                $rku_sebelum = Rku::model()->findByPk($model->id_rev);
            }
            
            $rkuBlok = RkuBlok::model()->deleteByRkuId($id);
            $rkuSektor = RkuSektor::model()->deleteByRkuId($id);
            $rkt = Rkt::model()->deleteByRkuId($id);
            
            if ($model->delete()) {
                if (!empty($rku_sebelum)) {
                    $rku_sebelum->status = '1';
                    $rku_sebelum->save();
                }
            } else {
                var_dump($model->getErrors());
                die;
            }
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    
    
    
    public function actionRevisi($id) {
        $model = new Rku;
        $rku_sebelum = Rku::model()->findByPk($id);
        
        $file_error = 0;
        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        $ngepath = Yii::app()->params->uploadPath . '/SHP/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }

        if (isset($_POST['Rku'])) {
            $model->attributes = $_POST['Rku'];
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
                $new_name1 = "RKU_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) . $new_path1;
                
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->file_doc = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SK RKU harus PDF dengan ukuran maksimal 2 Mb');
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

                $new_name2 = "RKU_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/SHP/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) . $new_path2;
                
                if (!empty($file2) && strtolower($ext2) == "zip" && $ukuran_file2 <= 20971520) {
                    $file2->saveAs($name2);
                    $model->file_shp = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File SHP Peta RKU harus ZIP dengan ukuran maksimal 20 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
            // else {
            //     $file_error++;
            //     $message = Yii::t('app', 'PDF Surat harus Diisi');
            //     Yii::app()->user->setFlash('error', $message);
            //     $this->redirect(array('create'));
            //     Yii::app()->end();
            // }

            if ($file_error == 0) {
                
                
                
                if ($model->save()) {  //sementara
                    $this->revisiSilvikultur($rku_sebelum->id_rku, $model->id_rku);
                    $this->revisiPrasyarat($rku_sebelum->id_rku, $model->id_rku);
                    $this->revisiKelestarian($rku_sebelum->id_rku, $model->id_rku);
                    $this->revisiLingkungan($rku_sebelum->id_rku, $model->id_rku);
                    $this->revisiFungsos($rku_sebelum->id_rku, $model->id_rku);
                    $this->revisiBlokSektor($rku_sebelum->id_rku, $model->id_rku);
                    $m = '';
                    
                    if (isset($_POST['Rku']['checkbox']) && $_POST['Rku']['checkbox'] == '0') {
                        
                        $hasil = $this->revisiRkt($rku_sebelum->id_rku,$model->id_rku, $_POST['Rku']['idRktCopy'], $m);
                        $m = $hasil;
                    } else {
                        $m = ' Data RKT tidak dimuat kembali.';
                    }
                    $rku_sebelum->status = '2';   //direvisi

                    if ($rku_sebelum->save()) {
                        $message = Yii::t('app', 'Data berhasil disimpan.');
                        Yii::app()->user->setFlash('success', $message . $m);
                        $this->redirect(array('index'));
                    }

                } else {
                    $message = Yii::t('app', 'Data gagal disimpan karena file error.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('create'));
                }
        }
        }

        $this->render('revisi', array(
            'model' => $model,
            'rkuSebelum' => $rku_sebelum,
        ));
    }

    public function actionBloksektor($id) {
        $model = $this->loadModel($id);
        // echo Yii::app()->user->idPerusahaan();
        
        
        
        // =================================================================================
        $sqlSektor = "SELECT * FROM rku_sektor WHERE id_rku=:id_rku AND id_perusahaan=:id_perusahaan ORDER BY nama_sektor ASC";
        
        $query2 = Yii::app()->db->createCommand($sqlSektor);
        $query2->params = array(
            ':id_perusahaan' => Yii::app()->user->idPerusahaan(),
            ':id_rku' => $id
        );
        
        $row2 = $query2->queryAll();

        
        $modelSektor = new CArrayDataProvider($row2, array(
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
        
        // =================================================================================
        $sql = "
        
        SELECT
            b.id,
            b.nama_blok,
            b.id_rku,
            b.desc,
            s.id_sektor,
            s.nama_sektor,
            s.desc
        FROM 
            rku_blok b 
        INNER JOIN 
            rku_sektor s ON b.id_sektor = s.id_sektor 
        WHERE 
            b.id_rku=:id_rku AND b.id_rku = s.id_rku AND s.id_perusahaan=:id_perusahaan
        ORDER BY s.nama_sektor,b.nama_blok ASC 
        ";
        
        
        $query = Yii::app()->db->createCommand($sql);
        $query->params = array(
            ':id_perusahaan' => Yii::app()->user->idPerusahaan(),
            ':id_rku' => $id
        );
        
        $row = $query->queryAll();

        
        $modelblok = new CArrayDataProvider($row, array(
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));

        if (isset($_POST['Rku'])) {
            
            $modelBlok = new RkuBlok;
           // $data['RkuBlok'] = $modelBlok;
            $modelBlok->id_sektor = $_POST['Rku']['sektor'];
            $modelBlok->nama_blok = $_POST['Rku']['blok'];
            $modelBlok->id_rku = Yii::app()->session['rku_id'];

            
             
            
            //$modelBlok->attribute = $data;

            $message = 'Data Gagal disimpan';
            if($modelBlok->save()){
                $message='Data Berhasil disimpan';
                $url = 'rku/bloksektor/id/'.Yii::app()->session['rku_id'];
                $this->redirect(array($url));
            }

   
            $message = Yii::t('app', $message);
            Yii::app()->user->setFlash('success', $message);
            $this->redirect(array('bloksektor'));
            // }
        }
        
        
//                print_r("<pre>");
//                print_r($query2);
//                print_r("</pre>");exit(1);
        
        
        
        $this->render('bloksektor', array(
            'model' => $model,
            'modelblok' => $modelblok,
            'modelSektor' => $modelSektor
        ));
    }

    public function actionDeletebloksektor($id_blok) {
        //$delete = BlokSektor::model()->findByPk($id_blok)->delete();
        
        $delete = RkuBlok::model()->findByPk($id_blok)->delete();
        $data = array(
            'header' => "Sukses",
            'message' => "Data Blok Berhasil dihapus",
            'status' => "success"
        );
        echo json_encode($data);
        die();
    }

    
    
     public function actionDeletesektor($id_sektor, $id_rku) {
        //$delete = BlokSektor::model()->findByPk($id_blok)->delete();
         
         
        $deleteBlok = RkuBlok::model()->deleteBySektorId($id_sektor);
        $delete = RkuSektor::model()->findByPk($id_sektor)->delete();
        $listSektor = CHtml::listData(RkuSektor::model()->findAllByAttributes(array('id_rku'=>$id_rku)),'id_sektor','nama_sektor');
        
//        print_r("<pre>");
//        print_r($listSektor);
//        print_r("</pre>");exit(1);
        
        $data = array(
            'header' => "Sukses",
            'message' => "Data Unit Kelestarian Berhasil dihapus",
            'status' => "success",
            'listSektor' => $listSektor
        );
        echo json_encode($data);
        die();
    }
    
    
//get blok ajax    
    public function actionGetbloksektor($id_blok) {
        //$delete = BlokSektor::model()->findByPk($id_blok)->delete();
        
        $tmpBlok = RkuBlok::model()->findByPk($id_blok);
        
        $data;
        
        if(isset($tmpBlok)){
            $data['id_blok'] = $tmpBlok->id;
            $data['nama_blok'] = $tmpBlok->nama_blok;
            $data['id_kabupaten'] = $tmpBlok->id_kabupaten;
            $data['id_sektor'] = $tmpBlok->id_sektor;       
        }
        else{
            $data = array(
                'header' => "Gagal",
                'message' => "Data Tidak Berhasil ditemukan",
                'status' => "gagal",
            );
        }
        
//         print_r("<pre>");
//        print_r($data);
//        print_r("</pre>"); exit(1);
        
        
        echo json_encode($data);
        die();
    }
    
//add blok ajax
    public function actionAddBlokSektor() {
        $blok = new RkuBlok;
        
        
        $idBlok = $_POST['idBlok'];
        
        if($idBlok == 0){
            $blok->nama_blok = $_POST['namaBlok'];
            $blok->id_sektor = $_POST['idSektor'];
//            $blok->id_kabupaten = $_POST['idKabupaten'];
            $blok->id_rku = Yii::app()->session['rku_id'];
            $blok->save();
        }
        else{
            $blok = RkuBlok::model()->findByPk($idBlok);
            
            $blok->nama_blok = $_POST['namaBlok'];
            $blok->id_sektor = $_POST['idSektor'];
//            $blok->id_kabupaten = $_POST['idKabupaten'];
            
            $blok->update();
        }
         
//        print_r("<pre>");
//        print_r($blok);
//        print_r("</pre>"); exit(1);
        
        
        
        $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => "success"
        );
        
        
        echo json_encode($data);
        die();
    }
    
    
    

	//add new sektor ajax
    public function actionAddNewSektor() {
            $sektor;
        
            if($_POST['idSektor'] != ''){
                $sektor = RkuSektor::model()->findByPk($_POST['idSektor']);
                $sektor->nama_sektor =  $_POST['namaSektor'];
                
                $sektor->id_rku = Yii::app()->session['rku_id'];
                $sektor->id_perusahaan = Yii::app()->user->idPerusahaan();
                
                $sektor->update();
            }
            else{
                $sektor = new RkuSektor;
                
                $sektor->nama_sektor =  $_POST['namaSektor'];
                $sektor->id_rku = Yii::app()->session['rku_id'];
                $sektor->id_perusahaan = Yii::app()->user->idPerusahaan();
                
                $sektor->save();
            }        
           // print_r("<pre>");        print_r($sektor); print_r("</pre>"); die();        


            $data = array(
                'header' => "Sukses",
                'message' => "Data Berhasil disimpan",
                'status' => "success",
                            'id' => $sektor->getPrimaryKey()
            );
            echo json_encode($data);
            die();
    }
    
    
    /**
     * created by : Dian Purnomo
     * date : 27 February 2019
     * @param type $idRKU
     */
    public function actionAktifasiRKU($id){
         $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
                  
          $rku = Rku::model()->find(array(
                    'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan()));

                if ($rku) {
                    $listRKU = Rku::model()->findAll(array('condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan()));
                    
                    
                    foreach ($listRKU as $item) {
                       
                        $rku = $item;         //Rku::model()->findByPk($item->id_rku);
                        if ($item->id_rku == $id) {
                            $rku->edit_status = 1;
                           
                            Yii::app()->session['rku_id'] = $id;
                            Yii::app()->session['rku_sk'] = $rku->nomor_sk;
                        }else{
                            $rku->edit_status = 0;                 
                        }
                        $rku->update($id_rku, $rku);
                   
                        $rku = null;
                    }
                }
                
        $data = array(
            
            'message' => "Data Berhasil Di Ubah",
            'status' => "success"
        );
        
        $this->redirect(array('index'));
        //return json_encode($data);
        //die();
    }





    function deleteallblok($id_rku, $id_perusahaan) {
        $data = BlokSektor::model()->deleteAll(array('condition' => 'id_rku = "' . $id_rku . '" AND id_perusahaan = "' . $id_perusahaan . '"'));
    }

    function generateBlok($iuphhk, $perusahaan, $sektor, $blok) {
        for ($i = 1; $i <= $blok; $i++) {
            $model = new BlokSektor;
            $model->id_rku = $iuphhk;
            $model->id_perusahaan = $perusahaan;
            $model->id_sektor = $sektor;
            $model->id_blok = $i;
            $model->save();
        }
        return true;
    }

    function generateSektorBlok($iuphhk, $perusahaan, $sektor, $blok) {
        // var_dump($sektor);die;
        foreach ($blok as $key => $value) {
            // var_dump($value);die;
            for ($i = 0; $i < (int) $value; $i++) {
                $model = new BlokSektor;
                $model->id_rku = $iuphhk;
                $model->id_perusahaan = $perusahaan;
                $model->id_sektor = $key + 1;
                $model->id_blok = $i + 1;
                $model->save();
            }
        }
        // for($i = 1; $i < (int) $sektor; $i++) {
        //     // var_dump((int) $blok[$i - 1]);die;
        //     for($j = 1; $j < (int) $blok[$i - 1]; $j++) {
        //         $model = new BlokSektor;
        //         $model->id_iuphhk = $iuphhk;
        //         $model->id_perusahaan = $perusahaan;
        //         $model->id_sektor = $i;
        //         $model->id_blok = $j;
        //         $model->save();
        //     }
        // }
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $iuphhk = Iuphhk::model()->find(array('condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        if (!isset($iuphhk)) {
            $message = Yii::t('app', 'Silahkan lengkapi data IUPHHK terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/iuphhk/create'));
        }
        $model = new Rku('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Rku']))
            $model->attributes = $_GET['Rku'];
        $model->id_perusahaan = Yii::app()->user->idPerusahaan();

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Rku::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rku-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPrint($id) {
        $this->layout = "//layouts/main-print";
        $model = $this->loadModel($id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/statics/css/print.css');
        // $mPDF1->WriteHTML($stylesheet, 1);
        //$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot') . '/statics/images/kop_header.png' ));
        $mPDF1->WriteHTML($this->render('print', array('model' => $model), true));
        $nama_file = $this->titleize($this->sluggish($model->nomor_sk)) . '.pdf';
        $mPDF1->Output($nama_file, EYiiPdf::OUTPUT_TO_DOWNLOAD);
    }

    function titleize($word) {
        $output = ucwords(str_replace('_', ' ', preg_replace('/_id$/', '', $word)));
        return ucwords($output);
    }

    protected function sluggish($teks) {
        $text = (strlen($teks) >= 226) ? substr($teks, 0, 225) : $teks;
        return trim(strtolower(preg_replace('/([^\pL\pN])+/u', '-', trim(strtr(str_replace('\'', '', $text), array(
            'Ǎ' => 'A', 'А' => 'A', 'Ā' => 'A', 'Ă' => 'A', 'Ą' => 'A', 'Å' => 'A',
            'Ǻ' => 'A', 'Ä' => 'Ae', 'Á' => 'A', 'À' => 'A', 'Ã' => 'A', 'Â' => 'A',
            'Æ' => 'AE', 'Ǽ' => 'AE', 'Б' => 'B', 'Ç' => 'C', 'Ć' => 'C', 'Ĉ' => 'C',
            'Č' => 'C', 'Ċ' => 'C', 'Ц' => 'C', 'Ч' => 'Ch', 'Ð' => 'Dj', 'Đ' => 'Dj',
            'Ď' => 'Dj', 'Д' => 'Dj', 'É' => 'E', 'Ę' => 'E', 'Ё' => 'E', 'Ė' => 'E',
            'Ê' => 'E', 'Ě' => 'E', 'Ē' => 'E', 'È' => 'E', 'Е' => 'E', 'Э' => 'E',
            'Ë' => 'E', 'Ĕ' => 'E', 'Ф' => 'F', 'Г' => 'G', 'Ģ' => 'G', 'Ġ' => 'G',
            'Ĝ' => 'G', 'Ğ' => 'G', 'Х' => 'H', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ï' => 'I',
            'Ĭ' => 'I', 'İ' => 'I', 'Į' => 'I', 'Ī' => 'I', 'Í' => 'I', 'Ì' => 'I',
            'И' => 'I', 'Ǐ' => 'I', 'Ĩ' => 'I', 'Î' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J',
            'Й' => 'J', 'Я' => 'Ja', 'Ю' => 'Ju', 'К' => 'K', 'Ķ' => 'K', 'Ĺ' => 'L',
            'Л' => 'L', 'Ł' => 'L', 'Ŀ' => 'L', 'Ļ' => 'L', 'Ľ' => 'L', 'М' => 'M',
            'Н' => 'N', 'Ń' => 'N', 'Ñ' => 'N', 'Ņ' => 'N', 'Ň' => 'N', 'Ō' => 'O',
            'О' => 'O', 'Ǿ' => 'O', 'Ǒ' => 'O', 'Ơ' => 'O', 'Ŏ' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ö' => 'Oe', 'Õ' => 'O', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O',
            'Œ' => 'OE', 'П' => 'P', 'Ŗ' => 'R', 'Р' => 'R', 'Ř' => 'R', 'Ŕ' => 'R',
            'Ŝ' => 'S', 'Ş' => 'S', 'Š' => 'S', 'Ș' => 'S', 'Ś' => 'S', 'С' => 'S',
            'Ш' => 'Sh', 'Щ' => 'Shch', 'Ť' => 'T', 'Ŧ' => 'T', 'Ţ' => 'T', 'Ț' => 'T',
            'Т' => 'T', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
            'Ū' => 'U', 'Ǜ' => 'U', 'Ǚ' => 'U', 'Ù' => 'U', 'Ú' => 'U', 'Ü' => 'Ue',
            'Ǘ' => 'U', 'Ǖ' => 'U', 'У' => 'U', 'Ư' => 'U', 'Ǔ' => 'U', 'Û' => 'U',
            'В' => 'V', 'Ŵ' => 'W', 'Ы' => 'Y', 'Ŷ' => 'Y', 'Ý' => 'Y', 'Ÿ' => 'Y',
            'Ź' => 'Z', 'З' => 'Z', 'Ż' => 'Z', 'Ž' => 'Z', 'Ж' => 'Zh', 'á' => 'a',
            'ă' => 'a', 'â' => 'a', 'à' => 'a', 'ā' => 'a', 'ǻ' => 'a', 'å' => 'a',
            'ä' => 'ae', 'ą' => 'a', 'ǎ' => 'a', 'ã' => 'a', 'а' => 'a', 'ª' => 'a',
            'æ' => 'ae', 'ǽ' => 'ae', 'б' => 'b', 'č' => 'c', 'ç' => 'c', 'ц' => 'c',
            'ċ' => 'c', 'ĉ' => 'c', 'ć' => 'c', 'ч' => 'ch', 'ð' => 'dj', 'ď' => 'dj',
            'д' => 'dj', 'đ' => 'dj', 'э' => 'e', 'é' => 'e', 'ё' => 'e', 'ë' => 'e',
            'ê' => 'e', 'е' => 'e', 'ĕ' => 'e', 'è' => 'e', 'ę' => 'e', 'ě' => 'e',
            'ė' => 'e', 'ē' => 'e', 'ƒ' => 'f', 'ф' => 'f', 'ġ' => 'g', 'ĝ' => 'g',
            'ğ' => 'g', 'г' => 'g', 'ģ' => 'g', 'х' => 'h', 'ĥ' => 'h', 'ħ' => 'h',
            'ǐ' => 'i', 'ĭ' => 'i', 'и' => 'i', 'ī' => 'i', 'ĩ' => 'i', 'į' => 'i',
            'ı' => 'i', 'ì' => 'i', 'î' => 'i', 'í' => 'i', 'ï' => 'i', 'ĳ' => 'ij',
            'ĵ' => 'j', 'й' => 'j', 'я' => 'ja', 'ю' => 'ju', 'ķ' => 'k', 'к' => 'k',
            'ľ' => 'l', 'ł' => 'l', 'ŀ' => 'l', 'ĺ' => 'l', 'ļ' => 'l', 'л' => 'l',
            'м' => 'm', 'ņ' => 'n', 'ñ' => 'n', 'ń' => 'n', 'н' => 'n', 'ň' => 'n',
            'ŉ' => 'n', 'ó' => 'o', 'ò' => 'o', 'ǒ' => 'o', 'ő' => 'o', 'о' => 'o',
            'ō' => 'o', 'º' => 'o', 'ơ' => 'o', 'ŏ' => 'o', 'ô' => 'o', 'ö' => 'oe',
            'õ' => 'o', 'ø' => 'o', 'ǿ' => 'o', 'œ' => 'oe', 'п' => 'p', 'р' => 'r',
            'ř' => 'r', 'ŕ' => 'r', 'ŗ' => 'r', 'ſ' => 's', 'ŝ' => 's', 'ș' => 's',
            'š' => 's', 'ś' => 's', 'с' => 's', 'ş' => 's', 'ш' => 'sh', 'щ' => 'shch',
            'ß' => 'ss', 'ţ' => 't', 'т' => 't', 'ŧ' => 't', 'ť' => 't', 'ț' => 't',
            'у' => 'u', 'ǘ' => 'u', 'ŭ' => 'u', 'û' => 'u', 'ú' => 'u', 'ų' => 'u',
            'ù' => 'u', 'ű' => 'u', 'ů' => 'u', 'ư' => 'u', 'ū' => 'u', 'ǚ' => 'u',
            'ǜ' => 'u', 'ǔ' => 'u', 'ǖ' => 'u', 'ũ' => 'u', 'ü' => 'ue', 'в' => 'v',
            'ŵ' => 'w', 'ы' => 'y', 'ÿ' => 'y', 'ý' => 'y', 'ŷ' => 'y', 'ź' => 'z',
            'ž' => 'z', 'з' => 'z', 'ż' => 'z', 'ж' => 'zh'
                ))))), '-');
    }

    public function actionCekData() {
        if (Yii::app()->request->isPostRequest) {
            $model = Rku::model()->findAll(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
            if (empty($model)) {
                echo json_encode(array('hasil' => 'kosong'));
            } else {
                echo json_encode(array('hasil' => 'ada'));
            }
        }
    }

    protected function generatePrasyarat($id) {
        $jenisGanis = MasterJenisGanis::model()->findAll();
    //    $jenis_kawasan = MasterJenisKawasanLindung::model()->findAll();

        $ganis = RkuGanis::model()->findAll(array('condition' => 'id_rku = ' . $id));
       // $tataruang = RkuKawasanLindung::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $nonProduktif = RkuArealNonProduktif::model()->findAll(array('condition' => 'id_rku = ' . $id));

        if (empty($ganis)) {
            foreach ($jenisGanis as $jg) {
                // echo $this->cekLuas($iuphhk->luas, $jg->id);die;
                $ganis = new RkuGanis;
                $ganis->id_rku = $id;
                $ganis->id_ganis = $jg->id;
                $ganis->jumlah = $this->cekLuas($jg->id);
                $ganis->save();
            }
        }
        
//        print_r("<pre>");        
//        print_r($tataruang);
//        print_r("<pre>");
//        exit(1);
        
        
        //auto generate tata ruang
//        if (empty($tataruang)) {
//            foreach ($jenis_kawasan as $kws) {
//                $tataruang = new RkuKawasanLindung;
//                $tataruang->id_rku = $id;
//                $tataruang->id_jenis_kawasan_lindung = $kws->id;
//                $tataruang->jumlah=0;
//                $tataruang->save();
//            }
//        }
    }

    protected function revisiSilvikultur($id, $id_new) {
        $sisSilvi = RkuSistemSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $tansil = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $potensi = RkuPotensiProduksi::model()->findAll(array('condition' => 'id_rku = ' . $id));

        if (!empty($sisSilvi)) {
            foreach ($sisSilvi as $a) {
                $data = new RkuSistemSilvikultur;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($tansil)) {
            foreach ($tansil as $a) {
                $data = new RkuTanamanSilvikultur;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($potensi)) {
            foreach ($potensi as $a) {
                $data = new RkuPotensiProduksi;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
    }

    protected function revisiPrasyarat($id, $id_new) {
        $ganis = RkuGanis::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $tatabatas = RkuTataBatas::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $kawasanlindung = RkuKawasanLindung::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $arealNonEfektif = RkuArealNonProduktif::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $arealEfektif = RkuArealProduktif::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $arealKerja = RkuArealKerja::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $peralatan = RkuPeralatan::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $sarpras = RkuSarpras::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $pwh = RkuPwh::model()->findAll(array('condition' => 'id_rku = ' . $id));

        if (!empty($ganis)) {
            foreach ($ganis as $a) {
                $data = new RkuGanis;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($tatabatas)) {
            foreach ($tatabatas as $a) {
                $data = new RkuTataBatas;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($kawasanlindung)) {
            foreach ($kawasanlindung as $a) {
                $data = new RkuKawasanLindung;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($arealNonEfektif)) {
            foreach ($arealNonEfektif as $a) {
                $data = new RkuArealNonProduktif;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($arealEfektif)) {
            foreach ($arealEfektif as $a) {
                $data = new RkuArealProduktif;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($arealKerja)) {
            foreach ($arealKerja as $a) {
                $data = new RkuArealKerja;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($peralatan)) {
            foreach ($peralatan as $a) {
                $data = new RkuPeralatan;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($sarpras)) {
            foreach ($sarpras as $a) {
                $data = new RkuSarpras;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($pwh)) {
            foreach ($pwh as $a) {
                $data = new RkuPwh;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
    }
    
    protected function revisiBlokSektor($id,$id_new){
        $listSektor = RkuSektor::model()->findAll(array('condition'=>'id_rku ='.$id));  //list lama
        
        if(!empty($listSektor)){
            foreach($listSektor as $sektor){
                $newSektor = new RkuSektor;
                $newSektor->attributes = $sektor->attributes;
//                $newSektor->nama_sektor = $sektor->nama_sektor;
//                $newSektor->id_perusahaan = $sektor->id_perusahaan;
                $newSektor->id_rev = $sektor->id_sektor;
                $newSektor->id_rku = $id_new;
            
                if(!$newSektor->save()){
                     print_r($data->getErrors());
                     die;
                }
            }
        }
        
        $listBlok = RkuBlok::model()->findAll(array('condition'=>'id_rku ='.$id));  //list lama
        
         if(!empty($listBlok)){
            foreach($listBlok as $blok){
                $newBlok = new RkuBlok;
                $nSektor = RkuSektor::model()->find(array('condition'=>'id_rku ='.$id_new.' AND id_rev='.$blok->id_sektor));
                
                
                $newBlok->attributes = $blok->attributes;
                $newBlok->id_sektor = $nSektor->id_sektor;
                $newBlok->id_rku = $id_new;

                
//                 print_r($id_new);
//                print_r("<pre>");
//                            print_r($nSektor->id_sektor);
//                print_r("</pre>");
//                exit(1);
                if(!$newBlok->save()){
                     print_r($data->getErrors());
                     die;
                }
            }     
        }
        
        
    }
    
    

    protected function revisiKelestarian($id, $id_new) {
        $modelBibit = RkuBibitNew::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $modelSiapLahan = RkuPenyiapanLahan::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $modelTanam = RkuTanam::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $modelPelihara = RkuPelihara::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $modelPanen = RkuPanen::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $modelPasar = RkuPasar::model()->findAll(array('condition' => 'id_rku = ' . $id));

        if (!empty($modelBibit)) {
            $tansil = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $id_new));
            if (!empty($tansil)) {
                foreach ($tansil as $ts) {
                    foreach ($modelBibit as $a) {
                        $data = new RkuBibitNew;
                        $data->attributes = $a->attributes;
                        $data->id_rku = $id_new;
                        $data->id_tanaman_silvikultur = $ts->id;
                        if (!$data->save()) {
                            print_r($data->getErrors());
                            die;
                        }
                    }
                }
            }
        }
        if (!empty($modelSiapLahan)) {
            // $tansil = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $id_new));
            // if (!empty($tansil)) {
                // foreach ($tansil as $ts) {
                    foreach ($modelSiapLahan as $a) {
                        $data = new RkuPenyiapanLahan;
                        $data->attributes = $a->attributes;
                        $data->id_rku = $id_new;
                        // $data->id_tanaman_silvikultur = $ts->id;
                        if (!$data->save()) {
                            print_r($data->getErrors());
                            die;
                        }
                //     }
                // }
            }
        }
        if (!empty($modelTanam)) {
            //$tansil = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $id_new));
            //if (!empty($tansil)) {
                //foreach ($tansil as $ts) {
                    foreach ($modelTanam as $a) {
                        $data = new RkuTanam;
                        $data->attributes = $a->attributes;
                        $data->id_rku = $id_new;
                        //$data->id_tanaman_silvikultur = $ts->id;
                        if (!$data->save()) {
                            print_r($data->getErrors());
                            die;
                        }
                //     }
                // }
            }
        }
        if (!empty($modelPelihara)) {
            //$tansil = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $id_new));
            //if (!empty($tansil)) {
                //foreach ($tansil as $ts) {
                    foreach ($modelPelihara as $a) {
                        $data = new RkuPelihara;
                        $data->attributes = $a->attributes;
                        $data->id_rku = $id_new;
                        //$data->id_tanaman_silvikultur = $ts->id;
                        if (!$data->save()) {
                            print_r($data->getErrors());
                            die;
                        }
                //     }
                // }
            }
        }
        if (!empty($modelPanen)) {
            //$tansil = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $id_new));
            //if (!empty($tansil)) {
                //foreach ($tansil as $ts) {
                    foreach ($modelPanen as $a) {
                        $data = new RkuPanen;
                        $data->attributes = $a->attributes;
                        $data->id_rku = $id_new;
                        //$data->id_tanaman_silvikultur = $ts->id;
                        if (!$data->save()) {
                            print_r($data->getErrors());
                            die;
                        }
                //     }
                // }
            }
        }
        if (!empty($modelPasar)) {
            foreach ($modelPasar as $a) {
                $data = new RkuPasar;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
    }

    protected function revisiLingkungan($id, $id_new) {
        $hama = RkuHamaPenyakit::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $teknikdam = RkuTeknikPemadaman::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $alatdamkar = RkuAlatDamkar::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $rambahhutan = RkuPerambahanHutan::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $pantau = RkuPemantauanLingkungan::model()->findAll(array('condition' => 'id_rku = ' . $id));

        if (!empty($hama)) {
            foreach ($hama as $a) {
                $data = new RkuHamaPenyakit;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($teknikdam)) {
            foreach ($teknikdam as $a) {
                $data = new RkuTeknikPemadaman;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($alatdamkar)) {
            foreach ($alatdamkar as $a) {
                $data = new RkuAlatDamkar;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($rambahhutan)) {
            foreach ($rambahhutan as $a) {
                $data = new RkuPerambahanHutan;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($pantau)) {
            foreach ($pantau as $a) {
                $data = new RkuPemantauanLingkungan;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
    }

    protected function revisiFungsos($id, $id_new) {
        $inframukim = RkuInfraMukim::model()->findAll(array('condition' => 'id_rku = ' . $id));
        $lembaga = RkuKelembagaan::model()->findAll(array('condition' => 'id_rku = ' . $id));

        if (!empty($inframukim)) {
            foreach ($inframukim as $a) {
                $data = new RkuInfraMukim;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
        if (!empty($lembaga)) {
            foreach ($lembaga as $a) {
                $data = new RkuKelembagaan;
                $data->attributes = $a->attributes;
                $data->id_rku = $id_new;
                if (!$data->save()) {
                    print_r($data->getErrors());
                    die;
                }
            }
        }
    }

    protected function revisiRkt($id, $id_new,$idRkt=0, $m = '') {
        $rkt;
        
        if($idRkt==0){
            $rkt = Rkt::model()->getLastRkt($id);
        }else{
            $rkt = Rkt::model()->findByPk($idRkt);
        }
            
        
        

        
        if ($rkt) {
            //foreach ($rkt as $dt) {
                $data = new Rkt;
                $data->attributes = $rkt->attributes;
                $data->id_rku = $id_new;
                
//        print_r("<pre>");
//        print_r($data);
//        print_r("</pre>");die;
                
                
                if (isset($idRev)) {
                    $data->id_rev = $idRev;
                }
                if ($data->save()) {
                    $idRev = $data->id;
                    $this->revisiRktGanis($rkt->id, $data->id);
                    $this->revisiRktBibit($rkt->id, $data->id);
                    $this->revisiRktDungtan($rkt->id, $data->id);
                    $this->revisiRktInfraMukim($rkt->id, $data->id);
                    // $this->revisiProgresTataBatas($dt->id, $data->id);
                    $simpan = ' Data RKT sukses dimuat kembali.';
                } else {
                    print_r($data->getErrors());
                    die;
                }
        }
            return $simpan;
        
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

    protected function revisiRktGanis($rkt_id, $rkt_new_id) {
        $ganis = RktGanis::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $tatabatas = RktTataBatas::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $tataruang = RktKawasanLindung::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $arealNonProduktif = RktArealNonProduktif::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $arealProduktif = RktArealProduktif::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $arealKerja = RktArealKerja::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $invent = RktInventarisasi::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $pwh = RktPwh::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $masukGunaAlat = RktMasukGunaAlat::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $bangunSarpras = RktSarpras::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));

        foreach ($ganis as $gn) {
            $data = new RktGanis;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($tatabatas as $gn) {
            $data = new RktTataBatas;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($tataruang as $gn) {
            $data = new RktKawasanLindung;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($arealNonProduktif as $gn) {
            $data = new RktArealNonProduktif;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($arealProduktif as $gn) {
            $data = new RktArealProduktif;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($arealKerja as $gn) {
            $data = new RktArealKerja;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($pwh as $gn) {
            $data = new RktPwh;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($masukGunaAlat as $gn) {
            $data = new RktMasukGunaAlat;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($bangunSarpras as $gn) {
            $data = new RktSarpras;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
    }

    protected function revisiRktBibit($rkt_id, $rkt_new_id) {
        $bibit = RktBibit::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $siapLahan = RktSiapLahan::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $tanam = RktTanam::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $sulam = RktSulam::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $jarang = RktJarang::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $dangir = RktDangir::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $panenAreal = RktPanenAreal::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $panenTanaman = RktPanenVolumeTanaman::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $panenSiapLahan = RktPanenVolumeSiapLahan::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $pasar = RktPasar::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));

        foreach ($bibit as $gn) {
            $data = new RktBibit;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($siapLahan as $gn) {
            $data = new RktSiapLahan;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($tanam as $gn) {
            $data = new RktTanam;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($sulam as $gn) {
            $data = new RktSulam;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($jarang as $gn) {
            $data = new RktJarang;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($dangir as $gn) {
            $data = new RktDangir;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($panenAreal as $gn) {
            $data = new RktPanenAreal;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($panenTanaman as $gn) {
            $data = new RktPanenVolumeTanaman;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($panenSiapLahan as $gn) {
            $data = new RktPanenVolumeSiapLahan;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
        foreach ($pasar as $gn) {
            $data = new RktPasar;
            $data->attributes = $gn->attributes;
            $data->id_rkt = $rkt_new_id;
            $data->save();
        }
    }

    protected function revisiRktDungtan($rkt_id, $rkt_new_id) {
        $dungtan = RktLingkunganDungtan::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $dalmakit = RktLingkunganDalmakit::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $dalkar = RktLingkunganDalkar::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $pantau = RktPemantauanLingkungan::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));

        if (!empty($dungtan)) {
            foreach ($dungtan as $gn) {
                $data = new RktLingkunganDungtan;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if (!empty($dalmakit)) {
            foreach ($dalmakit as $gn) {
                $data = new RktLingkunganDalmakit;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if (!empty($dalkar)) {
            foreach ($dalkar as $gn) {
                $data = new RktLingkunganDalkar;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if (!empty($pantau)) {
            foreach ($pantau as $gn) {
                $data = new RktPemantauanLingkungan;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
    }

    protected function revisiRktInfraMukim($rkt_id, $rkt_new_id) {
        $inframukim = RktInfraMukim::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $sdm = RktPeningkatanSdm::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $kerjasama = RktKerjasamaKoperasi::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $bangunMitra = RktBangunMitra::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));
        $konflik = RktKonflikSosial::model()->findAll(array('condition' => 'id_rkt = ' . $rkt_id));

        if (!empty($inframukim)) {
            foreach ($inframukim as $gn) {
                $data = new RktInfraMukim;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if (!empty($sdm)) {
            foreach ($sdm as $gn) {
                $data = new RktPeningkatanSdm;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if (!empty($kerjasama)) {
            foreach ($kerjasama as $gn) {
                $data = new RktKerjasamaKoperasi;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if (!empty($bangunMitra)) {
            foreach ($bangunMitra as $gn) {
                $data = new RktBangunMitra;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
        if (!empty($konflik)) {
            foreach ($konflik as $gn) {
                $data = new RktKonflikSosial;
                $data->attributes = $gn->attributes;
                $data->id_rkt = $rkt_new_id;
                $data->save();
            }
        }
    }

    // protected function revisiProgresTataBatas($rkt_id, $rkt_new_id) {
    //     $tatabatas = ProgresTataBatas::model()->find(array('condition' => 'id_rkt = ' . $rkt_id));
    //     if (!empty($tatabatas)) {
    //         $data = new ProgresTataBatas;
    //         $data->attributes = $tatabatas->attributes;
    //         $data->id_rkt = $rkt_new_id;
    //         if (!$data->save()) {
    //             print_r($data->getErrors());
    //             die;
    //         }
    //     }
    // }

    protected function revisiKinerja($rkt_id, $rkt_new_id) {
        $kinerja = PenilaianKinerja::model()->find(array(
            'condition' => 'id_rkt=' . $rkt_new_id->id . ' AND id_perusahaan=' . Yii::app()->user->idPerusahaan()
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
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_perusahaan = ' . $iup->id_perusahaan . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $s_silvikultur = RkuSistemSilvikultur::model()->find(array('condition' => 'id_rku=' . $rku->id_rku));
            if (is_null($s_silvikultur))
                $s_silvikultur = new RkuSistemSilvikultur;

            $tanaman = new RkuTanamanSilvikultur('search');
            $tanaman->unsetAttributes();
            $tanaman->id_rku = $rku->id_rku;

            $potensiProduksi = RkuPotensiProduksi::model()->find(array('condition' => 'id_rku=' . $rku->id_rku));
            if (is_null($potensiProduksi))
                $potensiProduksi = new RkuPotensiProduksi;
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/' . $id));
        }

        $this->render('sisil/index', array(
            // 'iup' => $iup,
            'model' => $rku,
            'silvikultur' => $s_silvikultur,
            'tanaman' => $tanaman,
            'potensiProduksi' => $potensiProduksi
        ));
    }

    public function actionViewPrasyarat($id) {
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $idRku = $rku->id_rku;

            $ganis = RkuGanis::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
            if (empty($ganis)) {
                foreach ($jenisGanis as $jg) {
                    $gans = new RkuGanis;
                    $gans->id_rku = $rku->id_rku;
                    $gans->id_ganis = $jg->id;
                    $gans->jumlah = $this->cekLuas($jg->id, $id);
                    $gans->save(false);
                }
            } else {
                foreach ($ganis as $jg) {
                    $gan = RkuGanis::model()->find(array('condition' => 'id_rku = ' . $rku->id_rku . ' AND id_ganis = ' . $jg->id_ganis));
                    $gan->jumlah = $this->cekLuas($jg->id_ganis, $id);
                    $gan->update(array('jumlah'));
                }
            }
            $modelGanis = new RkuSerapanTenagaKerja;
            $modelGanis->unsetAttributes();
            if (isset($_GET['RkuSerapanTenagaKerja']))
                $modelGanis->attributes = $_GET['RkuSerapanTenagaKerja'];
            $modelGanis->id_rku = $rku->id_rku;

            $modelTataBatas = new RkuTataBatas;
            $modelTataBatas->unsetAttributes();
            if (isset($_GET['RkuTataBatas']))
                $modelTataBatas->attributes = $_GET['RkuTataBatas'];
            $modelTataBatas->id_rku = $rku->id_rku;

            $modelKawasan = new RkuKawasanLindung;
            $modelKawasan->unsetAttributes();
            if (isset($_GET['RkuKawasanLindung']))
                $modelKawasan->attributes = $_GET['RkuKawasanLindung'];
            $modelKawasan->id_rku = $rku->id_rku;

            $modelArealNonProduktif = new RkuArealNonProduktif;
            $modelArealNonProduktif->unsetAttributes();
            if (isset($_GET['RkuArealNonProduktif']))
                $modelArealNonProduktif->attributes = $_GET['RkuArealNonProduktif'];
            $modelArealNonProduktif->id_rku = $rku->id_rku;

            $modelArealProduktif = new RkuArealProduktif('search');
            $modelArealProduktif->unsetAttributes();
            if (isset($_GET['RkuArealProduktif']))
                $modelArealProduktif->attributes = $_GET['RkuArealProduktif'];
            $modelArealProduktif->id_rku = $rku->id_rku;

            $modelArealKerja = new RkuArealKerja;
            $modelArealKerja->unsetAttributes();
            if (isset($_GET['RkuArealKerja']))
                $modelArealKerja->attributes = $_GET['RkuArealKerja'];
            $modelArealKerja->id_rku = $rku->id_rku;

            $modelPwh = new RkuPwh;
            $modelPwh->unsetAttributes();
            if (isset($_GET['RkuPwh']))
                $modelPwh->attributes = $_GET['RkuPwh'];
            $modelPwh->id_rku = $rku->id_rku;

            $peralatan = new RkuPeralatan;
            $peralatan->unsetAttributes();
            if (isset($_GET['RkuPeralatan']))
                $peralatan->attributes = $_GET['RkuPeralatan'];
            $peralatan->id_rku = $rku->id_rku;

            $sarpras = new RkuSarpras;
            $sarpras->unsetAttributes();
            if (isset($_GET['RkuSarpras']))
                $sarpras->attributes = $_GET['RkuSarpras'];
            $sarpras->id_rku = $rku->id_rku;
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/' . $id));
        }

        $this->render('prasyarat/index', array(
            // 'iup' => $iup,
            'model' => $rku,
            'ganis' => $modelGanis,
            'tatabatas' => $modelTataBatas,
            'tataruang' => $modelKawasan,
            'arealProduktif' => $modelArealProduktif,
            'arealKerja' => $modelArealKerja,
            'arealNonProduktif' => $modelArealNonProduktif,
            'pwh' => $modelPwh,
            'idRku' => $idRku,
            'peralatan' => $peralatan,
            'sarpras' => $sarpras
        ));
    }

    public function actionViewProduksi($id) {
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {

            $modelBibit = new RkuBibit();
            $modelBibit->unsetAttributes();
            if (isset($_GET['RkuBibit']))
                $modelBibit->attributes = $_GET['RkuBibit'];
            $modelBibit->id_rku = $rku->id_rku;

            $siapLahan = new RkuPenyiapanLahan('search');
            $siapLahan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPenyiapanLahan']))
                $siapLahan->attributes = $_GET['RkuPenyiapanLahan'];
            $siapLahan->id_rku = $rku->id_rku;

            $penanaman = new RkuTanam('search');
            $penanaman->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuTanam']))
                $penanaman->attributes = $_GET['RkuTanam'];
            $penanaman->id_rku = $rku->id_rku;

            $pemeliharaan = new RkuPelihara('search');
            $pemeliharaan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPelihara']))
                $pemeliharaan->attributes = $_GET['RkuPelihara'];
            $pemeliharaan->id_rku = $rku->id_rku;

            $panen = new RkuPanen('search');
            $panen->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPanen']))
                $panen->attributes = $_GET['RkuPanen'];
            $panen->id_rku = $rku->id_rku;

            $hhbk = new RkuHasilHutanNonkayu('search');
            $hhbk->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuHasilHutanNonkayu']))
                $hhbk->attributes = $_GET['RkuHasilHutanNonkayu'];
            $hhbk->id_rku = $rku->id_rku;
            
            $pasar = new RkuPasar('search');
            $pasar->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPasar']))
                $pasar->attributes = $_GET['RkuPasar'];
            $pasar->id_rku = $rku->id_rku;
            
            $pasarHhbk = new RkuPasarHhbk('search');
            $pasarHhbk->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPasarHhbk']))
                $pasarHhbk->attributes = $_GET['RkuPasarHhbk'];
            $pasarHhbk->id_rku = $rku->id_rku;
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rku/' . $id));
        }

        $this->render('produksi/index', array(
            'model' => $rku,
            'modelBibit' => $modelBibit,
            'siapLahan' => $siapLahan,
            'penanaman' => $penanaman,
            'pemeliharaan' => $pemeliharaan,
            'panen' => $panen,
            'hhbk' => $hhbk,
            'pasar' => $pasar,
            'pasarHhbk' => $pasarHhbk,
        ));
    }

    public function actionViewLingkungan($id) {
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $idRku = $rku->id_rku;

            $hamkit = new RkuHamaPenyakit('search');
            $hamkit->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuHamaPenyakit']))
                $hamkit->attributes = $_GET['RkuHamaPenyakit'];
            $hamkit->id_rku = $rku->id_rku;

            $tekdam = new RkuTeknikPemadaman('search');
            $tekdam->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuTeknikPemadaman']))
                $tekdam->attributes = $_GET['RkuTeknikPemadaman'];
            $tekdam->id_rku = $rku->id_rku;

            $alatDamkar = new RkuAlatDamkar('search');
            $alatDamkar->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuAlatDamkar']))
                $alatDamkar->attributes = $_GET['RkuAlatDamkar'];
            $alatDamkar->id_rku = $rku->id_rku;

            $perambahan = new RkuPerambahanHutan('search');
            $perambahan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPerambahanHutan']))
                $perambahan->attributes = $_GET['RkuPerambahanHutan'];
            $perambahan->id_rku = $rku->id_rku;

            $perlindungan = new RkuPerlindunganHutan('search');
            $perlindungan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPerlindunganHutan']))
                $perlindungan->attributes = $_GET['RkuPerlindunganHutan'];
            $perlindungan->id_rku = $rku->id_rku;
            
            $pemantauan = new RkuPemantauanLingkungan('search');
            $pemantauan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPemantauanLingkungan']))
                $pemantauan->attributes = $_GET['RkuPemantauanLingkungan'];
            $pemantauan->id_rku = $rku->id_rku;
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/' . $id));
        }

        $this->render('lingkungan/index', array(
            'model' => $rku,
            'hamkit' => $hamkit,
            'tekdam' => $tekdam,
            'alatDamkar' => $alatDamkar,
            'perambahan' => $perambahan,
            'pemantauan' => $pemantauan,
            'perlindungan' => $perlindungan,
        ));
    }

    public function actionViewSosial($id) {
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $idRku = $rku->id_rku;

            $mukim = new RkuInfraMukim('search');
            $mukim->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuInfraMukim']))
                $mukim->attributes = $_GET['RkuInfraMukim'];
            $mukim->id_rku = $rku->id_rku;

            $lembaga = new RkuKelembagaan('search');
            $lembaga->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuKelembagaan']))
                $lembaga->attributes = $_GET['RkuKelembagaan'];
            $lembaga->id_rku = $rku->id_rku;
            
            $fungsos = new RkuFungsos('search');
            $fungsos->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuFungsos']))
            $fungsos->attributes = $_GET['RkuFungsos'];
            $fungsos->id_rku = $rku->id_rku;
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/' . $id));
        }

        $this->render('sosial/index', array(
            'model' => $rku,
            'mukim' => $mukim,
            'lembaga' => $lembaga,
            'fungsos' => $fungsos,
        ));
    }

    public function actionRktIndex($id) {
        $rku = Rku::model()->findByPk($id);
        // $rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku = '.$id));
        $rkt = new Rkt;
        $rkt->unsetAttributes();
        if (isset($_GET['Rkt']))
            $rkt->attributes = $_GET['Rkt'];
        $rkt->id_rku = $id;
        $this->render('rkt/index', array(
            'model' => $rkt,
            'rku' => $rku
        ));
    }

    public function actionDetailRkt($id) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.perusahaan.controllers.RktController');
        RktController::actionIndexRev($id);
    }

    public function actionRktIndexRev($id) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.perusahaan.controllers.RktController');
        RktController::actionIndexRev($id);
    }

    public function actionRktProduksiRev($id) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.perusahaan.controllers.RktController');
        RktController::actionRevProduksi($id);
    }

    public function actionRktLingkunganRev($id) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.perusahaan.controllers.RktController');
        RktController::actionRevLingkungan($id);
    }

    public function actionRktSosialRev($id) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.perusahaan.controllers.RktController');
        RktController::actionRevSosial($id);
    }

}
