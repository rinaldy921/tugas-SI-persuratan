<?php

class RktPemanenanLahanController extends Controller {

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

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'pilihRKU',
                    'formRktMatch',
                    'entryAlasan',
                    'formRktDismatch',
                    'index'
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
    
    public function actionIndex($rkt) {
        //debug($rkt);
        $model = new RktPanenLahan();
        $model->unsetAttributes();
        $model->attributes = array(
            'id_rkt' => $rkt
        );                
		
		$cs = Yii::app()->clientScript;
		$cs->reset();
		$cs->scriptMap = array(
			'jquery.js' => false, // prevent produce jquery.js in additional javascript data
			'jquery.min.js' => false,
		);

        $this->renderPartial('index', array(
            'model' => $model,
            'rkt' => $rkt
            //'model2' => $model2,
        ),false,true); // bagian ini biasanaya yang perlu di perhatikan saat render partial ajax
    }
	
	public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request
            $this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
	
	public function loadModel($id) {
        $model = RktPanenLahan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
	

    public function actionFormRktMatch($rku) {
        $ModelRKU = RkuPanen::model()->findByPk($rku);
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $ModelRKU->id_rku . ' AND rkt_ke=' . $ModelRKU->rkt_ke));
        //debug($rkt);
        //debug($ModelRKU);

        $ModelRKT = new RktPanenLahan;

        if (isset($_POST['RktPanenLahan'])) {
            $ModelRKT->attributes = $_POST['RktPanenLahan'];

            if ($ModelRKT->save()) {
                $data = array(
                    'header' => "Sukses",
                    'message' => "Data Berhasil Disimpan",
                    'status' => "success",
                );
            } else {
                debug($ModelRKT);
                $data = array(
                    'header' => "Error",
                    'message' => "Data Gagal Disimpan",
                    'status' => "error"
                );
            }

            echo json_encode($data);
            die();
        } else {
            //die($ModelRKU->tahun);
            #$ModelRKT->unsetAttributes();
            $ModelRKT->attributes = array(
                'daur' => $ModelRKU->daur,
                '_tahun' => $ModelRKU->tahun,                
                '_blok' => $ModelRKU->idBlok->nama_blok,
                '_sektor' => $ModelRKU->idBlok->namaSektor->nama_sektor,
                'id_kabupaten' => $ModelRKU->id_kabupaten,
                'namaKabupaten' => $ModelRKU->namaKabupaten->nama,
                //'_jenis_lahan' => 'Hutan Tanaman',
                //'id_jenis_lahan' => 3,
                'id_rkt' => $rkt->id,
                'id_blok' => $ModelRKU->id_blok,
                'id_rku_panen' => $ModelRKU->id,
                'rkt_ke' => $ModelRKU->rkt_ke,
                
                //'jumlah_luas' => $ModelRKU->jumlah,
                //'jumlah_produksi' => $ModelRKU->produksi,
            );
            //debug($ModelRKT);
        }
            
        $this->renderPartial('form-rkt-match', array(
            'model' => $ModelRKT,
            'modelRKU' => $ModelRKU,
            'rku' => $rku
        ));
    }

    public function actionPilihRKU($tahun) {
        //debug($tahun);
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        //$rku_tanam = RktTanam::model()->find(array('condition' => 'id_rku = '.$rku->id_rku.' AND tahun = ' . $tahun));

        //$criteria = new CDbCriteria();
        //$criteria->distinct = true;
        //$criteria->condition = "id_rku=" . $rku->id_rku . " AND tahun = " . $tahun;

        $model = new RkuPanen('searchByRkt');
        $model->unsetAttributes();  // clear any default values
        $model->attributes = array(
            "id_rku" => $rku->id_rku, "rkt_ke" => $tahun,
            'keterangan' => 'Penyiapan Lahan'
        );

        $this->renderPartial('pilih-rku', array(
            'model' => $model
        ));
    }

    public function actionEntryAlasan($tahun = 0) {
        $model = new RktFormAlasan();
        if (isset($_POST['RktFormAlasan'])) {
            $model->attributes = $_POST['RktFormAlasan'];
            $file_error = 0;
            $msg = "";
            $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
            $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
            $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
            $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
            if (!is_dir($ngepath)) {
                mkdir($ngepath, 0777, true);
            }

            if ($_FILES["pdf_alasan"]["error"] == 0) {
                $file1 = CUploadedFile::getInstanceByName('pdf_alasan');
                $ran = rand();
                $ext = $file1->getExtensionName();
                $realName = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "ARKT_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name4 = dirname(Yii::app()->request->scriptFile) . $new_path;
                if (!empty($file1) && strtolower($ext) == "pdf") {
                    $file1->saveAs($name4);
                    $model->file = $new_path;
                } else {
                    $file_error++;
                    $msg = "File harus PDF";
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
                    //$_SESSION['id_alasan_rkt'] = $model->id;
                    $data = array(
                        'header' => "Sukses",
                        'message' => "Data Berhasil Disimpan",
                        'status' => "success",
                        'id' => $model->id,                        
                        'rkt_ke' => $model->rkt_ke,
                        'tahun' => $tahun
                    );
                } else {
                    //debug($model->errors);
                    $data = array(
                        'header' => "Error",
                        'message' => "Data Gagal Disimpan",
                        'status' => "error",
                        'id' => 0
                    );
                }
            } else {
                $data = array(
                    'header' => "Gagal Menyimpan Data",
                    'message' => $msg,
                    'status' => "information",
                    'id' => 0
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('form-alasan', array(
            'model' => $model,
            'tahun' => $tahun
        ));
    }

    public function actionFormRktDismatch($alasan = 0, $tahun = 0) {
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku . " AND rkt_ke = " . $tahun));
        $bloksektor = RkuBlok::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));

        $model = new RktPanenLahan();
        $model->attributes = array(
            'id_rkt_form_alasan' => $alasan,            
            'id_rkt_new' => $rktNew->id,
            'rkt_ke' => $tahun,
        );
        if (isset($_POST['RktPanenLahan'])) {
            // echo "<pre>";
            // print_r($_POST);
            // die();
            //$_POST['RktTanam']['id_rkt'] = $rkt->id;
            //$_POST['RktTanam']['id_rkt_tanam_alasan'] = $alasan;
            
            $rktRef = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku . " AND rkt_ke = " .  $_POST['RktPanenLahan']['rkt_ke_new']));
            
            $model->attributes = $_POST['RktPanenLahan'];
            $model->id_rkt = $rktRef->id;
            //$model->id_rkt     = ;
            //$model->id_rkt_tanam_alasan = $alasan;

            if ($model->save()) {
                //$id_rkt_tanam = $model->id;
                //$modelAlasan = RktTanamAlasan::model()->findByPk($_SESSION['id_alasan_rkt']);
                //$modelAlasan->id_rkt_tanam = $id_rkt_tanam;
                //$modelAlasan->save(false);
                //$_SESSION['id_alasan_rkt'] = 0;

                $data = array(
                    'header' => "Sukses",
                    'message' => "Data Berhasil Disimpan",
                    'status' => "success"
                );
            } else {
                //debug($model);
                //debug($model->errors);
                $data = array(
                    'header' => "Error",
                    'message' => "Data Gagal Disimpan",
                    'status' => "error",
                    'id' => 0
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('form-rkt-dismatch', array(
            'model' => $model,
            'rku' => $rku,
            'rkt' => $rkt,
            'bloksektor' => $bloksektor,
            'alasan' => $alasan,
            'tahun' => $tahun
        ));
    }

}
