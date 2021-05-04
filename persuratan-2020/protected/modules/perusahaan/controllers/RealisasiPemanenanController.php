<?php

class RealisasiPemanenanController extends Controller
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='//layouts/column2';

/**
* @return array action filters
*/
public function filters()
{
	return array(
		'accessControl', // perform access control for CRUD operations
	);
}

	public function accessRules() {
        return array(
            array(
				'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
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
                    'inputJumlahPasar'
                ),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array(
				'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

/**
* Displays a particular model.
* @param integer $id the ID of the model to be displayed
*/
public function actionView($id)
{
$this->render('view',array(
'model'=>$this->loadModel($id),
));
}

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
$model=new RktBibit;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['RktBibit']))
{
$model->attributes=$_POST['RktBibit'];
if($model->save()){
$message = Yii::t('app', 'Data berhasil disimpan.');
Yii::app()->user->setFlash('success', $message);
$this->redirect(array('index'));
}
}

$this->render('create',array(
'model'=>$model,
));
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id)
{
$model=$this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['RktBibit']))
{
$model->attributes=$_POST['RktBibit'];
if($model->save()){
$message = Yii::t('app', 'Data berhasil disimpan.');
Yii::app()->user->setFlash('success', $message);
$this->redirect(array('index'));
}
}

$this->render('update',array(
'model'=>$model,
));
}

