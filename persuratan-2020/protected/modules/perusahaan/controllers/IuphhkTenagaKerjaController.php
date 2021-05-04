<?php

class IuphhkTenagaKerjaController extends Controller
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
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'create', 'update', 'delete', 'Detailganis', 'addSkGanis'),
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
		$model=new IuphhkTenagaKerja;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['IuphhkTenagaKerja']))
		{
			$model->attributes=$_POST['IuphhkTenagaKerja'];
			$model->id_perusahaan = Yii::app()->user->idPerusahaan();
			if($model->save())
				$this->redirect(array('index'));
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

		if(isset($_POST['IuphhkTenagaKerja']))
		{
			$model->attributes=$_POST['IuphhkTenagaKerja'];
			if($model->save())
				$this->redirect(array('index'));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all latest models.
	 */
	public function actionLatest()
	{
		$this->layout = false;
		$dataProvider=new CActiveDataProvider('IuphhkTenagaKerja');
		$dataProvider->criteria->order = 'created DESC';
		$dataProvider->criteria->limit = 4;
		$dataProvider->pagination = false;
		$this->render('latest',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new IuphhkTenagaKerja('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IuphhkTenagaKerja']))
			$model->attributes=$_GET['IuphhkTenagaKerja'];

		$model->id_perusahaan = Yii::app()->user->idPerusahaan();
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionDetailganis($id) {
	$model = new IuphhkTenagaKerja('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['IuphhkTenagaKerja']))
            $model->attributes = $_GET['IuphhkTenagaKerja'];

        $model->id_perusahaan = Yii::app()->user->idPerusahaan();
        $model->id = $id;


        $modelsertifikatganis = new SertifikatGanis('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SertifikatGanis']))
            $model->attributes = $_GET['SertifikatGanis'];

        $modelsertifikatganis->id_iuphhk_tenaga_kerja = $id;
        $this->render('detailganis', array(
            'model' => $this->loadModel($id),
            'modelsertifikatganis' => $modelsertifikatganis,
            // 'modal_saham' => $modal_saham,
            // 'direksi' => $direksi,
            // 'komisaris' => $komisaris,
            'id' => $id
        ));
    }


    public function actionaddSkGanis($id) {
        $modelTenagaKerja = IuphhkTenagaKerja::model()->findByPk($id);

        $id_sk_ganis = isset($_GET['id_sk_ganis']) ? $_GET['id_sk_ganis'] : "";
        if ($id_sk_ganis != "") {
            $model = SertifikatGanis::model()->findByPk($id);
        } else {
            $model = new SertifikatGanis;
        }

        $buton_hide = false;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        if (isset($_POST['SertifikatGanis'])) {
            $model->attributes = $_POST['SertifikatGanis'];
            $model->id = $modelTenagaKerja->id;
            // var_dump($model);die();
            $file_error = 0;
            if ($_FILES["pdf_phpl"]["error"] == 0) {
                $file1 = CUploadedFile::getInstanceByName('pdf_phpl');
                $ran = rand();
                $ext = $file1->getExtensionName();
                $realName = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "PHPL_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name4 = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file1) && strtolower($ext) == "pdf") {
                    if ($file1->saveAs($name4)) {
                        $model->file_doc = $new_path;
                    } else {
                        $file_error++;
                        $msg = "File Gagal Diupload";
                    }
                } else {
                    $file_error++;
                    $msg = "File Harus PDF";
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
                    $modelcek = PenilikanPhpl::model()->findAllByAttributes(array('id_sertifikat_phpl' => $model->id_sertifikat_phpl));
                    if (count($modelcek) == 4) {
                        $buton_hide = true;
                    }

                    $data = array(
                        'header' => "Success",
                        "message" => "Data berhasil disimpan",
                        'status' => "success",
                        'buton_hide' => $buton_hide
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Data gagal disimpan " . $msg,
                        'status' => "error",
                        'buton_hide' => $buton_hide
                    );
                }
            } else {
                $data = array(
                    'header' => "Error",
                    "message" => "Data gagal disimpan " . $msg,
                    'status' => "error",
                    'buton_hide' => $buton_hide
                );
            }
            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_sk_ganis', array(
            'model' => $model,
            'modelSertifikat' => $modelSertifikat,
            'id_penilikan' => $id_penilikan
        ));
    }






	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('IuphhkTenagaKerja');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new IuphhkTenagaKerja('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IuphhkTenagaKerja']))
			$model->attributes=$_GET['IuphhkTenagaKerja'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return IuphhkTenagaKerja the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=IuphhkTenagaKerja::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param IuphhkTenagaKerja $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='iuphhk-tenaga-kerja-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
