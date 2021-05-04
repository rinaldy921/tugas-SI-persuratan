<?php

class RealisasiKonflikSosialController extends Controller
{
	public $layout=false;
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
                    'inputRealisasi',
                    'delete'
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
			'condition'=>'edit_status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()
		));
        $rkt = Rkt::model()->find(array(
			'condition'=>'status = 1 AND id_perusahaan = :id_perusahaan AND id_rku = :id_rku',
			'params'=>array(
				':id_perusahaan'=>Yii::app()->user->idPerusahaan(),
				':id_rku'=>$rku->id_rku
			),
			'order'=>'tahun_mulai DESC'
		));
        if(!isset($rkt)){
			echo "<div class='alert alert-danger'>Data RKT belum tersedia.</div>";
			exit;
        }
        $tahun = $rkt->tahun_mulai;
        $id_bulan = '1';
        $tahun_periode = $tahun;
        if(isset($_POST['FormPeriodeRealisasiPrasyarat'])){
            $rkt = Rkt::model()->find(array(
				'condition'=>'id_perusahaan = :id_perusahaan AND status = 1 AND tahun_mulai = :tahun_mulai AND id_rku = :id_rku',
				'params'=>array(
					':id_perusahaan'=>Yii::app()->user->idPerusahaan(),
					':tahun_mulai'=>$_POST['FormPeriodeRealisasiPrasyarat']['rkt'],
					':id_rku'=>$rku->id_rku
				),
				'order'=>'tahun_mulai DESC'
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
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_GET['aksi']) && $_GET['aksi']==='updateGrid'){
				$tahun = $_GET['tahun'];
				$id_bulan = $_GET['id_bulan'];
				$rkt = Rkt::model()->find(array(
					'condition'=>'id_perusahaan = :id_perusahaan AND status = 1 AND tahun_mulai = :tahun_mulai AND id_rku = :id_rku',
					'params'=>array(
						':id_perusahaan'=>Yii::app()->user->idPerusahaan(),
						':tahun_mulai'=>$tahun,
						':id_rku'=>$rku->id_rku
					),
					'order'=>'tahun_mulai DESC'
				));
                $tahun = $tahun;
            }
        }
		$jenis_konflik = array();
        if(isset($rkt)){
			$idRkt = $rkt->id;
			$md = RktKonflikSosial::model()->findAllByAttributes(array(
				'id_rkt'=>$idRkt
			));
			if($md){
				$modelRealisasi->id_rkt_konflik_sosial = $idRkt;
				foreach($md as $key => $value){
					$jenis_konflik[$value['id']] = $value['jenis_konflik'];
				}
			}else{
				echo "<div class='alert alert-danger'>Data RKT untuk bulan yang anda pilih belum terdaftar, silahkan cek kembali</div>";
				exit;
			}
		}

		$modelRealisasi = new RealisasiRktKonflikSosial;
		$modelRealisasi->id_bulan = $id_bulan;
		$modelRealisasi->tahun = $tahun;

		if(isset($_POST['RealisasiRktKonflikSosial'])){
			$modelRealisasi->attributes = $_POST['RealisasiRktKonflikSosial'];
			$modelRealisasi->created = new CDbExpression('NOW()');
			$modelRealisasi->updated = new CDbExpression('NOW()');
			$pesan = array();
			if(!$modelRealisasi->save()){
				foreach($modelRealisasi->getErrors() as $key => $value){
					$pesan[$key] = implode(' ', $value);
				}
			}
			$status = 'OK';
			if (count($pesan) > 0) {
				$status = 'NOT';
			}
			echo CJSON::encode(array(
				'status'=>$status,
				'pesan'=>implode(' ', $pesan)
			));
			Yii::app()->end();
		}
		$this->render('index',array(
                                            'model'=>$rkt,
                                            'tahun'=>$tahun,
                                            'id_bulan'=>$id_bulan,
                                                        'modelRealisasi'=>$modelRealisasi,
                                                        'jenis_konflik'=>$jenis_konflik
                                                ));
	}

    public function actionInputRealisasi(){
		$post = $_POST['pk'];
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RealisasiRktKonflikSosial');
        if(strlen($_POST['value']) == 0){
            $model->error($_POST['name'] . 'Tidak boleh kosong');
            die;
        }
        $model->update();
    }

	public function actionDelete($id){
		$status = 'OK';
		$pesan = '';
        if (Yii::app()->request->isPostRequest){
			$md = RealisasiRktKonflikSosial::model()->findByPk($id);
			if(!$md->delete()){
				$status = 'NOT';
				$pesan = 'Hapus data gagal';
			}
        }
		echo CJSON::encode(array(
			'status'=>$status,
			'pesan'=>$pesan
		));
		Yii::app()->end();
    }


}
