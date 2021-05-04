<?php

class RekapLingkunganController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    
    public function actionIndex() {
        
        $periodeModel = new FormPeriodeRekapPrasyarat();
        //debug($periodeModel);
        //die("test");        
        $listRKT = CHtml::listData(
            Rkt::model()->findAll(
                array(
                    'condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan(),
                    'order' => 'tahun_mulai DESC'
                )
            ), 'tahun_mulai', 'tahun_mulai'
        );
        
        $periodeModel->rkt = current($listRKT);
        
        $this->render('index', array(
            'periodeModel' => $periodeModel,
        ));
    }
    
    public function actionDungtan() {
        $query = "
            SELECT
                CONCAT('Rencana: ',rkt_lingkungan_dungtan.jumlah) AS rencana,
                master_bulan.bulan,
                realisasi_rkt_lingkungan_dungtan.tahun,
                realisasi_rkt_lingkungan_dungtan.realisasi,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_lingkungan_dungtan.tahun) as periode,
                realisasi_rkt_lingkungan_dungtan.persentase
            FROM
                realisasi_rkt_lingkungan_dungtan
                INNER JOIN rkt_lingkungan_dungtan ON realisasi_rkt_lingkungan_dungtan.id_rkt_lingkungan_dungtan = rkt_lingkungan_dungtan.id
                INNER JOIN rkt ON rkt_lingkungan_dungtan.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_lingkungan_dungtan.id_bulan = master_bulan.id
            WHERE 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_lingkungan_dungtan.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('pengamanan-hutan', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    
    public function actionHamakit() {
        $query = "
            SELECT
                CONCAT('Rencana: ',rkt_lingkungan_dalmakit.jumlah) AS rencana,
                master_bulan.bulan,
                realisasi_rkt_lingkungan_dalmakit.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_lingkungan_dalmakit.tahun) as periode,
                realisasi_rkt_lingkungan_dalmakit.realisasi,
                realisasi_rkt_lingkungan_dalmakit.persentase
            FROM
                realisasi_rkt_lingkungan_dalmakit
                INNER JOIN rkt_lingkungan_dalmakit ON realisasi_rkt_lingkungan_dalmakit.id_rkt_lingkungan_dalmakit = rkt_lingkungan_dalmakit.id
                INNER JOIN rkt ON rkt_lingkungan_dalmakit.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_lingkungan_dalmakit.id_bulan = master_bulan.id
            WHERE 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_lingkungan_dalmakit.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('hama-penyakit', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));                
    }
    
    public function actionKebakaran() {
        $query = "
            SELECT
                rkt_lingkungan_dalkar.nama_dalkar,
                rkt_lingkungan_dalkar.jumlah AS rencana,
                CONCAT(rkt_lingkungan_dalkar.nama_dalkar, ': ',rkt_lingkungan_dalkar.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_lingkungan_dalkar.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_lingkungan_dalkar.tahun) as periode,
                realisasi_rkt_lingkungan_dalkar.realisasi,
                realisasi_rkt_lingkungan_dalkar.persentase
            FROM
                realisasi_rkt_lingkungan_dalkar
                INNER JOIN rkt_lingkungan_dalkar ON realisasi_rkt_lingkungan_dalkar.id_rkt_lingkungan_dalkar = rkt_lingkungan_dalkar.id
                INNER JOIN rkt ON rkt_lingkungan_dalkar.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_lingkungan_dalkar.id_bulan = master_bulan.id
            WHERE 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_lingkungan_dalkar.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('kendali-kebakaran', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));                
    }
    
    function setPivotData($rows, $keydata)
    {
        $data = "[";
        foreach($rows as $idx => $val)
        {
           $data .= "{";
           $y=0;
           foreach($val as $keyfield => $valfield)
           {
               if(in_array($keyfield, $keydata)){
                   $data .= '"'.$keyfield.'":'.$valfield;
               } else {
                   $data .= '"'.$keyfield.'":"'.$valfield.'"';
               }
               //if($valfield != end($val)) $data .= ',';
               if($y < count($val)-1) $data .= ',';
               $y++;
           }           
           $data .= "}";
           if($val != end($rows)) $data .= ",";
        }

        $data .= "]";

        return $data;
    }
    
    
}    