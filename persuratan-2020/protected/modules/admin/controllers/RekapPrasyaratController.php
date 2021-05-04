<?php

class RekapPrasyaratController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    
    public function actionIndex($id) {
        //die($id);
        $iup = Iuphhk::model()->findByPk($id);
        //debug($iup->idPerusahaan);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }        
        $periodeModel = new FormPeriodeRekapPrasyarat();
        //debug($iup->id_perusahaan);
        $periodeModel->id_perusahaan = $iup->id_perusahaan;
        
        $listRKT = CHtml::listData(
            Rkt::model()->findAll(
                array(
                    'condition' => 'id_perusahaan = ' . $iup->idPerusahaan->id_perusahaan,
                    'order' => 'tahun_mulai DESC'
                )
            ), 'tahun_mulai', 'tahun_mulai'
        );
        
        $periodeModel->rkt = current($listRKT);
        
        $this->render('index', array(
            'iup' => $iup,
            'idPerusahaan' => $id,
            'periodeModel' => $periodeModel,
        ));
    }
    
    public function actionPenataanRuang() {
        $this->layout = false;
        $this->render('penataan-ruang', array(
        ));
    }
    
    public function actionGanis() {
        $query = "
            SELECT
                rkt_serapan_tenaga_kerja.id_rkt,
                master_jenis_kewarganegaraan.kewarganegaraan,
                master_pendidikan.pendidikan,
                rkt_serapan_tenaga_kerja.jumlah AS rencana,
                master_bulan.bulan,
                realisasi_rkt_serapan_tenaga_kerja.tahun,
                CONCAT(master_bulan.bulan,' ', realisasi_rkt_serapan_tenaga_kerja.tahun) as periode,
                realisasi_rkt_serapan_tenaga_kerja.realisasi,
                realisasi_rkt_serapan_tenaga_kerja.persentase,
                rkt_serapan_tenaga_kerja.is_tenaga_kehutanan,
                rkt_serapan_tenaga_kerja.is_tenaga_tetap,
                CONCAT(rkt_serapan_tenaga_kerja.jumlah) as rencana_tenaga_kerja
            FROM
                realisasi_rkt_serapan_tenaga_kerja
                INNER JOIN rkt_serapan_tenaga_kerja ON realisasi_rkt_serapan_tenaga_kerja.id_rkt_serapan_tenaga_kerja = rkt_serapan_tenaga_kerja.id
                INNER JOIN master_jenis_kewarganegaraan ON rkt_serapan_tenaga_kerja.id_jenis_kewarganegaraan = master_jenis_kewarganegaraan.id
                INNER JOIN master_pendidikan ON rkt_serapan_tenaga_kerja.id_pendidikan = master_pendidikan.id_pendidikan
                INNER JOIN master_bulan ON realisasi_rkt_serapan_tenaga_kerja.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_serapan_tenaga_kerja.id_rkt = rkt.id           
            WHERE                 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_serapan_tenaga_kerja.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        $this->layout = false;        
        $this->render('tenaga-teknis', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));                
    }
    
    public function actionTataBatas() {
        //echo "TATA BATAS";
        //debug($_POST);
        $query = "
            SELECT
                CONCAT(master_jenis_batas.jenis_batas,' - ',rkt_tata_batas.jumlah,' Km') as rencana_jenis_batas,
                CONCAT(master_bulan.bulan,' ', realisasi_rkt_tata_batas.tahun) as periode,
                master_jenis_batas.jenis_batas,
                master_bulan.bulan,
                realisasi_rkt_tata_batas.tahun,
                rkt_tata_batas.jumlah AS rencana,
                realisasi_rkt_tata_batas.realisasi,
                realisasi_rkt_tata_batas.persentase                
            FROM
                realisasi_rkt_tata_batas
                INNER JOIN rkt_tata_batas ON realisasi_rkt_tata_batas.id_rkt_tata_batas = rkt_tata_batas.id
                INNER JOIN rkt ON rkt_tata_batas.id_rkt = rkt.id
                INNER JOIN master_jenis_batas ON rkt_tata_batas.id_jenis_batas = master_jenis_batas.id
                INNER JOIN master_bulan ON realisasi_rkt_tata_batas.id_bulan = master_bulan.id 
            WHERE 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_tata_batas.tahun, master_bulan.id
        ";
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('tata-batas', array(
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

    public function actionRuangLindung() {
        $query = "
            SELECT
                CONCAT(master_jenis_kawasan_lindung.nama_jenis,'   -   ', rkt_kawasan_lindung.jumlah,' Ha') as jenis_kawasan_lindung,
                master_jenis_kawasan_lindung.nama_jenis,
                rkt_kawasan_lindung.jumlah AS rencana,
                master_bulan.bulan,
                realisasi_rkt_kawasan_lindung.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_kawasan_lindung.tahun) as periode,
                realisasi_rkt_kawasan_lindung.realisasi,
                realisasi_rkt_kawasan_lindung.persentase
            FROM
                realisasi_rkt_kawasan_lindung
                INNER JOIN rkt_kawasan_lindung ON realisasi_rkt_kawasan_lindung.id_rkt_kawasan_lindung = rkt_kawasan_lindung.id
                INNER JOIN master_jenis_kawasan_lindung ON master_jenis_kawasan_lindung.id = rkt_kawasan_lindung.id_kawasan_lindung
                INNER JOIN master_bulan ON realisasi_rkt_kawasan_lindung.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_kawasan_lindung.id_rkt = rkt.id           
            WHERE 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_kawasan_lindung.tahun, master_bulan.id
        ";
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('ruang-lindung', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    
    public function actionRuangNonEfektif() {
        $query = "
            SELECT
                rkt_areal_non_produktif.jumlah AS rencana,
                master_bulan.bulan,
                realisasi_rkt_areal_non_produktif.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_areal_non_produktif.tahun) as periode,
                realisasi_rkt_areal_non_produktif.realisasi,
                realisasi_rkt_areal_non_produktif.persentase
            FROM
                realisasi_rkt_areal_non_produktif 
                INNER JOIN rkt_areal_non_produktif ON realisasi_rkt_areal_non_produktif.id_rkt_areal_non_produktif = rkt_areal_non_produktif.id
                INNER JOIN master_bulan ON realisasi_rkt_areal_non_produktif.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_areal_non_produktif.id_rkt = rkt.id       
            WHERE 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_areal_non_produktif.tahun, master_bulan.id
        ";
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('ruang-non-produktif', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
        
    }

    public function actionRuangEfektif() {
        $query = "
            SELECT
                master_blok.nama_blok,                
                master_jenis_produksi_lahan.jenis_produksi,
                rkt_areal_produktif.jumlah AS rencana,
                CONCAT(master_jenis_produksi_lahan.jenis_produksi,' - ',rkt_areal_produktif.jumlah,' Ha') as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_areal_produktif.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_areal_produktif.tahun) as periode,
                realisasi_rkt_areal_produktif.realisasi,
                realisasi_rkt_areal_produktif.persentase                 
            FROM
                realisasi_rkt_areal_produktif
                INNER JOIN rkt_areal_produktif ON realisasi_rkt_areal_produktif.id_rkt_areal_produktif = rkt_areal_produktif.id
                INNER JOIN rkt ON rkt_areal_produktif.id_rkt = rkt.id
                INNER JOIN master_blok ON master_blok.id = rkt_areal_produktif.id_blok
                INNER JOIN master_jenis_produksi_lahan ON rkt_areal_produktif.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_bulan ON realisasi_rkt_areal_produktif.id_bulan = master_bulan.id
            WHERE 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_areal_produktif.tahun, master_bulan.id
        ";
        $model = Yii::app()->db->createCommand($query)->queryAll();
        $this->layout = false;        
        $this->render('ruang-produktif', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    
    public function actionArealKerja() {
        $query = "
            SELECT
                rku_blok.nama_blok,
                rku_sektor.nama_sektor,
                CONCAT(rku_sektor.nama_sektor,' - ',rku_blok.nama_blok) as petak_kerja,
                master_jenis_produksi_lahan.jenis_produksi,
                rkt_areal_kerja.jumlah AS rencana,
                CONCAT(master_jenis_produksi_lahan.jenis_produksi,' - ',rkt_areal_kerja.jumlah,' Ha') as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_areal_kerja.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_areal_kerja.tahun) as periode,
                realisasi_rkt_areal_kerja.realisasi,
                realisasi_rkt_areal_kerja.persentase                 
            FROM
                realisasi_rkt_areal_kerja 
                INNER JOIN rkt_areal_kerja ON realisasi_rkt_areal_kerja.id_rkt_areal_kerja = rkt_areal_kerja.id
                INNER JOIN rkt ON rkt_areal_kerja.id_rkt = rkt.id
                INNER JOIN rku_blok ON rku_blok.id = rkt_areal_kerja.id_blok
                INNER JOIN rku_sektor ON rku_sektor.id_sektor = rku_blok.id_sektor
                INNER JOIN master_jenis_produksi_lahan ON rkt_areal_kerja.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_bulan ON realisasi_rkt_areal_kerja.id_bulan = master_bulan.id
            WHERE 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_areal_kerja.tahun, master_bulan.id
        ";
        $model = Yii::app()->db->createCommand($query)->queryAll();
        $this->layout = false;        
        $this->render('areal-kerja', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    
    public function actionBukaHutan() {
        $query = "
            SELECT
                master_jenis_pwh.jenis_pembukaan,
                rkt_pwh.jumlah AS rencana,
                CONCAT(master_jenis_pwh.jenis_pembukaan,' - ',rkt_pwh.jumlah,' Km') as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_pwh.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_pwh.tahun) as periode,
                realisasi_rkt_pwh.realisasi,
                realisasi_rkt_pwh.persentase
            FROM
                realisasi_rkt_pwh
                INNER JOIN rkt_pwh ON realisasi_rkt_pwh.id_rkt_pwh = rkt_pwh.id
                INNER JOIN master_jenis_pwh ON rkt_pwh.id_pwh = master_jenis_pwh.id
                INNER JOIN rkt ON rkt_pwh.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_pwh.id_bulan = master_bulan.id        
            WHERE 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_pwh.tahun, master_bulan.id
        ";
        $model = Yii::app()->db->createCommand($query)->queryAll();
        $this->layout = false;        
        $this->render('buka-hutan', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        

    }
    
    public function actionPeralatan() {
        $query = "
            SELECT
                rkt_masuk_guna_alat.nama_peralatan,
                realisasi_rkt_masuk_guna_alat.id_rkt_masuk_guna_alat,
                rkt_masuk_guna_alat.jumlah AS rencana,
                CONCAT(rkt_masuk_guna_alat.nama_peralatan,' - ',rkt_masuk_guna_alat.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_masuk_guna_alat.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_masuk_guna_alat.tahun) as periode,
                realisasi_rkt_masuk_guna_alat.realisasi,
                realisasi_rkt_masuk_guna_alat.persentase
            FROM
                realisasi_rkt_masuk_guna_alat
                INNER JOIN rkt_masuk_guna_alat ON realisasi_rkt_masuk_guna_alat.id_rkt_masuk_guna_alat = rkt_masuk_guna_alat.id
                INNER JOIN rkt ON rkt_masuk_guna_alat.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_masuk_guna_alat.id_bulan = master_bulan.id
            WHERE 
                realisasi_rkt_masuk_guna_alat.realisasi != 0 AND 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_masuk_guna_alat.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        $this->layout = false;        
        $this->render('peralatan', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));                
    }
    
    public function actionSarpras() {
        $query = "
            SELECT
                rkt_sarpras.nama_sarpras,
                rkt_sarpras.jumlah AS rencana,
                CONCAT(rkt_sarpras.nama_sarpras,' - ',rkt_sarpras.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_sarpras.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_sarpras.tahun) as periode,
                realisasi_rkt_sarpras.realisasi,
                realisasi_rkt_sarpras.persentase
            FROM
                realisasi_rkt_sarpras
                INNER JOIN rkt_sarpras ON realisasi_rkt_sarpras.id_rkt_sarpras = rkt_sarpras.id
                INNER JOIN master_bulan ON realisasi_rkt_sarpras.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_sarpras.id_rkt = rkt.id
            WHERE 
                realisasi_rkt_sarpras.realisasi != 0 AND 
                rkt.id_perusahaan = '".$_POST['FormPeriodeRekapPrasyarat']['id_perusahaan']."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_sarpras.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        $this->layout = false;        
        $this->render('sarana-prasarana', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));                
    }    
    
    
}