<?php

class RealisasibulananController extends Controller {

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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'index', 'delete','absen','approve','viewprasyarat','viewfproduksi','viewflingkungan','viewsosial'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

  
    /**
     * Manages all models.
     */
    public function actionAbsen() {
        
        
        $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
        $rku = Rku::model()->find(array('condition' =>$condition));
        
        $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
        $listBulan='';
        
        if(isset($rkt['0'])){
            $rkt = $rkt['0'];
            $listBulan = RktBulan::model()->getList4Absen($rkt['id']);
        }
        
        $model = MasterBulan::model()->getListBulan();
//        print_r("<pre>");
//        print_r($listBulan);
//        print_r("</pre>");        exit(1);

        $this->render('absen',array('listbulan' => $listBulan, 'rkt'=>$rkt,'rku'=>$rku,'model'=>$model,'mode'=>'absen'));
    }

    
    /**
     * Manages all models.
     */
    public function actionApprove($bulan=null, $rktId=null) {
        
        
        $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
        $rku = Rku::model()->find(array('condition' =>$condition));
        
        $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
        $listBulan='';
        
        if(isset($rkt['0'])){
            $rkt = $rkt['0'];
            
            $update = RktBulan::model()->updateStatusApproval($rktId,$bulan);
            $listBulan = RktBulan::model()->getList4Absen($rkt['id']);
        }
        
        $model = MasterBulan::model()->getListBulan();
//        print_r("<pre>");
//        print_r($model);
//        print_r("</pre>");        exit(1);

        $this->render('absen',array('listbulan' => $listBulan, 'rkt'=>$rkt,'rku'=>$rku,'model'=>$model));
    }
    
    
    public function actionViewprasyarat(){
        $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
        $rku = Rku::model()->find(array('condition' =>$condition));
        
        $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
            
        $periodeModel = new FormPeriodeRealisasiPrasyarat();

        $this->render('vprasyarat',array('rkt'=>$rkt,'periodeModel'=>$periodeModel));
    }
    
    
    public function actionViewfproduksi(){
        $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
        $rku = Rku::model()->find(array('condition' =>$condition));
        
        $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
            
        $periodeModel = new FormPeriodeRealisasiPrasyarat();

        $this->render('vfproduksi',array('rkt'=>$rkt,'periodeModel'=>$periodeModel));
    }
    
    public function actionViewflingkungan(){
        $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
        $rku = Rku::model()->find(array('condition' =>$condition));
        
        $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
            
        $periodeModel = new FormPeriodeRealisasiPrasyarat();

        $this->render('vflingkungan',array('rkt'=>$rkt,'periodeModel'=>$periodeModel));
    }
    
    
    public function actionViewsosial(){
        $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
        $rku = Rku::model()->find(array('condition' =>$condition));
        
        $rkt = Rkt::model()->getLastRKTByRkuId($rku['id_rku']);
            
        $periodeModel = new FormPeriodeRealisasiPrasyarat();

        $this->render('vsosial',array('rkt'=>$rkt,'periodeModel'=>$periodeModel));
    }

}
