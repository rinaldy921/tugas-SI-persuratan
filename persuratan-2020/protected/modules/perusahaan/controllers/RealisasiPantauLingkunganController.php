<?php

class RealisasiPantauLingkunganController extends Controller
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
                    'inputRealisasi'
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
			'condition'=>'status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()
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
            $id_bulan = $_POST['FormPeriodeRealisasiPrasyarat']['periode'];
			$tahun_periode = substr($_POST['FormPeriodeRealisasiPrasyarat']['tahun_periode'], -4, 4);
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
        if(isset($rkt)){
			$modPantau = new RealisasiRktPemantauanLingkungan;
			$modPantau->id_rkt = $rkt->id;
			$modPantau->id_bulan = $id_bulan;
			$modPantau->tahun = $tahun_periode;
		}

		$this->render('index',array(
            'model'=>$rkt,
            'tahun'=>$tahun,
            'id_bulan'=>$id_bulan,
			'modPantau'=>$modPantau
		));
	}

    public function actionInputRealisasi(){
		if(isset($_POST['RealisasiRktLingkunganDalmakit'])){
			$id = Yii::app()->request->getParam('id');
			$modelRealisasi = RealisasiRktLingkunganDalmakit::model()->findByPk($id,
			array(
				'select'=>array(
					't.*',
					'COALESCE(SUM(bulan_lalu.realisasi), 0) AS sd_bulan_lalu',
					'(COALESCE(SUM(bulan_lalu.realisasi), 0) + t.realisasi) AS sd_sekarang'
				),
				'join'=>'LEFT JOIN '. RealisasiRktLingkunganDalmakit::model()->tableName() .' bulan_lalu ON
					bulan_lalu.id_rkt_lingkungan_dalmakit = t.id_rkt_lingkungan_dalmakit AND
					CAST(CONCAT(bulan_lalu.tahun,bulan_lalu.id_bulan) AS UNSIGNED) < CAST(CONCAT(t.tahun,t.id_bulan) AS UNSIGNED)'
			));
			$modelRealisasi->attributes = $_POST['RealisasiRktLingkunganDalmakit'];
			$coba = (($modelRealisasi->sd_bulan_lalu + $modelRealisasi->realisasi) / $modelRealisasi->idRktLingkunganDalmakit->jumlah) * 100;
			$coba = number_format($coba,2);
			$modelRealisasi->persentase = $coba;
			if($modelRealisasi->save()) {
				if (Yii::app()->request->isAjaxRequest){
					$modelRealisasi = RealisasiRktLingkunganDalmakit::model()->findByAttributes(array(
			            'id_bulan' => $modelRealisasi->id_bulan,
			            'tahun' => $modelRealisasi->tahun
					),
					array(
						'select'=>array(
							't.*',
							'COALESCE(SUM(bulan_lalu.realisasi), 0) AS sd_bulan_lalu',
							'(COALESCE(SUM(bulan_lalu.realisasi), 0) + t.realisasi) AS sd_sekarang'
						),
						'join'=>'LEFT JOIN '. RealisasiRktLingkunganDalmakit::model()->tableName() .' bulan_lalu ON
							bulan_lalu.id_rkt_lingkungan_dalmakit = t.id_rkt_lingkungan_dalmakit AND
							CAST(CONCAT(bulan_lalu.tahun,bulan_lalu.id_bulan) AS UNSIGNED) < CAST(CONCAT(t.tahun,t.id_bulan) AS UNSIGNED)'
					));
					$this->renderPartial('_index_ajax',array(
						'modelRealisasi'=>$modelRealisasi
					));
					Yii::app()->end();
				}
			}
		}
		/*
        $post = $_POST['pk'];
        $value = $_POST['value'];

		$realisasi = RealisasiRktBibit::model()->findByPk($post);
        $_md = RktBibit::model()->findByPk($realisasi->id_rkt_bibit);

		Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RealisasiRktBibit');
        if($_POST['name'] == 'realisasi'){
			if((!isset($_md->jumlah) || $_md->jumlah == 0)){
				$model->error('Rencana tidak boleh kosong');
				die;
			}elseif(floatval($_md->jumlah) < $_POST['value']){
	            $model->error('Realisasi tidak boleh lebih dari ' . $_md->jumlah);
				die;
	        }
        }
        $model->update();

		if(isset($_md->jumlah) && isset($realisasi->realisasi)){
			$criteria = new CDbCriteria;
			$criteria->select = array(
				'COALESCE(SUM(bulan_lalu.realisasi), 0) AS sd_bulan_lalu',
				'(COALESCE(SUM(bulan_lalu.realisasi), 0) + t.realisasi) AS sd_sekarang'
			);
			$criteria->compare('t.id_rkt_bibit',$realisasi->id_rkt_bibit);
			$criteria->compare('t.id_bulan',$realisasi->id_bulan);
			$criteria->compare('t.tahun',$realisasi->tahun);
			$criteria->join = 'LEFT JOIN realisasi_rkt_bibit bulan_lalu ON
				bulan_lalu.id_rkt_bibit = t.id_rkt_bibit AND
				CAST(CONCAT(bulan_lalu.tahun,bulan_lalu.id_bulan) AS UNSIGNED) < CAST(CONCAT(t.tahun,t.id_bulan) AS UNSIGNED)';
			$criteria->group = 't.id_rkt_bibit';
			$getRealisasi = RealisasiRktBibit::model()->find($criteria);

            $coba = (($getRealisasi->sd_bulan_lalu + $value) / $_md->jumlah) * 100;
			$coba = number_format($coba,2);
            $realisasi->realisasi = $value;
            $realisasi->persentase = $coba;
			$realisasi->updated = new CDbExpression('NOW()');
			$realisasi->save();
        }
		*/
    }
}
