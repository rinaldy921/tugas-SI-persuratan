<?php

class RktGanisController extends Controller {

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
                    'createGanis',
                    'updateGanis',
                    'delGanis',
                    'deleteMasukGunaAlat',
                    'deleteSarpras',
                    'createTataBatas',
                    'updateTataBatas',
                    'inputJumlah',
                    'inputJumlahArealNonProduktif',
                    'inputJumlahArealProduktif',
                    'inputJumlahArealKerja',
                    'inputJumlahInventarisasi',
                    'inputJumlahPwh',
                    'inputJumlahGanis',
                    'inputJumlahTataBatas',
                    'inputJumlahKawasanLindung',
                    'inputJumlahMasukGunaAlat',
                    'inputJumlahBangunSarpras',
					'index_areal_kerja',
					'createpwh',
					'deletepwh',
					'createGanisAjax',
					'deleteganisajax',
					'createalat',
					'createsarana',
					'createkawasanlindung',
					'deletekawasanlindung',
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

    public function actionCreateGanis() {
        $idRkt = Rkt::model()->find(array('condition' => "id_perusahaan = " . Yii::app()->user->idPerusahaan()));
        if (isset($idRkt)) {
            $id_rkt = $idRkt->id;
        }
        $model = new RktGanis;

        if (isset($_POST['RktGanis'])) {
            $model->attributes = $_POST['RktGanis'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create_ganis', array(
            'model' => $model,
            'idRkt' => $id_rkt
        ));
    }

    public function actionCreateTataBatas() {
        $idRkt = Rkt::model()->find(array('condition' => "id_perusahaan = " . Yii::app()->user->idPerusahaan()));
        if (isset($idRkt)) {
            $id_rkt = $idRkt->id;
        }
        $model = new RktTataBatas;

        if (isset($_POST['RktTataBatas'])) {
            $model->attributes = $_POST['RktTataBatas'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create_tatabatas', array(
            'model' => $model,
            'idRkt' => $id_rkt
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateGanis($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RktGanis'])) {
            $model->attributes = $_POST['RktGanis'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('updateGanis', array(
            'model' => $model,
        ));
    }

    public function actionUpdateTataBatas($id) {
        $model = RktTataBatas::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RktTataBatas'])) {
            $model->attributes = $_POST['RktTataBatas'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('updateTataBatas', array(
            'model' => $model,
        ));
    }

    public function actionDelGanis($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadGanis($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    // public function actionDelKomisaris($id) {
    //     if (Yii::app()->request->isPostRequest) {
    //         $this->loadKomisaris($id)->delete();
    //         if (!isset($_GET['ajax']))
    //             $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    //     } else
    //         throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    // }

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

    public function actionDeleteMasukGunaAlat($id) {
        // var_dump($id);die;
        $model = RktMasukGunaAlat::model()->findByPk($id);
        if (Yii::app()->request->isAjaxRequest) {
            if ($model->delete()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil dihapus'));
                echo CJSON::encode(array('status' => 'success'));
                Yii::app()->end();
            }
        }
    }

    public function actionDeleteSarpras($id) {
        // var_dump($id);die;
        $model = RktSarpras::model()->findByPk($id);
        if (Yii::app()->request->isAjaxRequest) {
            if ($model->delete()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil dihapus'));
                echo CJSON::encode(array('status' => 'success'));
                Yii::app()->end();
            }
        }
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku . ' AND status = 1', 'order' => 'tahun_mulai DESC'));
        if (!isset($rkt)) {
            $message = Yii::t('app', 'Data RKT belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
        }
        // $tahun = Rkt::model()->find(array('select'=>'distinct tahun_mulai','order'=>'tahun_mulai ASC','condition'=>'id_perusahaan = '.$model->id_perusahaan));
//        $tahun = $rkt->tahun_mulai;
        $tahun = $rkt->rkt_ke;
        
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku . ' AND status = 1 AND rkt_ke = ' . $_POST['Rkt']['tahun_mulai'], 'order' => 'tahun_mulai DESC'));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rkt/index'));
            }
//            $tahun = $rkt->tahun_mulai;
            $tahun = $rkt->rkt_ke;
        }
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['aksi']) && $_GET['aksi'] === 'updateGrid') {
                $tahun = $_GET['tahun'];
                $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND status = 1 AND rkt_ke = ' . $tahun . ' AND id_rku = ' . $rku->id_rku, 'order' => 'tahun_mulai DESC'));
                $tahun = $tahun;
            }
        }
        $bloksektor = BlokSektor::model()->findAll(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $jenisProduksiLahan = MasterJenisProduksiLahan::model()->findAll();
        $jenisPwh = MasterJenisPwh::model()->findAll();
        $jenisPeralatan = MasterJenisPeralatan::model()->findAll(array('condition' => 'id_perusahaan = 0'));
        $jenisSarpras = MasterJenisSarpras::model()->findAll(array('condition' => 'id_perusahaan = 0'));
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $jenisBatas = MasterJenisBatas::model()->findAll();
        // $iuphhk = Iuphhk::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
        if (isset($rkt)) {
            $idRkt = $rkt->id;
            $ganis = RktGanis::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $tatabatas = RktTataBatas::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $tataruang = RktKawasanLindung::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $arealNonProduktif = RktArealNonProduktif::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $arealProduktif = RktArealProduktif::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $arealKerja = RktArealKerja::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $invent = RktInventarisasi::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $pwh = RktPwh::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $masukGunaAlat = RktMasukGunaAlat::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            $bangunSarpras = RktSarpras::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));

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