/**
* Deletes a particular model.
* If deletion is successful, the browser will be redirected to the 'admin' page.
* @param integer $id the ID of the model to be deleted
*/
public function actionDelete($id)
{
if(Yii::app()->request->isPostRequest)
{
// we only allow deletion via POST request
$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
if(!isset($_GET['ajax']))
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
}
else
throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

	/**
	* Manages all models.
	*/
	public function actionIndex()
	{
        $rku = Rku::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan() . ' AND id_rku = '. $rku->id_rku,'order'=>'tahun_mulai DESC'));
        if(!isset($rkt)) {
            $message = Yii::t('app', 'Data RKT belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
        }
        $tahun = $rkt->tahun_mulai;
        if(isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan().' AND status = 1 AND tahun_mulai = '. $_POST['Rkt']['tahun_mulai'].' AND id_rku = '. $rku->id_rku,'order'=>'tahun_mulai DESC'));
            if(!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun '.$_POST['Rkt']['tahun_mulai'].' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rkt/index'));
            }
            $tahun = $rkt->tahun_mulai;
        }
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['aksi']) && $_GET['aksi']==='updateGrid') {
                $tahun = $_GET['tahun'];
                $rkt = Rkt::model()->find(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan().' AND status = 1 AND tahun_mulai = '. $tahun .' AND id_rku = '. $rku->id_rku, 'order'=>'tahun_mulai DESC' ));
                $tahun = $tahun;
            }
        }
        // $rku = Rku::model()->find(array('condition' => 'status=1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        $bloksektor = BlokSektor::model()->findAll(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
        $jenisProduksiLahan = MasterJenisProduksiLahan::model()->findAll();
        $jenisTanamanBibit = MasterJenisTanamanBibit::model()->findAll();
        $jenisLahan = MasterJenisLahan::model()->findAll(array('condition'=>'id IN(1,2)'));
        $jenisPasar = MasterJenisPemasaran::model()->findAll();
        $jenisKayu = MasterJenisKayu::model()->findAll();
        $jenisKelKayu = MasterJenisKelompokKayu::model()->findAll();

        if(isset($rkt)) {
            $j_tanaman = RkuTanamanSilvikultur::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
            if(empty($j_tanaman)) {
                $message = Yii::t('app', 'Silahkan isi jenis tanaman terlebih dahulu.');
                Yii::app()->user->setFlash('error', $message);
                $this->redirect(array('//perusahaan/rkuSilvikultur/create/','tab'=>'2'));
            }
            $idRkt = $rkt->id;
            $rkuTanSil = RkuTanamanSilvikultur::model()->findAll(array('condition'=>'id_rku = '. $rku->id_rku));

            // $bibit = RktBibit::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id));
            // $siapLahan = RktSiapLahan::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $tanam = RktTanam::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $sulam = RktSulam::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $jarang = RktJarang::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $dangir = RktDangir::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $panenAreal = RktPanenAreal::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $panenTanaman = RktPanenVolumeTanaman::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $panenSiapLahan = RktPanenVolumeSiapLahan::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // $pasar = RktPasar::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            // if(empty($bibit)) {
            //     if(isset($rkuTanSil)) {
            //         foreach($rkuTanSil as $rts) {
            //             $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$rts->id_jenis_produksi_lahan));
            //             $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$rts->id_jenis_tanaman));

            //             $bibit = new RktBibit;
            //             $bibit->id_rkt = $rkt->id;
            //             $bibit->id_rku_tansil - $rts->id;
            //             $bibit->id_produksi_lahan = $jplz->id;
            //             $bibit->id_jenis_tanaman = $jptz->id;
            //             $bibit->save();
            //         }
            //     }
            // }
            // if(empty($siapLahan)) {
            //     foreach($jenisLahan as $key => $jl) {
            //         foreach($bloksektor as $bs) {
            //             if($jl->id === 3) {
            //                 return;
            //             }
            //             $siapLahan = new RktSiapLahan;
            //             $siapLahan->id_rkt = $rkt->id;
            //             $siapLahan->id_jenis_lahan = $jl->id;
            //             $siapLahan->id_blok = $bs->id;
            //             // $bibit->id_jenis_tanaman = $jt->id;
            //             $siapLahan->save();
            //         }
            //     }
            // }
            // if(empty($tanam)) {
            //     if(isset($rkuTanSil)) {
            //         // echo 'here';die;
            //         foreach($jenisLahan as $key => $jl) {
            //             // if($key > 1) {
            //             //     return;
            //             // }
            //             foreach($rkuTanSil as $jtb) {
            //                 foreach($bloksektor as $bs) {
            //                     $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$jtb->id_jenis_produksi_lahan));
            //                     $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$jtb->id_jenis_tanaman));
            //                     // echo $jtb->id_rku.'<br>';
            //                     $tanamz = new RktTanam;
            //                     $tanamz->id_rkt = $rkt->id;
            //                     $tanamz->id_rku_tansil = $jtb->id;
            //                     $tanamz->id_jenis_lahan = $jl->id;
            //                     $tanamz->id_produksi_lahan = $jplz->id;
            //                     $tanamz->id_jenis_tanaman = $jptz->id;
            //                     // $tanam->id_blok = $bs->id;
            //                     $tanamz->id_blok = $bs->id;
            //                     // $bibit->id_jenis_tanaman = $jt->id;
            //                     if(!$tanamz->save()){
            //                         var_dump($tanamz->getErrors());die;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // }
            // if(empty($sulam)) {
            //     foreach($jenisProduksiLahan as $jpl) {
            //         $sulam = new RktSulam;
            //         $sulam->id_rkt = $rkt->id;
            //         $sulam->id_jenis_produksi_lahan = $jpl->id;
            //         $sulam->save();
            //     }
            // }
            // if(empty($jarang)) {
            //     foreach($jenisProduksiLahan as $jpl) {
            //         $jarang = new RktJarang;
            //         $jarang->id_rkt = $rkt->id;
            //         $jarang->id_jenis_produksi_lahan = $jpl->id;
            //         $jarang->save();
            //     }
            // }
            // if(empty($dangir)) {
            //     foreach($jenisProduksiLahan as $jpl) {
            //         $dangir = new RktDangir;
            //         $dangir->id_rkt = $rkt->id;
            //         $dangir->id_jenis_produksi_lahan = $jpl->id;
            //         $dangir->save();
            //     }
            // }
            // if(empty($pasar)) {
            //     foreach($jenisPasar as $jps) {
            //         $pasar = new RktPasar;
            //         $pasar->id_rkt = $rkt->id;
            //         $pasar->id_pemasaran = $jps->id;
            //         $pasar->save();
            //     }
            // }
            // if(empty($panenAreal)) {
            //     foreach($jenisLahan as $jl) {
            //         foreach($jenisProduksiLahan as $jpl) {
            //             // foreach($bloksektor as $bs) {
            //                 // if($jl->id === 3) {
            //                 //     return;
            //                 // }
            //                 $panenAreal = new RktPanenAreal;
            //                 $panenAreal->id_rkt = $rkt->id;
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
            // if(empty($panenTanaman)) {
            //     foreach($jenisProduksiLahan as $jpl) {
            //         $panenTanaman = new RktPanenVolumeTanaman;
            //         $panenTanaman->id_rkt = $rkt->id;
            //         $panenTanaman->id_jenis_produksi_lahan = $jpl->id;
            //         $panenTanaman->save();
            //     }
            // }
            // if(empty($panenSiapLahan)) {
            //     foreach($jenisKayu as $jk) {
            //         foreach($jenisKelKayu as $jkk) {
            //             $panenSiapLahan = new RktPanenVolumeSiapLahan;
            //             $panenSiapLahan->id_rkt = $rkt->id;
            //             $panenSiapLahan->id_jenis_kayu = $jk->id;
            //             $panenSiapLahan->id_jenis_kelompok_kayu = $jkk->id;
            //             $panenSiapLahan->save();
            //         }
            //     }
            // }

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
            // $modelTanam->with('MasterJenisLahan');
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

            $bibit = RktBibit::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id));
            if(isset($bibit)) {
                if(isset($rkuTanSil)) {
                    foreach($rkuTanSil as $rts) {
                        $bibetz = RktBibit::model()->find(array('condition'=>'id_rkt = '.$rkt->id.' AND id_produksi_lahan = '.$rts->id_jenis_produksi_lahan.' AND id_jenis_tanaman = '.$rts->id_jenis_tanaman));
                        if(!isset($bibetz)) {
                            $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$rts->id_jenis_produksi_lahan));
                            $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$rts->id_jenis_tanaman));

                            $bibitz = new RktBibit;
                            $bibitz->id_rkt = $rkt->id;
                            $bibitz->id_rku_tansil = $rts->id;
                            $bibitz->id_produksi_lahan = $jplz->id;
                            $bibitz->id_jenis_tanaman = $jptz->id;
                            $bibitz->save();
                        }
                    }
                }
            }

            $tanam = RktTanam::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            if(isset($tanam)) {
                if(isset($rkuTanSil)) {
                // echo 'here';die;
                    foreach($rkuTanSil as $jtb) {
                        $tanemz = RktTanam::model()->find(array('condition'=>'id_rkt = '.$rkt->id.' AND id_produksi_lahan = '.$jtb->id_jenis_produksi_lahan.' AND id_jenis_tanaman = '.$jtb->id_jenis_tanaman));
                        if(!isset($tanemz)) {
                            foreach($jenisLahan as $key => $jl) {
                            // if($key > 1) {
                            //     return;
                            // }
                                foreach($bloksektor as $bs) {
                                    $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$jtb->id_jenis_produksi_lahan));
                                    $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$jtb->id_jenis_tanaman));

                                    $tanamzz = new RktTanam;
                                    $tanamzz->id_rkt = $rkt->id;
                                    $tanamzz->id_rku_tansil = $jtb->id;
                                    $tanamzz->id_jenis_lahan = $jl->id;
                                    $tanamzz->id_produksi_lahan = $jplz->id;
                                    $tanamzz->id_jenis_tanaman = $jptz->id;
                                    $tanamzz->id_blok = $bs->id;
                                    if(!$tanamzz->save()){
                                        var_dump($tanamzz->getErrors());die;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $panenAreal = RktPanenAreal::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            if(isset($panenAreal)) {
                if(isset($rkuTanSil)) {
                // echo 'here';die;
                    foreach($rkuTanSil as $jtb) {
                        $panenArealz = RktPanenAreal::model()->find(array('condition'=>'id_rkt = '.$rkt->id.' AND id_produksi_lahan = '.$jtb->id_jenis_produksi_lahan.' AND id_jenis_tanaman = '.$jtb->id_jenis_tanaman));
                        if(!isset($panenArealz)) {
                            foreach($jenisLahan as $key => $jl) {
                            // if($key > 1) {
                            //     return;
                            // }
                                foreach($bloksektor as $bs) {
                                    $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$jtb->id_jenis_produksi_lahan));
                                    $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$jtb->id_jenis_tanaman));

                                    $panenArealzz = new RktPanenAreal;
                                    $panenArealzz->id_rkt = $rkt->id;
                                    $panenArealzz->id_rku_tansil = $jtb->id;
                                    $panenArealzz->id_jenis_lahan = $jl->id;
                                    $panenArealzz->id_produksi_lahan = $jplz->id;
                                    $panenArealzz->id_jenis_tanaman = $jptz->id;
                                    $panenArealzz->id_blok = $bs->id;
                                    if(!$panenArealzz->save()){
                                        var_dump($panenArealzz->getErrors());die;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $panenVolumeTanaman = RktPanenVolumeTanaman::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
            if(isset($panenVolumeTanaman)) {
                if(isset($rkuTanSil)) {
                // echo 'here';die;
                    foreach($rkuTanSil as $jtb) {
                        $panenArealz = RktPanenVolumeTanaman::model()->find(array('condition'=>'id_rkt = '.$rkt->id.' AND id_produksi_lahan = '.$jtb->id_jenis_produksi_lahan.' AND id_jenis_tanaman = '.$jtb->id_jenis_tanaman));
                        if(!isset($panenArealz)) {
                            foreach($jenisLahan as $key => $jl) {
                            // if($key > 1) {
                            //     return;
                            // }
                                foreach($bloksektor as $bs) {
                                    $jplz = MasterJenisProduksiLahan::model()->find(array('condition'=>'id = '.$jtb->id_jenis_produksi_lahan));
                                    $jptz = MasterJenisTanaman::model()->find(array('condition'=>'id = '.$jtb->id_jenis_tanaman));

                                    $panenArealzz = new RktPanenVolumeTanaman;
                                    $panenArealzz->id_rkt = $rkt->id;
                                    $panenArealzz->id_rku_tansil = $jtb->id;
                                    $panenArealzz->id_jenis_lahan = $jl->id;
                                    $panenArealzz->id_produksi_lahan = $jplz->id;
                                    $panenArealzz->id_jenis_tanaman = $jptz->id;
                                    $panenArealzz->id_blok = $bs->id;
                                    if(!$panenArealzz->save()){
                                        var_dump($panenArealzz->getErrors());die;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

		$this->render('index',array(
            'model'=>$rkt,
            'tahun'=>$tahun,
			'modelBibit'=>$modelBibit,
            'modelSiapLahan'=>$modelSiapLahan,
            'modelTanam'=>$modelTanam,
            'modelSulam'=>$modelSulam,
            'modelJarang'=>$modelJarang,
            'modelDangir'=>$modelDangir,
            'modelPanenAreal'=>$modelPanenAreal,
            'modelPanenTanaman'=>$modelPanenTanaman,
            'modelPanenSiapLahan'=>$modelPanenSiapLahan,
            'modelPasar'=>$modelPasar
		));
	}

    public function actionInputJumlahBibit() {
        $post = $_POST['pk'];
        $md = RktBibit::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktBibit');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahSiapLahan() {
        $post = $_POST['pk'];
        $md = RktSiapLahan::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktSiapLahan');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahTanam() {
        $post = $_POST['pk'];
        $md = RktTanam::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktTanam');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahSulam() {
        $post = $_POST['pk'];
        $md = RktSulam::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktSulam');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahJarang() {
        $post = $_POST['pk'];
        $md = RktJarang::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktJarang');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahDangir() {
        $post = $_POST['pk'];
        $md = RktDangir::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktDangir');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahPanenAreal() {
        $post = $_POST['pk'];
        $md = RktPanenAreal::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPanenAreal');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }
    public function actionInputJumlahPanenTanaman() {
        $post = $_POST['pk'];
        $md = RktPanenVolumeTanaman::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPanenVolumeTanaman');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }
    public function actionInputJumlahPanenSiapLahan() {
        $post = $_POST['pk'];
        $md = RktPanenVolumeSiapLahan::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPanenVolumeSiapLahan');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }
    public function actionInputJumlahPasar() {
        $post = $_POST['pk'];
        $md = RktPasar::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPasar');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
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
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=RktBibit::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='rkt-bibit-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
