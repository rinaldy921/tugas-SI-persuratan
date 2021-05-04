<?php

class RktBulanController extends Controller
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
				'actions'=>array('index','view','home','home_chart','latest','report_pdf','syncrktbulan','delete'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','syncrktbulan'),
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
            $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
            $rku = Rku::model()->find(array('condition' =>$condition));

            $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
            if(isset($rkt['0'])){
                $rkt = $rkt['0'];
            }
            
		$model=new RktBulan;
//                $model->unsetAttributes(); 
//                $model->attributes = array('id_rkt'=>$rkt['id'],'status'=>0);
                $model->status = 0;
                $model->id_rkt = $rkt['id'];
                $model->tahun = $rkt['tahun_mulai'];

               // print_r("<pre>");print_r($model);print_r("</pre>");exit(1); 
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RktBulan']))
		{
			$model->attributes=$_POST['RktBulan'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model
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

		if(isset($_POST['RktBulan']))
		{
			$model->attributes=$_POST['RktBulan'];
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
		$dataProvider=new CActiveDataProvider('RktBulan');
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
            //echo "here";exit(1);
            
            $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
            $rku = Rku::model()->find(array('condition' =>$condition));

            $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
            $listBulan='';
        
            if(isset($rkt['0'])){
                $rkt = $rkt['0'];
                $listBulan = RktBulan::model()->getListMonev($rkt['id']);
            }
            
            //print_r("<pre>");print_r($listBulan);print_r("</pre>");exit(1); //1437
            
            //$model = MasterBulan::model()->getListBulan();
        
        
		$model=new RktBulan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($rkt['id'])){
			$model->attributes=array('id_rkt'=>$rkt['id']);
                
                        
                }
		$this->render('index',array(
			'model'=>$model,
                        'listbulan' => $listBulan,
                        'rkt'=>$rkt,
                        'rku'=>$rku,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('RktBulan');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RktBulan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RktBulan']))
			$model->attributes=$_GET['RktBulan'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RktBulan the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=RktBulan::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RktBulan $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rkt-bulan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        public function actionSyncrktbulan(){
              //init update bulan
                
              $tahun = Rkt::model()->getListTahun();
            
              foreach($tahun as $tahunRkt){
                    $rktlist = Rkt::model()->getRktListByTahun($tahunRkt['tahun']);  

      //                    print_r("<pre>");
      //                    print_r($rktlist);
      //                    print_r("</pre>");


                    foreach($rktlist as $rkt){
                          $rBibit = RealisasiRktBibit::model()->get4UpdateBulanByIdRkt($rkt['id']);
                          $rArealKerja = RealisasiRktArealKerja::model()->get4UpdateBulanByIdRkt($rkt['id']);
                          $rPelihara = RealisasiRktPelihara::model()->get4UpdateBulanByIdRkt($rkt['id']);
                          $rTanam = RealisasiRktTanam::model()->get4UpdateBulanByIdRkt($rkt['id']);


                          $res1 = $this->cekUpdateBulan($rBibit);
                          $res2 = $this->cekUpdateBulan($rArealKerja);
                          $res3 = $this->cekUpdateBulan($rPelihara);
                          $res4 = $this->cekUpdateBulan($rTanam);

                    }
              }
                
                $model=new RktBulan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RktBulan']))
			$model->attributes=$_GET['RktBulan'];

		$this->redirect(array('index'));
                
        }
        
        
        public function cekUpdateBulan($objList){
            if(sizeof($objList) > 0){
                foreach($objList as $item){

                    $objBulan = RktBulan::model()->findByAttributes(array('id_rkt'=>$item['id_rkt'],'tahun'=>$item['tahun'],'bulan'=>$item['bulan']));

                    if(sizeof($objBulan)==0){
                        $newObjBulan = new RktBulan();
                        $newObjBulan->id_rkt = $item['id_rkt'];
                        $newObjBulan->tahun = $item['tahun'];
                        $newObjBulan->bulan = $item['bulan'];

                            $newObjBulan->save();

          //              print_r("<pre>");
          //              print_r(sizeof($objBulan));
          //              print_r("</pre>");
          //                die();
                    }
                }
                return 1;
            }
            else{
                return 0;
            }
        }
  
  
}
