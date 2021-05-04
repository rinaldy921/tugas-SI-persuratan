<?php

class RealisasiPenanamanController extends Controller {

    public $layout = false;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'index',
                    'view'
                ),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array(
                'allow',
                'actions' => array(
                    'inputJumlahTanam'
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

    public function actionIndex() 
        {
        $rku = Rku::model()->find(array(
                        'condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan()
                ));    
        $rkt = Rkt::model()->find(array(
			'condition'=>'status = 1 AND id_perusahaan = :id_perusahaan AND id_rku = :id_rku',
			'params'=>array(
				':id_perusahaan'=>Yii::app()->user->idPerusahaan(),
				':id_rku'=>$rku->id_rku
			),
			'order'=>'tahun_mulai DESC'
		));
                
        
        if (!isset($rkt)) {
                        echo "<div class='alert alert-danger'>Data RKT belum tersedia.</div>";
                        exit;
        }
        $tahun = $rkt->tahun_mulai;
        $id_bulan = '1';
        $tahun_periode = $tahun;
        
        if (isset($_POST['FormPeriodeRealisasiPrasyarat'])) {
            $rkt = Rkt::model()->find(array(
                'condition' => 'id_perusahaan = :id_perusahaan AND status = 1 AND tahun_mulai = :tahun_mulai AND id_rku = :id_rku',
                'params' => array(
                    ':id_perusahaan' => Yii::app()->user->idPerusahaan(),
                    ':tahun_mulai' => $_POST['FormPeriodeRealisasiPrasyarat']['rkt'],
                    ':id_rku' => $rku->id_rku
                ),
                'order' => 'tahun_mulai DESC'
            ));
            if(!isset($rkt)){
				echo "<div class='alert alert-danger'>Data RKT tahun ". $_POST['Rkt']['tahun_mulai'] ." belum tersedia.</div>";
				exit;
            }
            $tahun = $rkt->tahun_mulai;
            $tmpBulan = explode('_',$_POST['FormPeriodeRealisasiPrasyarat']['periode']);
	    $tahun_periode = substr($_POST['FormPeriodeRealisasiPrasyarat']['tahun_periode'], -4, 4);
            
            $id_bulan = $tmpBulan[0];
            $tahun = $tmpBulan[1];
        }
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['aksi']) && $_GET['aksi'] === 'updateGrid') {
                $tahun = $_GET['tahun'];
                $id_bulan = $_GET['id_bulan'];
                $tahun_periode = $_GET['tahun_periode'];
                $rkt = Rkt::model()->find(array(
                    'condition' => 'id_perusahaan = :id_perusahaan AND status = 1 AND tahun_mulai = :tahun_mulai AND id_rku = :id_rku',
                    'params' => array(
                        ':id_perusahaan' => Yii::app()->user->idPerusahaan(),
                        ':tahun_mulai' => $tahun,
                        ':id_rku' => $rku->id_rku
                    ),
                    'order' => 'tahun_mulai DESC'
                ));
                $tahun = $tahun;
                $id_bulan = $id_bulan;
            }
        }
        if (isset($rkt)) {
            $idRkt = $rkt->id;
            $md = RktTanam::model()->findAllByAttributes(array(
                'id_rkt' => $idRkt
            ));
            if ($md) {
                foreach ($md as $key => $value) {
                    $is_exist = RealisasiRktTanam::model()->findByAttributes(array(
                        'id_rkt_tanam' => $value->id,
                        'id_bulan' => $id_bulan,
                        'tahun'=>$tahun,
                    ));
                    if (!$is_exist) {
                        $realisasi = new RealisasiRktTanam;
                        $realisasi->id_rkt_tanam = $value->id;
                        $realisasi->id_bulan = $id_bulan;
                        $realisasi->tahun = $tahun_periode;
                        $realisasi->realisasi = 0;
                        $realisasi->persentase = 0;
                        $realisasi->created = new CDbExpression('NOW()');
                        $realisasi->updated = new CDbExpression('NOW()');
                        $realisasi->save();
                    }
                    //cek rkt bulan
                    $mRktBulan = new RktBulan();
                    $mRktBulan->updateRktBulan($idRkt,$tahun_periode,$id_bulan);
                }
            }

            $modelTanam = new RealisasiRktTanam;
            $modelTanam->unsetAttributes();
            if (isset($_GET['RealisasiRktTanam']))
                $modelTanam->attributes = $_GET['RealisasiRktTanam'];
            $modelTanam->id_rkt = $rkt->id;
            $modelTanam->id_bulan = $id_bulan;
            $modelTanam->tahun = $tahun_periode;
        }
        $this->render('index', array(
            'model' => $rkt,
            'tahun' => $tahun,
            'id_bulan' => $id_bulan,
            'tahun_periode' => $tahun_periode,
            'modelTanam' => $modelTanam
        ));
    }

    public function actionInputJumlahTanam() {
        $post = $_POST['pk'];
        $value = $_POST['value'];

        $realisasi = RealisasiRktTanam::model()->findByPk($post);
        $_md = RktTanam::model()->findByPk($realisasi->id_rkt_tanam);

        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RealisasiRktTanam');
        if ($_POST['name'] == 'realisasi') {
            if ((!isset($_md->jumlah) || $_md->jumlah == 0)) {
                $model->error('Rencana tidak boleh kosong');
                die;
            } elseif (floatval($_md->jumlah) < $_POST['value']) {
                $model->error('Realisasi tidak boleh lebih dari ' . $_md->jumlah);
                die;
            }
        }
        $model->update();

        if (isset($_md->jumlah) && isset($realisasi->realisasi)) {
            $criteria = new CDbCriteria;
            $criteria->select = array(
                'COALESCE(SUM(t.realisasi), 0) AS realisasi'
            );
            $criteria->compare('t.id_rkt_tanam', $realisasi->id_rkt_tanam);
            $getRealisasi = RealisasiRktTanam::model()->find($criteria);

            $coba = ($getRealisasi->realisasi / $_md->jumlah) * 100;
            $coba = number_format($coba, 2);

            $realisasi->realisasi = $value;
            $realisasi->persentase = number_format((($value / $_md->jumlah) * 100), 2);
            $realisasi->updated = new CDbExpression('NOW()');
            $realisasi->save();

            $_md->realisasi = ($getRealisasi->realisasi);
            $_md->persentase = $coba;
            $_md->update();
        }
    }

}
