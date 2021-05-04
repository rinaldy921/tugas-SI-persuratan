<?php

class SpasialRkuController extends Controller
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
                'actions' => array('index', 'view', 'indexRkt','cariAtt'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update','createIup','updateIup','createTb','updateTb'),
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
	public function actionCreate()
	{
		$model=new SpasialRku;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SpasialRku']))
		{
			$doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
            if(isset($doks3) && empty($doks3)) {
            	$model->addError('dokumen_peta','Dokumen peta tidak boleh kosong');
            	// var_dump($model->getErrors());die;
                // $message = Yii::t('app', 'Data berhasil disimpan.');
				// Yii::app()->user->setFlash('success', $message);
				// $this->redirect(array('create'));
				$this->render('create',array(
					'model'=>$model,
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
                        $this->render('createIup',array(
                            'model'=>$model,
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
                    $this->render('createIup',array(
                        'model'=>$model,
                    ));
                    Yii::app()->end();
                }
            }
			$model->attributes=$_POST['SpasialRku'];
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

                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$doks3[0]->name.'"'));
                    if(isset($cekAttach)) {
                    	$b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                        if(isset($b)){
                        	$fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                        	$input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1];
                        } else {
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                        	$input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_RKU.'.$fName[1];
                        }
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $nmFile.'_'.$b.'.'.$fName[1] : $nmFile.'_RKU.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_RKU_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_RKU.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaRKU';
                            $att->Model_id = $model->id_rku;
                            $att->Keterangan = Yii::t('app', 'Peta RKU #') . $model->id_rku .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_rku) {
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
                                    $geoserver->createShpDirDataStore($p.'-rku',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rku', '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p.'-rku',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rku', '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p.'-rku', Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rku', '');
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
                        $this->render('createIup',array(
                            'model'=>$model,
                        ));
                        Yii::app()->end();
                    }
            	}
				$message = Yii::t('app', 'Data berhasil disimpan.');
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

    public function actionCreateIup()
    {
        $model=new SpasialIup;

        // $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
        // $workspace = $geoserver->listDatastores(Yii::app()->params->namaWorkspace);
        // var_dump($workspace);die;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['SpasialIup']))
        {
            $doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
            if(isset($doks3) && empty($doks3)) {
                $model->addError('dokumen_peta','Dokumen peta tidak boleh kosong');
                // var_dump($model->getErrors());die;
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $this->redirect(array('create'));
                $this->render('createIup',array(
                    'model'=>$model,
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
                        $this->render('createIup',array(
                            'model'=>$model,
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
                    $this->render('createIup',array(
                        'model'=>$model,
                    ));
                    Yii::app()->end();
                }
            }
            $model->attributes=$_POST['SpasialIup'];
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

                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$doks3[0]->name.'"'));
                    if(isset($cekAttach)) {
                        $b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                        if(isset($b)){
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1];
                        } else {
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'.'.$fName[1];
                        }
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $nmFile.'_'.$b.'.'.$fName[1] : $nmFile.'.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaIUP';
                            $att->Model_id = $model->id_iup;
                            $att->Keterangan = Yii::t('app', 'Peta IUP #') . $model->id_iup .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_iup) {
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
                                    $geoserver->createShpDirDataStore($p,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p, '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p, '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p, Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p, '');
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
                        $this->render('createIup',array(
                            'model'=>$model,
                        ));
                        Yii::app()->end();
                    }

                }
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('createIup',array(
            'model'=>$model,
        ));
    }

    public function actionCreateTb()
    {
        $model=new SpasialTb;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['SpasialTb']))
        {
            $doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
            if(isset($doks3) && empty($doks3)) {
                $model->addError('dokumen_peta','Dokumen peta tidak boleh kosong');
                // var_dump($model->getErrors());die;
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $this->redirect(array('create'));
                $this->render('createTb',array(
                    'model'=>$model,
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
                        $this->render('createIup',array(
                            'model'=>$model,
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
                    $this->render('createIup',array(
                        'model'=>$model,
                    ));
                    Yii::app()->end();
                }
            }
            $model->attributes=$_POST['SpasialTb'];
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

                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$doks3[0]->name.'"'));
                    if(isset($cekAttach)) {
                        $b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                        if(isset($b)){
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1];
                        } else {
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_TB.'.$fName[1];
                        }
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $nmFile.'_'.$b.'.'.$fName[1] : $nmFile.'_TB.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_TB_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_TB.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaTB';
                            $att->Model_id = $model->id_iup;
                            $att->Keterangan = Yii::t('app', 'Peta TATA BATAS #') . $model->id_iup .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_iup) {
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
                                    $geoserver->createShpDirDataStore($p.'-tb',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-tb', '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p.'-tb',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-tb', '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p.'-tb', Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-tb', '');
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
                        $this->render('createIup',array(
                            'model'=>$model,
                        ));
                        Yii::app()->end();
                    }
                }
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('createTb',array(
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

		if(isset($_POST['SpasialRku']))
		{
			$model->attributes=$_POST['SpasialRku'];
			if($model->save()){
				$perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
                $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
                $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
				if (isset($_POST['del_file']) && !empty($_POST['del_file'])) {
                    foreach ($_POST['del_file'] as $del) {
                        $f = Attachment::model()->findByPk($del);
                        $fileName = explode('.',$f->File_Name);
                        if (isset($f) && !empty($f)) {
                            @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p . $f->File_Name);
                            if($f->delete()) {
                            	$geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                            	$geoserver->deleteLayer($fileName[0], Yii::app()->params->namaWorkspace, $p.'-rku');
                            	$geoserver->deleteDataStore($p.'-rku', Yii::app()->params->namaWorkspace);
                                $model->delete();
                            }
                        }
                    }
                }
                $doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
                if (isset($doks3) && !empty($doks3)) {
					$ngepath = Yii::app()->params->uploadPath . '/SPASIAL/' . $p;
                    if (!is_dir($ngepath)){
                       mkdir($ngepath,  0777, true); 
                    }
                    $convert_to_kml = false;
                    $file_to_process = null;

                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$doks3[0]->name.'"'));
                    if(isset($cekAttach)) {
                    	$b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                    	if(isset($b)){
                        	$fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                        	$input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1];
                        } else {
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                        	$input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_RKU.'.$fName[1];
                        }
                        // $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $dok3->name;
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $nmFile.'_'.$b.'.'.$fName[1] : $nmFile.'_RKU.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_RKU.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaRKU';
                            $att->Model_id = $model->id_rku;
                            $att->Keterangan = Yii::t('app', 'Peta RKU #') . $model->id_rku .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_rku) {
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
                                    $geoserver->createShpDirDataStore($p.'-rku',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rku', '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p.'-rku',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rku', '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p.'-rku', Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-rku', '');
                                }
                            }
                        }
                    }
            	}
				$message = Yii::t('app', 'Data berhasil disimpan.');
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionUpdateIup($id)
    {
        $model = SpasialIup::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['SpasialIup']))
        {
            $model->attributes=$_POST['SpasialIup'];
            if($model->save()){
                $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
                $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
                $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                if (isset($_POST['del_file']) && !empty($_POST['del_file'])) {
                    foreach ($_POST['del_file'] as $del) {
                        $f = Attachment::model()->findByPk($del);
                        $fileName = explode('.',$f->File_Name);
                        if (isset($f) && !empty($f)) {
                            $delqix = explode('.',$f->File_Name);
                            @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p .'/'. $f->File_Name);
                            @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p .'/'. $delqix[0].'.qix');
                            if($f->delete()) {
                                $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                                $geoserver->deleteLayer($fileName[0], Yii::app()->params->namaWorkspace, $p);
                                $geoserver->deleteDataStore($p, Yii::app()->params->namaWorkspace);
                                $model->delete();
                            }
                        }
                    }
                }
                $doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
                if (isset($doks3) && !empty($doks3)) {
                    $ngepath = Yii::app()->params->uploadPath . '/SPASIAL/' . $p;
                    if (!is_dir($ngepath)){
                       mkdir($ngepath,  0777, true); 
                    }
                    $convert_to_kml = false;
                    $file_to_process = null;

                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$doks3[0]->name.'"'));
                    if(isset($cekAttach)) {
                        $b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                        if(isset($b)){
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1];
                        } else {
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'.'.$fName[1];
                        }
                        // $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $dok3->name;
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $nmFile.'_'.$b.'.'.$fName[1] : $nmFile.'.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaIUP';
                            $att->Model_id = $model->id_iup;
                            $att->Keterangan = Yii::t('app', 'Peta IUP #') . $model->id_iup .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_iup) {
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
                                    $geoserver->createShpDirDataStore($p,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p, '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p,Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p, '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p, Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p, '');
                                }
                            }
                        }
                    }
                }
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('updateIup',array(
            'model'=>$model,
        ));
    }

    public function actionUpdateTb($id)
    {
        $model=SpasialTb::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['SpasialTb']))
        {
            $model->attributes=$_POST['SpasialTb'];
            if($model->save()){
                $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
                $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
                $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                if (isset($_POST['del_file']) && !empty($_POST['del_file'])) {
                    foreach ($_POST['del_file'] as $del) {
                        $f = Attachment::model()->findByPk($del);
                        $fileName = explode('.',$f->File_Name);
                        if (isset($f) && !empty($f)) {
                            @unlink(Yii::app()->params->uploadPath . '/SPASIAL/' . $p . $f->File_Name);
                            if($f->delete()) {
                                $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
                                $geoserver->deleteLayer($fileName[0], Yii::app()->params->namaWorkspace, $p.'-tb');
                                $geoserver->deleteDataStore($p.'-tb', Yii::app()->params->namaWorkspace);
                                $model->delete();
                            }
                        }
                    }
                }
                $doks3 = CUploadedFile::getInstancesByName('dokumen_peta');
                if (isset($doks3) && !empty($doks3)) {
                    $ngepath = Yii::app()->params->uploadPath . '/SPASIAL/' . $p;
                    if (!is_dir($ngepath)){
                       mkdir($ngepath,  0777, true); 
                    }
                    $convert_to_kml = false;
                    $file_to_process = null;

                    $cekAttach = Attachment::model()->find(array('condition'=>'File_Name = "'.$doks3[0]->name.'"'));
                    if(isset($cekAttach)) {
                        $b = $this->generateRandomString();
                    }

                    foreach ($doks3 as $dok3) {
                        if(isset($b)){
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1];
                        } else {
                            $fName = explode('.',$dok3->name);
                            $nmFile = preg_replace("/[^A-Za-z0-9]/", '_', $fName[0]);
                            $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $nmFile.'_TB.'.$fName[1];
                        }
                        // $input = Yii::app()->params->uploadPath . '/SPASIAL/' . $p . '/' . $dok3->name;
                        if ($dok3->saveAs($input)) {
                            $att = new Attachment;
                            $att->File_Name = (isset($b)) ? $nmFile.'_'.$b.'.'.$fName[1] : $nmFile.'_TB.'.$fName[1];
                            $att->File_Path = (isset($b)) ? Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_'.$b.'.'.$fName[1] : Yii::app()->params->uploadDir . 'SPASIAL/' . $p . '/' . $nmFile.'_TB.'.$fName[1];
                            $att->File_Size = $dok3->size;
                            $att->File_Type = $dok3->type;
                            $att->Model = 'PetaTB';
                            $att->Model_id = $model->id_iup;
                            $att->Keterangan = Yii::t('app', 'Peta Tata Batas #') . $model->id_iup .' '. $perusahaan->nama_perusahaan;
                            $att->save();
                        }
                    }

                    if(isset($att->Model_id) && $att->Model_id == $model->id_iup) {
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
                                    $geoserver->createShpDirDataStore($p.'-tb',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-tb', '');
                                } else {
                                    $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                                    $geoserver->createShpDirDataStore($p.'-tb',Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-tb', '');
                                    // $geoserver->deleteNamespace(Yii::app()->params->namaWorkspace);
                                }
                            }
                        } else {
                            $geoserver->createWorkspace(Yii::app()->params->namaWorkspace);
                            $workspace = $geoserver->listWorkspaces();
                            foreach($workspace->workspaces->workspace as $c) {
                                if($c->name = Yii::app()->params->namaWorkspace) {
                                    $geoserver->createShpDirDataStore($p.'-tb', Yii::app()->params->namaWorkspace,$input2);
                                    $geoserver->createLayer($fileName[0].'.shp', Yii::app()->params->namaWorkspace, $p.'-tb', '');
                                }
                            }
                        }
                    }
                }
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('updateTb',array(
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
        $iup = Iuphhk::model()->find(array('condition'=>'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        if(empty($iup)) {
            $message = Yii::t('app', 'Silahkan lengkapi data IUPHHK terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('/perusahaan/iuphhk/'));
        }
		$rku = Rku::model()->find(array('condition' => 'status=1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        if(empty($rku)) {
            $message = Yii::t('app', 'Data RKU tidak ditemukan. Silahkan lengkapi data RKU terlebih dahulu.');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('/perusahaan/rku/'));
        }
        $spasialIup = SpasialIup::model()->find(array('condition'=>'id_iup = '.$iup->id_iuphhk));
        $spasialTb = SpasialTb::model()->find(array('condition'=>'id_iup = '.$iup->id_iuphhk));
        $spasial = SpasialRku::model()->find(array('condition'=>'id_rku = '. $rku->id_rku));
        $rkt = Rkt::model()->findAll(array('condition' => 'status=1 AND id_rku = '. $rku->id_rku));
        foreach($rkt as $rk) {
            $id_rkt[] = $rk->id;
        }
        // var_dump($rkt);die;
        if(Yii::app()->user->hasFlash('errorPeta')) {
            Yii::app()->user->setFlash('errorPeta', 'Proyeksi pada peta bukan EPSG:4326 (WGS 84). Silahkan ubah proyeksi file spasial dan lakukan upload ulang.');
            $this->redirect(array('createIup'));
        }
        
        if(empty($spasialIup)) {
            $message = Yii::t('app', 'Data Peta tidak ditemukan. Silahkan upload data peta terlebih dahulu.');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('createIup'));
        // } elseif(empty($spasial)) {
        //     $message = Yii::t('app', 'Data Peta tidak ditemukan. Silahkan upload data peta terlebih dahulu.');
        //     Yii::app()->user->setFlash('error', $message);
        //     $this->redirect(array('create'));
        } elseif(!empty($rkt)) {
            $spasialRkt = SpasialRkt::model()->findAll(array('condition'=>'id_rkt IN('. implode(',',$id_rkt) . ')'));  
            // var_dump($spasialRkt);die;
        } else {
            $spasialRkt = null;
        }

		$model=new SpasialRku('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SpasialRku']))
			$model->attributes=$_GET['SpasialRku'];

        // $geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
        // $b = $geoserver->getCapabilities(Yii::app()->params->namaWorkspace,'text/xml','');
        // var_dump($b);die;

		$this->render('index_peta',array(
			'model'=>$model,
			'spasial'=>$spasial,
            'spasialIup'=>$spasialIup,
            'spasialRkt'=>$spasialRkt,
            'spasialTb'=>$spasialTb,
		));
	}

    public function actionIndexRkt($id)
    {
        $id_rku = $id;
        // var_dump($id_rku);die;
        // $rku = Rku::model()->find(array('condition' => 'status=1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku = '.$id_rku));

        $modelRktBaru = new Rkt;
        $modelRktBaru->id_rku = $id_rku;

        $modelRkt = new Rkt('search');
        $modelRkt->unsetAttributes();
        if(isset($_GET['Rkt']))
            $modelRkt->attributes=$_GET['Rkt'];
        $modelRkt->id_rku = $id_rku;
        $modelRkt->status = 1;

        $this->render('_form_rkt', array(
            'rku'=>$id_rku,
            'rkt'=>$rkt,
            'modelRkt'=>$modelRkt,
            'modelRktBaru'=>$modelRktBaru
        ));
    }

    public function actionCariAtt() {
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['id'])) {
                $attachment = Attachment::model()->findAll("Model = 'PetaRKT' AND Model_id = :id", array(':id' => $_POST['id']));

                $this->renderPartial('_form_rkt2',array('attachments'=>$attachment), true, true);
                // Yii::app()->end();
            }
        }
    }

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=SpasialRku::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='spasial-rku-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
