<?php

class SpasialRktController extends Controller
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
                'actions' => array('create', 'update'),
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
	public function actionCreate($id)
	{
		$model=new SpasialRkt;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SpasialRkt']))
		{
			$doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
			// var_dump($doks3);die;
			$model->attributes=$_POST['SpasialRkt'];
            if(isset($doks3) && empty($doks3)) {
                $model->addError('dokumen_peta','Dokumen peta tidak boleh kosong');
                // var_dump($model->getErrors());die;
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $this->redirect(array('create'));
                $this->render('create',array(
                    'model'=>$model,
                    'id'=>$id
                ));
                Yii::app()->end();
            }
            if(isset($doks3) && !empty($doks3)) {
                $case = false;
                $ekstensi = array('shp','shx','dbf','prj');
                foreach($doks3 as $dok) {
                    $fName = explode('.',$dok->name);
                    $ekst[] = $fName[1];
                    if(isset($ekst0) && $ekst0 !== $fName[0]) {
                        $model->addError('dokumen_peta','Nama file tidak sama. Pastikan semua file memiliki nama yang sama');
                        $this->render('create',array(
                            'model'=>$model,
                            'id'=>$id
                        ));
                        Yii::app()->end();
                    }
                    $ekst0 = $fName[0];
                    $model->dokumen_peta = $dok->name;
                }

                foreach($ekstensi as $e) {
                    // var_dump($e);die;
                    if(in_array($e, $ekst)) {
                        $d[] = $e;
                    }
                    if(!in_array($e, $ekst)) {
                        $case = true;
                        $model->addError('dokumen_peta','File <strong>'.$ekst0.'.'.$e.'</strong> tidak terunggah.');
                    }
                }
                if($case) {
                    // if(isset($d)) {
                    //     $aa = '';
                    //     foreach($d as $dd) {
                    //         $aa .= $ekst0.'.'.$dd.', ';
                    //     }
                    // }
                    $model->addError('dokumen_peta','Pastikan semua file berekstensi <strong>.shp, .shx, .prj dan .dbf</strong> terunggah semua.' );
                    $this->render('create',array(
                        'model'=>$model,
                        'id'=>$id
                    ));
                    Yii::app()->end();
                }
            }
			if($model->save()){
				$perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
                $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
                $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
				if (isset($doks3) && !empty($doks3)) {
					$ngepath = Yii::app()->params->uploadPath . '/SPASIAL/' . $p;
                    if (!is_dir($ngepath)){
                       mkdir($ngepath,  0777, true); 
                    }
                    $convert_to_kml = false;
                    $file_to_process = null;

                    $fName = explode('.',$doks3[0]->name);
                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1].'"'));
                    if(isset($cekAttach)) {
                    	$b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                        if(isset($b)){
                        	$fName = explode('.',$dok3->name);
                        	$input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'_'.$b.'.'.$fName[1];
                        } else {
                        	$fName = explode('.',$dok3->name);
                        	$input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1];
                        }
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'_RKT_'.$model->idRkt->tahun_mulai.'_'.$b.'.'.$fName[1] : $fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaRKT';
                            $att->Model_id = $model->id_rkt;
                            $att->Keterangan = Yii::t('app', 'Peta RKT #') . $model->idRkt->tahun_mulai .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_rkt) {
                        $fileName = explode('.',$att->File_Name);
                        $input2 = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $fileName[0].'.shp';
                        // echo $fileName[0];die;
                        $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                        $workspace = $geoserver->listWorkspaces();
                        // $workspace = $geoserver->getWorkspace(Yii::app()->params->namaWorkspace);
                        // var_dump($workspace);die;
                        if(isset($workspace->workspaces->workspace)) {
                            foreach($workspace->workspaces->workspace as $c) {
                                // var_dump($workspace->workspaces->workspace);die;
                                if($c->name == Yii::app()->params->namaWorkspace) {
                                    // echo $c->name;die;
                                    $geoserver->createShpDirDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai, '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai, '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai, Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai, '');
                                }
                            }
                        }
                    }

                    // cek wms service
                    $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                    $b = $geoserver->getCapabilities(Yii::app()->params->namaWorkspace,'text/xml',array($fileName[0]));
                    // var_dump($b);die;
                    if(isset($b['error'])) {
                        // echo $b['error'];die;
                        $geoserver->deleteLayer($fileName[0], Yii::app()->params->namaWorkspace, $p);
                        $geoserver->deleteDataStore($p, Yii::app()->params->namaWorkspace);
                        $at_del = Attachment::model()->findAll(array('condition'=>'Model_id = '.$model->id_iup));
                        if(isset($at_del)) {
                            foreach($at_del as $atz) {
                                $atz->delete();
                            }
                        }
                        // $att->delete();
                        $model->delete();

                        // $message = Yii::t('app', $b['error']);
                        // Yii::app()->user->setFlash('errorPeta', $message);
                        // $this->redirect(array('index'));
                        $model->addError('dokumen_peta','Proyeksi pada peta bukan EPSG:4326 (WGS 84). Silahkan ubah proyeksi file spasial dan lakukan upload ulang.');
                        $this->render('create',array(
                            'model'=>$model,
                            'id'=>$id
                        ));
                        Yii::app()->end();
                    }
            	}
				$message = Yii::t('app', 'Data berhasil disimpan.');
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index','id'=>$id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'id'=>$id
		));
	}

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id,$id_spasial)
	{
		$model=$this->loadModel($id_spasial);

		$rkt = Rkt::model()->find('id = '. $id);
		// $idRku = $rkt->id_rku;
		// var_dump($idRku);die;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SpasialRkt']))
		{
            $doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
            // $doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
            // var_dump($doks3);die;
            $model->attributes=$_POST['SpasialRkt'];
            if(isset($doks3) && empty($doks3)) {
                $model->addError('dokumen_peta','Dokumen peta tidak boleh kosong');
                // var_dump($model->getErrors());die;
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $this->redirect(array('create'));
                $this->render('create',array(
                    'model'=>$model,
                    'id'=>$id
                ));
                Yii::app()->end();
            }
            if(isset($doks3) && !empty($doks3)) {
                $case = false;
                $ekstensi = array('shp','shx','dbf','prj');
                foreach($doks3 as $dok) {
                    $fName = explode('.',$dok->name);
                    $ekst[] = $fName[1];
                    if(isset($ekst0) && $ekst0 !== $fName[0]) {
                        $model->addError('dokumen_peta','Nama file tidak sama. Pastikan semua file memiliki nama yang sama');
                        $this->render('create',array(
                            'model'=>$model,
                            'id'=>$id
                        ));
                        Yii::app()->end();
                    }
                    $ekst0 = $fName[0];
                    $model->dokumen_peta = $dok->name;
                }

                foreach($ekstensi as $e) {
                    // var_dump($e);die;
                    if(in_array($e, $ekst)) {
                        $d[] = $e;
                    }
                    if(!in_array($e, $ekst)) {
                        $case = true;
                        $model->addError('dokumen_peta','File <strong>'.$ekst0.'.'.$e.'</strong> tidak terunggah.');
                    }
                }
                if($case) {
                    // if(isset($d)) {
                    //     $aa = '';
                    //     foreach($d as $dd) {
                    //         $aa .= $ekst0.'.'.$dd.', ';
                    //     }
                    // }
                    $model->addError('dokumen_peta','Pastikan semua file berekstensi <strong>.shp, .shx, .prj dan .dbf</strong> terunggah semua.' );
                    $this->render('create',array(
                        'model'=>$model,
                        'id'=>$id
                    ));
                    Yii::app()->end();
                }
            }
            // $model->attributes=$_POST['SpasialRkt'];
            if($model->save()){
                $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
                $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
                $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                if (isset($_POST['del_file']) && !empty($_POST['del_file'])) {
                    foreach ($_POST['del_file'] as $del) {
                        $f = Attachment::model()->findByPk($del);
                        if (isset($f) && !empty($f)) {
                            $fileName = explode('.',$f->File_Name);
                            @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p .'/'. $fileName[0].'.qix');
                            @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p .'/'. $f->File_Name);
                            $fileName = explode('.',$f->File_Name);
                            if($f->delete()) {
                                $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                                $geoserver->deleteLayer($fileName[0], Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai);
                                $geoserver->deleteDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai, Yii::app()->params->namaWorkspace);
                            }
                        }
                    }
                }
                if (isset($doks3) && !empty($doks3)) {
					$ngepath = Yii::app()->params->uploadPath . '/SPASIAL/' . $p;
                    if (!is_dir($ngepath)){
                       mkdir($ngepath,  0777, true); 
                    }
                    $convert_to_kml = false;
                    $file_to_process = null;

                    $fName = explode('.',$doks3[0]->name);
                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$fName[0].'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1].'"'));
                    if(isset($cekAttach)) {
                        $b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                        if(isset($b)){
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_RKT_'.$model->idRkt->tahun_mulai.'_'.$b.'.'.$fName[1];
                        } else {
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                        	$input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1];
                        }
                        // $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $dok3->name;
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $nmFile.'_RKT_'.$model->idRkt->tahun_mulai.'_'.$b.'.'.$fName[1] : $nmFile.'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_RKT_'.$model->idRkt->tahun_mulai.'_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_RKT_'.$model->idRkt->tahun_mulai.'.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaRKT';
                            $att->Model_id = $model->id_rkt;
                            $att->Keterangan = Yii::t('app', 'Peta RKT #') . $model->idRkt->tahun_mulai .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_rkt) {
                        $fileName = explode('.',$att->File_Name);
                        $input2 = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $fileName[0].'.shp';
                        // echo $fileName[0];die;
                        $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                        $workspace = $geoserver->listWorkspaces();
                        // $workspace = $geoserver->getWorkspace(Yii::app()->params->namaWorkspace);
                        // var_dump($workspace);die;
                        if(isset($workspace->workspaces->workspace)) {
                            foreach($workspace->workspaces->workspace as $c) {
                                // var_dump($workspace->workspaces->workspace);die;
                                if($c->name == Yii::app()->params->namaWorkspace) {
                                    // echo $c->name;die;
                                    $geoserver->createShpDirDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai, '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai, '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai, Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai, '');
                                }
                            }
                        }
                    }
            	}
				$message = Yii::t('app', 'Data berhasil disimpan.');
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index','id'=>$id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'id'=>$id
		));
	}

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete($id, $id_spasial)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->loadModel($id_spasial);

            $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
            $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
            $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);

            if($model->delete()) {
                $att = Attachment::model()->findAll(array('condition'=>"Model = 'PetaRKT' AND Model_id = ".$model->id_rkt));
                if (isset($att) && !empty($att)) {
                    foreach($att as $key => $f) {
                        $fileName = explode('.',$f->File_Name);
                        @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p .'/'. $filename[0].'.qix');
                        @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p .'/'. $f->File_Name);
                        if($f->delete()) {
                            if($key === 0) {
                                $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                                $geoserver->deleteLayer($fileName[0], Yii::app()->params->namaWorkspace, $p.'-rkt-'.$model->idRkt->tahun_mulai);
                                $geoserver->deleteDataStore($p.'-rkt-'.$model->idRkt->tahun_mulai, Yii::app()->params->namaWorkspace);
                            }
                        }
                    }
                }
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

	/**
	* Manages all models.
	*/
	public function actionIndex($id)
	{
		$rkt = Rkt::model()->findAll('status = 1 AND id_rku = '. $id);
		$spasial = SpasialRkt::model()->find(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan()));

		$model=new SpasialRkt('search');
		$model->unsetAttributes();
		if(isset($_GET['SpasialRkt']))
			$model->attributes=$_GET['SpasialRkt'];
		// $model->id_rkt = $rkt[0]->id;

        // var_dump($model);die;

		$this->render('index',array(
			'idRku'=>$id,
			'model'=>$model,
		));
	}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=SpasialRkt::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='spasial-rkt-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
