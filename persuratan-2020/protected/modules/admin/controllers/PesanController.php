<?php

class PesanController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','inbox','outbox','view','home','home_chart','latest','report_pdf'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $pesan = Pesan::model()->getDetail($id);
            $objPesan = Pesan::model()->findByPk($id);
            
            $userAktif = Yii::app()->user->findUser()->id_perusahaan;
            $penerima = $objPesan->penerima;
            
          // print_r("<pre>");print_r($userAktif);echo "penerima:"; print_r($penerima);print_r("</pre>"); die();
            
            if($userAktif == $penerima){
                $objPesan->status_baca = 1;
                $objPesan->save();
            }
            
		$this->render('view',array(
			'model'=>$pesan,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Pesan;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pesan']))
		{
                    
                    
                                
  
			$model->attributes=$_POST['Pesan'];
                 //       $model->penerima = $listPenerima;
                        $model->tgl_kirim = date("Y-m-d H:i:s");
                        
                        
                        $ngepath = Yii::app()->params->uploadPath . '/PESAN/' . $p;
                        if (!is_dir($ngepath)) {
                            mkdir($ngepath, 0777, true);
                        }

                                
                         if ($_FILES["file_lampiran"]["error"] == 0) {
                                $ukuran_file = $_FILES['file_lampiran']['size'];
                                $file = CUploadedFile::getInstanceByName('file_lampiran');
                                $ran = rand();
                               
                                $ext = $file->getExtensionName();
                                $realName = pathinfo($file1->name, PATHINFO_FILENAME);
                                $replaceFile = str_replace(' ', '_', $realName);
                                $new_name = "LAMPIRAN_PESAN_" . $replaceFile . '_' . $ran . '.' . $ext;
                                $new_path = '/files/PESAN/'. $new_name;
                                $name = dirname(Yii::app()->request->scriptFile) . $new_path;

                                if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                                    $file->saveAs($name);
                                    $model->file_lampiran = $new_path;
                                } else {
                                    $file_error++;
                                    $message = Yii::t('app', 'Type File harus PDF dengan ukuran maksimal 2 Mb');
                                    Yii::app()->user->setFlash('error', $message);
                //                    $this->redirect(array('create'));
                //                    Yii::app()->end();
                                }
                         }
                         
                    $model->pengirim = Yii::app()->user->findUser()->id;
                
                
                                        
                         
                    if($model->save())
                    $this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Pesan']))
		{
			$model->attributes=$_POST['Pesan'];
                        $model->tgl_ubah = date("Y-m-d H:i:s");
                        
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Pesan');
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
	public function actionInbox()
	{
            
//            print_r("here"); die();
		$userPenerima = Yii::app()->user->findUser()->id_perusahaan;
                
                $model=Pesan::model()->getInbox($userPenerima);
		
//                print_r("<pre>");print_r($model);print_r("</pre>"); die();
                
		$this->render('inbox',array(
			'model'=>$model,
		));
	}
	/**
	 * Lists all models.
	 */
	public function actionOutbox()
	{
                $userPengirim = Yii::app()->user->findUser()->id;
                
                
                $model= Pesan::model()->getOutbox($userPengirim);
		
                
		$this->render('outbox',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('Pesan');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pesan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pesan']))
			$model->attributes=$_GET['Pesan'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pesan the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pesan::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pesan $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pesan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