			// hide karena udah di ajax in
            /* $modelArealKerja = new RktArealKerja;
            $modelArealKerja->unsetAttributes();
            if (isset($_GET['RktArealKerja']))
                $modelArealKerja->attributes = $_GET['RktArealKerja'];
            $modelArealKerja->id_rkt = $rkt->id; */

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

            $ganis = RktGanis::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            if (!empty($ganis)) {
                foreach ($ganis as $gn) {
                    $id_ganis[] = $gn->id_ganis;
                    $luas = $this->cekLuas($gn->id_ganis);
                    // var_dump($gn->jumlah);
                    // var_dump($luas);
                    // die;
                    if (!empty($luas)) {
                        if ($gn->jumlah !== $luas) {
                            // echo 'here';
                            $updateGanis = RktGanis::model()->findByPk($gn->id);
                            // $updateGanis->id_rkt = $rkt->id;
                            // $updateGanis->unsetAttributes();
                            $updateGanis->jumlah = $luas;
                            // $updateGanis->save();
                            // echo $updateGanis->jumlah;die;
                            if ($updateGanis->save()) {
                                // echo 'saved';
                            } else {
                                var_dump($updateGanis->getErrors());
                                die;
                            }
                        }
                    }
                }
                $jenisGanisz = MasterJenisGanis::model()->findAll('id NOT IN (' . implode(',', $id_ganis) . ')');
                if (!empty($jenisGanisz)) {
                    foreach ($jenisGanisz as $jgn) {
                        $ganis = new RktGanis;
                        $ganis->id_rkt = $rkt->id;
                        $ganis->id_ganis = $jgn->id;
                        $ganis->jumlah = floatval($this->cekLuas($jgn->id));
                        $ganis->save();
                    }
                }
            }

            $tatabatas = RktTataBatas::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            // var_dump($tatabatas);die;
            
            /* if (!empty($tatabatas)) {
                foreach ($tatabatas as $tb) {
                    $id_tatabatas[] = $tb->id_jenis_batas;
                }
                $jenisTataBatasz = MasterJenisBatas::model()->findAll('id NOT IN (' . implode(',', $id_tatabatas) . ')');
                if (!empty($jenisTataBatasz)) {
                    foreach ($jenisTataBatasz as $jtb) {
                        $tatabatas = new RktTataBatas;
                        $tatabatas->id_rkt = $rkt->id;
                        $tatabatas->id_jenis_batas = $jtb->id;
                        $tatabatas->save();
                    }
                }
            } */

