<?php

class InputRKTController extends Controller {

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
                    'formRKTTanam',
                    'formRKTTanamByRKU',
                    'formAlasanTanam',
                    'formRktDismatchRKU'
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

    public function actionFormRKTTanam($rkutanam) {
        $ModelRKU = RkuTanam::model()->findByPk($rkutanam);
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $ModelRKU->id_rku . ' AND tahun_mulai=' . $ModelRKU->tahun));
        //debug($rkt);
        //debug($ModelRKU);

        $ModelRktTanam = new RktTanam2;

        if (isset($_POST['RktTanam2'])) {
            $ModelRktTanam->attributes = $_POST['RktTanam2'];

            if ($ModelRktTanam->save()) {
                $data = array(
                    'header' => "Sukses",
                    'message' => "Data Berhasil Disimpan",
                    'status' => "success",
                );
            } else {
                debug($ModelRktTanam);
                $data = array(
                    'header' => "Error",
                    'message' => "Data Gagal Disimpan",
                    'status' => "error"
                );
            }

            echo json_encode($data);
            die();
        } else {
            $ModelRktTanam->attributes = array(
                '_tahun' => $ModelRKU->tahun,
                'daur' => $ModelRKU->daur,
                '_blok' => $ModelRKU->idBlok->idBlok->nama_blok,
                '_sektor' => $ModelRKU->idBlok->idSektor->nama_sektor,
                '_tata_ruang' => $ModelRKU->idJenisProduksiLahan->jenis_produksi,
                '_jenis_lahan' => $ModelRKU->idJenisLahan->jenis_lahan,
                'id_rkt' => $rkt->id,
                'id_blok' => $ModelRKU->id_blok,
                'id_jenis_produksi_lahan' => $ModelRKU->id_jenis_produksi_lahan,
                'id_jenis_lahan' => $ModelRKU->id_jenis_lahan,
                'id_rku_tanam' => $ModelRKU->id
            );
        }

        $this->renderPartial('form-rkt-tanam', array(
            'model' => $ModelRktTanam,
            'modelRKU' => $ModelRKU
        ));
    }

    public function actionFormRKTTanamByRKU($tahun) {
        //debug($tahun);
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        //$rku_tanam = RktTanam::model()->find(array('condition' => 'id_rku = '.$rku->id_rku.' AND tahun = ' . $tahun));

        $criteria = new CDbCriteria();
        //$criteria->distinct = true;
        $criteria->condition = "id_rku=" . $rku->id_rku . " AND tahun = " . $tahun;
        //$criteria->select = 'id_blok';
        #$listRKU = RkuTanam::model()->findAll($criteria);
        #RkuTanam::model();

        $model = new RkuTanam('search');
        $model->unsetAttributes();  // clear any default values
        $model->attributes = array("id_rku" => $rku->id_rku, "tahun" => $tahun);
        //if (isset($_GET['Perusahaan']))
        //$model->attributes = $_GET['Perusahaan'];
        //debug($listRKU);
        //$model = new RkuTanam('search');

        $this->renderPartial('choose-rku-tanam', array(
            'model' => $model
        ));
    }
    
    public function actionFormAlasanTanam($tahun=0)
    {
        $model = new RktTanamAlasan;
        if (isset($_POST['RktTanamAlasan'])) {
            $model->attributes = $_POST['RktTanamAlasan'];
            $file_error = 0;
            $msg        = "";
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
                $name4 = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file1) && strtolower($ext) == "pdf") {
                    $file1->saveAs($name4);
                    $model->file = $new_path;
                } else {
                    $file_error++;
                    $msg = "File harus PDF";
                }
            }

            if($file_error == 0) {
                if ($model->save()) {
                    //$_SESSION['id_alasan_rkt'] = $model->id;
                    $data = array(
                        'header' => "Sukses",
                        'message'=> "Data Berhasil Disimpan",
                        'status' => "success",
                        'id'     => $model->id,
                        'tahun' => $tahun
                    );
                } else {
                    //debug($model->errors);
                    $data = array(
                        'header' => "Error",
                        'message'=> "Data Gagal Disimpan",
                        'status' => "error",
                        'id'     => 0
                    );
                }
            } else {
                $data = array(
                    'header' => "Gagal Menyimpan Data",
                    'message'=> $msg,
                    'status' => "information",
                    'id'     => 0
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_alasan_tanam', array(
            'model' => $model,
            'tahun' => $tahun
        ));
    }
    
    
    public function actionFormRktDismatchRKU($alasan=0, $tahun=0)
    {
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku. " AND tahun_mulai = ".$tahun));
        $bloksektor = BlokSektor::model()->findAll(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_rku = ' . $rku->id_rku));

        $model = new RktTanam;
        $model->attributes = array(
            'id_rkt_tanam_alasan' => $alasan,
            'id_rkt' => $rkt->id
        );
        if (isset($_POST['RktTanam'])) {
            // echo "<pre>";
            // print_r($_POST);
            // die();
            //$_POST['RktTanam']['id_rkt'] = $rkt->id;
            //$_POST['RktTanam']['id_rkt_tanam_alasan'] = $alasan;
            $model->attributes = $_POST['RktTanam'];
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
                    'message'=> "Data Berhasil Disimpan",
                    'status' => "success"
                );
            } else {
                //debug($model);
                //debug($model->errors);
                $data = array(
                    'header' => "Error",
                    'message'=> "Data Gagal Disimpan",
                    'status' => "error",
                    'id'     => 0
                );
            }

            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_rkt_notin_rku', array(
            'model' => $model,
            'rku'   => $rku,
            'rkt'   => $rkt,
            'bloksektor' => $bloksektor,
            'alasan' => $alasan,
            'tahun' => $tahun
        ));
    }
    

}
