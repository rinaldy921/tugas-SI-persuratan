<?php

class IuphhkController extends Controller {

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
                'actions' => array('index', 'create', 'update', 'delete','revisi'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index'),
//                'users' => array(Yii::app()->user->pimpinanUmRole()),
//            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Iuphhk;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)){
           mkdir($ngepath,  0777, true);
        }
        $msg = "";

        if (isset($_POST['Iuphhk'])) {
            //debug($_POST['Iuphhk']);
            $model->attributes = $_POST['Iuphhk'];
            // $jml_blok = $_POST['Iuphhk']['blok'];
            // $sektor = isset($_POST['Iuphhk']['sektor']) ? $_POST['Iuphhk']['sektor'] : NULL;
            // $blokcustom = isset($_POST['Iuphhk']['blokcustom']) ? $_POST['Iuphhk']['blokcustom'] : NULL;
            // var_dump($blokcustom[0]);die;

            $file_error = 0;
            if ($_FILES["pdf_sk"]["error"] == 0)
            {
                $file1  = CUploadedFile::getInstanceByName('pdf_sk');
                $ukuran_file = $_FILES['pdf_sk']['size'];
                $ran = rand();
                $ext = $file1->getExtensionName();
                $realName = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ','_',$realName);
                $new_name = "SK_".$replaceFile.'_'.$ran.'.'.$ext;
                $new_path = '/files/PDF/'.$p.'/'.$new_name;
                $name4 = dirname(Yii::app()->request->scriptFile) .$new_path;
                if(!empty($file1) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152){
                    if($file1->saveAs($name4)) {
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

            if($file_error == 0) {
                if ($model->save()) {
                    // if($blokcustom == NULL) {
                    //     $this->generateBlok($model->id_iuphhk, $model->id_perusahaan, NULL, $jml_blok);
                    // } else {
                    //     $this->generateSektorBlok($model->id_iuphhk, $model->id_perusahaan, $sektor, $blokcustom);
                    // }

                    $message = Yii::t('app', 'Data berhasil disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                }
            } else {
                $message = Yii::t('app', 'Data Gagal disimpan, Karena File Gagal Diupload. '.$msg);
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index'));
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
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)){
           mkdir($ngepath,  0777, true);
        }
        $msg = "";

        if (isset($_POST['Iuphhk'])) {
            $model->attributes = $_POST['Iuphhk'];

            $file_error = 0;
            if ($_FILES["pdf_sk"]["error"] == 0)
            {
                $file1  = CUploadedFile::getInstanceByName('pdf_sk');
                $ukuran_file = $_FILES['pdf_sk']['size'];
                $ran = rand();
                $ext = $file1->getExtensionName();
                $realName = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ','_',$realName);

                $new_name = "SK_".$replaceFile.'_'.$ran.'.'.$ext;
                $new_path = '/files/PDF/'.$p.'/'.$new_name;
                $name4 = dirname(Yii::app()->request->scriptFile) .$new_path;
                if(!empty($file1) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152){
                    if($file1->saveAs($name4)) {
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

            if($file_error == 0) {
                if ($model->save()) {
                    $message = Yii::t('app', 'Data berhasil disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                }
            } else {
                $message = Yii::t('app', 'Data Gagal disimpan, Karena File Gagal Diupload. '.$msg);
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index'));
            }

        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionRevisi($id)
    {
        $model = $this->loadModel($id);

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)){
           mkdir($ngepath,  0777, true);
        }
        $msg = "";

        if (isset($_POST['Iuphhk'])) {
            $model_lama = new Iuphhk;
            $model_lama->id_perusahaan = $model->id_perusahaan;
            $model_lama->nomor = $model->nomor;
            $model_lama->tanggal = $model->tanggal;
            $model_lama->luas = $model->luas;
            $model_lama->status = 0;
            $model_lama->investasi_rupiah = $model->investasi_rupiah;
            $model_lama->investasi_dolar = $model->investasi_dolar;
            $model_lama->tgl_start = $model->tgl_start;
            $model_lama->tgl_end = $model->tgl_end;
            $model_lama->is_dicabut = $model->is_dicabut;
            $model_lama->keterangan_dicabut = $model->keterangan_dicabut;
            $model_lama->no_sk_pencabutan = $model->no_sk_pencabutan;
            $model_lama->file_doc = $model->file_doc;
            $model_lama->nama_perusahaan = $model->nama_perusahaan;
            $model_lama->tgl_dicabut = $model->tgl_dicabut;
            $model_lama->id_iuphhk = null;
            $model_lama->id_parent = $id;
            $model_lama->merevisi_id = $model->merevisi_id;
            $model_lama->save();

            $model->attributes = $_POST['Iuphhk'];
            $model->merevisi_id = $model_lama->id_iuphhk;

            $file_error = 0;
            if ($_FILES["pdf_sk"]["error"] == 0)
            {
                $ukuran_file1 = $_FILES['pdf_sk']['size'];
                $file1  = CUploadedFile::getInstanceByName('pdf_sk');
                $ran = rand();
                $ext = $file1->getExtensionName();
                $realName = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ','_',$realName);

                $new_name = "SK_".$replaceFile.'_'.$ran.'.'.$ext;
                $new_path = '/files/PDF/'.$p.'/'.$new_name;
                $name4 = dirname(Yii::app()->request->scriptFile) .$new_path;
                if(!empty($file1) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152){
                    if($file1->saveAs($name4)) {
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

            if($file_error == 0) {
                if ($model->save()) {

                    $message = Yii::t('app', 'Data berhasil disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                }
            } else {
                $message = Yii::t('app', 'Data Gagal disimpan, Karena File Gagal Diupload. '.$msg);
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index'));
            }

        }

        $this->render('revisi', array(
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
            $this->loadModel($id)->delete();

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
        $model = Iuphhk::model()->find(array(
            'condition' => 'id_perusahaan=' . Yii::app()->user->idPerusahaan().' AND status=1'
        ));
        $modelRevisi = new Iuphhk('searchrevisi');
        $modelRevisi->id_parent = $model->id_iuphhk;

        if (empty($model))
            $this->redirect(array('create'));
//            $model = array();
        $this->render('index', array(
            'model' => $model,
            'modelRevisi' => $modelRevisi
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Iuphhk::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'iuphhk-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function generateBlok($iuphhk, $perusahaan, $sektor, $blok) {
        for ($i = 1; $i <= $blok; $i++) {
            $model = new BlokSektor;
            $model->id_iuphhk = $iuphhk;
            $model->id_perusahaan = $perusahaan;
            $model->id_sektor = $sektor;
            $model->id_blok = $i;
            $model->save();
        }
        return true;
    }

    function generateSektorBlok($iuphhk,$perusahaan,$sektor,$blok) {
        // var_dump($sektor);die;
        foreach($blok as $key => $value) {
            // var_dump($value);die;
            for($i = 0; $i < (int) $value; $i++) {
                $model = new BlokSektor;
                $model->id_iuphhk = $iuphhk;
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

}
