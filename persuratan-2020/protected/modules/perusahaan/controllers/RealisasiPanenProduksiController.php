<?php

class RealisasiPanenProduksiController extends Controller
{
	public $layout=false;
	public function filters()
	{
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
                    'InputJumlahPanenProduksi'
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
                                        echo "<div class='alert alert-danger'>Data RKT tahun ". $_POST['FormPeriodeRealisasiPrasyarat']['rkt'] ." belum tersedia.</div>";
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
                                $id_bulan = $id_bulan;
				$tahun_periode = $_GET['tahun_periode'];
                                
                                
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
                $id_bulan = $id_bulan;
            }
        }
        if(isset($rkt)){
                    
                    
//                    $tmpbulan = explode("_",$id_bulan);
//                    $id_bulan = $tmpbulan['0'];
//                    $tahun = $tmpbulan['1'];  
                              
                   
                    
			$idRkt = $rkt->id;
			$md = RktPanenProduksi::model()->findAllByAttributes(array(
				'id_rkt'=>$idRkt
			));
			if($md){
				foreach($md as $key => $value){
					$is_exist = RealisasiRktPanenProduksi::model()->findByAttributes(array(
						'id_rkt_panen_produksi'=>$value->id,
						'id_bulan'=>$id_bulan,
                                                'tahun'=>$tahun,                  //new
					));
					if(!$is_exist){
						$realisasi = new RealisasiRktPanenProduksi;
						$realisasi->id_rkt_panen_produksi = $value->id;
						$realisasi->id_bulan = $id_bulan;
						$realisasi->tahun = $tahun_periode;
						$realisasi->realisasi_produksi = 0;
                                                $realisasi->realisasi_luas = 0;
						$realisasi->persentase_produksi = 0;
						$realisasi->persentase_luas = 0;
						$realisasi->created = new CDbExpression('NOW()');
						$realisasi->updated = new CDbExpression('NOW()');
						$realisasi->save();
					}
                                        
                                        //cek rkt bulan
                                        $mRktBulan = new RktBulan();
                                        $mRktBulan->updateRktBulan($idRkt,$tahun_periode,$id_bulan);
				}
			}

            $modelPanenProduksi = new RealisasiRktPanenProduksi;
            $modelPanenProduksi->unsetAttributes();
            if (isset($_GET['RealisasiRktPanenProduksi']))
                $modelPanenProduksi->attributes = $_GET['RealisasiRktPanenProduksi'];
                $modelPanenProduksi->id_rkt = $rkt->id;
			$modelPanenProduksi->id_bulan = $id_bulan;
			$modelPanenProduksi->tahun = $tahun_periode;
		}
                
//                $tmp = $modelPanenProduksi->searchByRkt()->all();
//                
//                
//              print_r("<pre>");
//                    print_r($id_bulan);
//                    print_r("</pre>");
//                    die();
                
		$this->render('index',array(
                                'model'=>$rkt,
                                'tahun'=>$tahun,
                                'id_bulan'=>$id_bulan,
                                'tahun_periode'=>$tahun_periode,
                                'modelPanenProduksi'=>$modelPanenProduksi
		));
	}
        
        
        
        
	public function actionInputJumlahPanenProduksi(){
                $post = $_POST['pk'];
		$value = $_POST['value'];
                $name = $_POST['name'];

		$realisasi = RealisasiRktPanenProduksi::model()->findByPk($post);
                $_md = RktPanenProduksi::model()->findByPk($realisasi->id_rkt_panen_produksi);

//                        print_r("<pre>");
//                        print_r($value);
//                        print_r("<pre>");
//                        die();       
                
                Yii::import('booster.components.TbEditableSaver');
                $model = new TbEditableSaver('RealisasiRktPanenProduksi');
                
                if($name == 'realisasi_produksi'){
                        if ((!isset($_md->jumlah_produksi) || $_md->jumlah_produksi == 0)){
                                $model->error('Rencana tidak boleh kosong');
                                die;
                        }
//                        elseif(floatval($_md->jumlah_produksi) < $_POST['value']){
//                                $model->error('Realisasi tidak boleh lebih dari ' . $_md->jumlah_produksi);
//                                die;
//                        }

                }
                else if($name == 'realisasi_luas'){
                        if ((!isset($_md->jumlah_luas) || $_md->jumlah_luas == 0)){
                                $model->error('Rencana tidak boleh kosong');
                                die;
                        }
//                        elseif(floatval($_md->jumlah_luas) < $_POST['value']){
//                                $model->error('Realisasi tidak boleh lebih dari ' . $_md->jumlah_luas);
//                                die;
//                        }
                }
                $model->update();
                        

                if($name == 'realisasi_produksi'){        
                if(isset($_md->jumlah_produksi) && isset($realisasi->realisasi_produksi)){
                        $criteria = new CDbCriteria;
                        $criteria->select = array(
                        'COALESCE(SUM(t.realisasi_produksi), 0) AS realisasi_produksi'
                        );
                        $criteria->compare('t.id_rkt_panen_produksi',$realisasi->id_rkt_panen_produksi);
                        $getRealisasi = RealisasiRktPanenProduksi::model()->find($criteria);

                        $coba = ($getRealisasi->realisasi_produksi / $_md->jumlah_produksi) * 100;
                        $coba = number_format($coba,2);


                        $realisasi->realisasi_produksi = $value;
                        $realisasi->persentase_produksi = number_format((($value / $_md->jumlah_produksi) * 100), 2);
                        $realisasi->updated = new CDbExpression('NOW()');

//                                        print_r("<pre>");
//                                        print_r($realisasi);
//                                        print_r("<pre>");
//                                        die();


                        $realisasi->save();

                        $_md->realisasi_produksi = ($getRealisasi->realisasi_produksi);
                        $_md->persentase_produksi = $coba;
                        $_md->update();

                    }
                }   
                 if($name == 'realisasi_luas'){        
                        if(isset($_md->jumlah_luas) && isset($realisasi->realisasi_luas)){
                                $criteria = new CDbCriteria;
                                $criteria->select = array(
                                        'COALESCE(SUM(t.realisasi_luas), 0) AS realisasi_luas'
                                );
                                $criteria->compare('t.id_rkt_panen_produksi',$realisasi->id_rkt_panen_produksi);
                                $getRealisasi = RealisasiRktPanenProduksi::model()->find($criteria);

                                $coba = ($getRealisasi->realisasi_luas / $_md->jumlah_luas) * 100;
                                $coba = number_format($coba,2);
                                
                                $realisasi->realisasi_luas = $value;
                                $realisasi->persentase_luas = number_format((($value / $_md->jumlah_luas) * 100), 2);
                                $realisasi->updated = new CDbExpression('NOW()');

                                $realisasi->save();

                                $_md->realisasi_luas = ($getRealisasi->realisasi_luas);
                                $_md->persentase_luas = $coba;
                                $_md->update();


                        }
                }  

    }
}