            $masukGunaAlat = RktMasukGunaAlat::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            // if (!empty($masukGunaAlat)) {
            //     foreach ($masukGunaAlat as $tt) {
            //         $id_masukgunaalat[] = $tt->id_jenis_peralatan;
            //     }
            //     $jenisPer = MasterJenisPeralatan::model()->findAll('id NOT IN (' . implode(',', $id_masukgunaalat) . ') AND id_perusahaan = "0"');
            //     // var_dump($jenisPer);die;
            //     if (!empty($jenisPer)) {
            //         foreach ($jenisPer as $jpr) {
            //             $masukGunaAlat = new RktMasukGunaAlat;
            //             $masukGunaAlat->id_rkt = $rkt->id;
            //             $masukGunaAlat->id_jenis_peralatan = $jpr->id;
            //             $masukGunaAlat->save();
            //         }
            //     }
            // }

            $bangunSarpras = RktSarpras::model()->findAll(array('condition' => 'id_rkt = ' . $rkt->id));
            // if (!empty($bangunSarpras)) {
            //     foreach ($bangunSarpras as $bsp) {
            //         $id_bangunsarpras[] = $bsp->id_jenis_sarpras;
            //     }
            //     $jenisSarp = MasterJenisSarpras::model()->findAll('id NOT IN (' . implode(',', $id_bangunsarpras) . ') AND id_perusahaan = "0"');
            //     if (!empty($jenisSarp)) {
            //         foreach ($jenisSarp as $jsp) {
            //             $bangunSarpras = new RktSarpras;
            //             $bangunSarpras->id_rkt = $rkt->id;
            //             $bangunSarpras->id_jenis_sarpras = $jsp->id;
            //             $bangunSarpras->save();
            //         }
            //     }
            // }
            $modelMasterJenisPeralatan = new MasterJenisPeralatan;
            $modelMasterJenisSarpras = new MasterJenisSarpras;
            
//            print_r($_POST);
            if (isset($_POST['MasterJenisPeralatan'])) {
                $modelMasterJenisPeralatan->attributes = $_POST['MasterJenisPeralatan'];
                if ($modelMasterJenisPeralatan->save()) {
                    $jenisPer2 = MasterJenisPeralatan::model()->findByPk($modelMasterJenisPeralatan->id);
                    // foreach($jenisPer2 as $jpr) {
                    $masukGunaAlat = new RktMasukGunaAlat;
                    $masukGunaAlat->id_rkt = $rkt->id;
                    $masukGunaAlat->id_jenis_peralatan = $jenisPer2->id;
                    $masukGunaAlat->save();
                    // }
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($modelMasterJenisPeralatan);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

            if (isset($_POST['MasterJenisSarpras'])) {
                $modelMasterJenisSarpras->attributes = $_POST['MasterJenisSarpras'];
                if ($modelMasterJenisSarpras->save()) {
                    $jenisSarp2 = MasterJenisSarpras::model()->findByPk($modelMasterJenisSarpras->id);
                    // foreach($jenisSarp as $jsp) {
                    $bangunSarpras = new RktSarpras;
                    $bangunSarpras->id_rkt = $rkt->id;
                    $bangunSarpras->id_jenis_sarpras = $jenisSarp2->id;
                    $bangunSarpras->save();
                    // }
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($modelMasterJenisSarpras);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

            $modelMasukGunaAlat = new RktMasukGunaAlat('cari');
            $modelMasukGunaAlat->unsetAttributes();
            if (isset($_GET['RktMasukGunaAlat']))
                $modelMasukGunaAlat->attributes = $_GET['RktMasukGunaAlat'];
            $modelMasukGunaAlat->id_rkt = $rkt->id;

            $modelBangunSarpras = new RktSarpras;
            $modelBangunSarpras->unsetAttributes();
            if (isset($_GET['RktSarpras']))
                $modelBangunSarpras->attributes = $_GET['RktSarpras'];
            $modelBangunSarpras->id_rkt = $rkt->id;

            // $arealNonProduktif = RktArealNonProduktif::model()->findAll(array('condition'=>'id_rkt = '. $idRkt));
            // if(empty($arealNonProduktif)) {
            // 	$arealNonProduktif = new RktArealNonProduktif;
            // 	$arealNonProduktif->id_rkt = $rkt->id;
            // }
            // $arealProduktif = new RktArealProduktif('search');
            // $arealProduktif->unsetAttributes();
            // $arealProduktif->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Silahkan isi RKT terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
        }

        // var_dump($rktKawasanLindung);die;
        if (isset($_POST['RktKawasanLindung'])) {
            $tataruang->attributes = $_POST['RktKawasanLindung'];
            // $pos = $_POST['RktArealProduktif'];
            // // $blok = $pos['idBlok'];
            // var_dump($pos);die;
            // // echo $blok;die;
            // // var_dump($_POST['RktKawasanLindung']);die;
            // foreach($blok as $key => $bk) {
            // 	$kwsLindung = RktKawasanLindung::model()->find(array('condition'=>'id_rkt = '. $pos['id_rkt']));
            // 	if(!$kwsLindung) {
            // 		$kwsLindung = new RktKawasanLindung;
            // 		$kwsLindung->id_rkt = $pos['id_rkt'];
            // 		$kwsLindung->id_blok = $bk;
            // 		$kwsLindung->jumlah = $pos['blokKawasanLindung'][$key];
            // 		$kwsLindung->realisasi = $pos['realisasiKawasanLindung'][$key];
            // 		$kwsLindung->save();
            // 	}
            // }
        }

        $this->render('index', array(
            'model' => $rkt,
            'tahun' => $tahun,
            'ganis' => $modelGanis,
            'tatabatas' => $modelTataBatas,
            'tataruang' => $modelKawasan,
            // 'model_kawasan_lindung'=>$model2,
            'arealProduktif' => $modelArealProduktif,
            //'arealKerja' => $modelArealKerja, // hide karena udah di ajax in
            'arealNonProduktif' => $modelArealNonProduktif,
            'inventarisasi' => $modelInventarisasi,
            'pwh' => $modelPwh,
            'masukGunaAlat' => $modelMasukGunaAlat,
            'modelMasterJenisPeralatan' => $modelMasterJenisPeralatan,
            'modelMasterJenisSarpras' => $modelMasterJenisSarpras,
            'bangunSarpras' => $modelBangunSarpras,
            'bloksektor' => $bloksektor,
            'idRkt' => $idRkt,
            'idRku' => $rku->id_rku
        ));
    }
	
	
	public function actionCreatepwh($rkt) {
        //debug($rkt);
        $model = new RktPwh;
       
        
        if (isset($_POST['RktPwh'])) {
            $model->attributes = $_POST['RktPwh'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
       
    }
	
	public function actionCreatekawasanlindung($rkt) {
        //debug($rkt);
        $model = new RktKawasanLindung;
       
        
        if (isset($_POST['RktKawasanLindung'])) {
            $model->attributes = $_POST['RktKawasanLindung'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
       
    }
	
	public function actionCreatealat($rkt) {
        //debug($rkt);
        $model = new RktMasukGunaAlat;
       
        
        if (isset($_POST['RktMasukGunaAlat'])) {
            $model->attributes = $_POST['RktMasukGunaAlat'];
			$model->id_rkt = $rkt;
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
       
    }
	
	public function actionCreatesarana($rkt) {
        //debug($rkt);
        $model = new RktSarpras;
       
        
        if (isset($_POST['RktSarpras'])) {
            $model->attributes = $_POST['RktSarpras'];
			$model->id_rkt = $rkt;
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
       
    }
	
	public function actionCreateGanisAjax($rkt) {
        //debug($rkt);
        $model = new RktGanis;
       
        
        if (isset($_POST['RktGanis'])) {
            $model->attributes = $_POST['RktGanis'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
       
    }
	
	public function actionDeletepwh($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            RktPwh::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
	
	public function actionDeletekawasanlindung($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            RktKawasanLindung::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
	
	public function actionDeleteganisajax($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            RktGanis::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
	
	
	
	
	public function actionIndex_areal_kerja($tahun,$idRkt) {
		 	
		$modelArealKerja = new RktArealKerja;
		$modelArealKerja->unsetAttributes();
		if (isset($_GET['RktArealKerja']))
			$modelArealKerja->attributes = $_GET['RktArealKerja'];
		$modelArealKerja->id_rkt = $idRkt;
		
		 
		$this->renderPartial('_index_areal_kerja', array('tahun' => $tahun, 'model' => $modelArealKerja),false,true);
	}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
// public function loadModel($id)
// {
// $model=RktGanis::model()->findByPk($id);
// if($model===null)
// throw new CHttpException(404,'The requested page does not exist.');
// return $model;
// }

    public function actionInputJumlahGanis() {
        $post = $_POST['pk'];
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktGanis');
        $model->update();
        $md = RktGanis::model()->findByPk($post);
        if (isset($md->realisasi) && $md->realisasi > 0) {
            $coba = ($md->realisasi / $md->jumlah) * 100;
            $md->persentase = str_replace(',', '.', $coba);
            $md->save();
        }
        if (empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahTataBatas() {
        $post = $_POST['pk'];
        $md = RktTataBatas::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktTataBatas');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }
        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }
        $md = RktTataBatas::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function actionInputJumlahKawasanLindung() {
        $post = $_POST['pk'];
        $md = RktKawasanLindung::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktKawasanLindung');

        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }

        $md = RktKawasanLindung::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function actionInputJumlah() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktKawasanLindung');
        $model->update();
    }

    public function actionInputJumlahArealNonProduktif() {
        $post = $_POST['pk'];
        $md = RktArealNonProduktif::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktArealNonProduktif');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }

        $md = RktArealNonProduktif::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function actionInputJumlahArealProduktif() {
        $post = $_POST['pk'];
        $md = RktArealProduktif::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktArealProduktif');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }

        $md = RktArealProduktif::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function actionInputJumlahArealKerja() {
        $post = $_POST['pk'];
        $md = RktArealKerja::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktArealKerja');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }

        $md = RktArealKerja::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function actionInputJumlahInventarisasi() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktInventarisasi');
        $model->update();
    }

    public function actionInputJumlahPwh() {
        $post = $_POST['pk'];
        $md = RktPwh::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPwh');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }

        $md = RktPwh::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function actionInputJumlahMasukGunaAlat() {
//        print_r($_POST);
        
        $post = $_POST['pk'];
        $md = RktMasukGunaAlat::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktMasukGunaAlat');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }

        $md = RktMasukGunaAlat::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function actionInputJumlahBangunSarpras() {
        $post = $_POST['pk'];
        $md = RktSarpras::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktSarpras');
        if ($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');
            die;
        } elseif ($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');
            die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        // 	$md->jumlah = 0;
        // 	$md->realisasi = 0;
        // 	$md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        // 	$md->jumlah = null;
        // 	$md->realisasi = null;
        // 	$md->save();
        // }

        $md = RktSarpras::model()->findByPk($post);
        if (!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if (isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            // 	$coba = '100.00';
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

    public function loadGanis($id) {
        $model = RktGanis::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rkt-ganis-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
