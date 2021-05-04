<?php

class RekapProduksiController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    
    public function actionIndex() {
        
        //die("WKWKWK");
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
    
    public function actionPemanenan() {
        $this->layout = false;       
        $this->render('pemanenan', array());                
    }
    
    public function actionTabPemasaran() {
        $this->layout = false;       
        $this->render('tab_pemasaran', array());        
            
    }
    
    
    public function actionPengadaanBibit() {
        $query = "
            SELECT
                rkt_bibit.daur,
                rku_blok.nama_blok,
                rku_sektor.nama_sektor,
                master_jenis_produksi_lahan.jenis_produksi,
                master_jenis_tanaman.nama_tanaman,
                rkt_bibit.jumlah AS rencana,
                CONCAT(master_jenis_produksi_lahan.jenis_produksi,' - ',master_jenis_tanaman.nama_tanaman) as jenis_tanaman,
                CONCAT(rku_sektor.nama_sektor,'/',rku_blok.nama_blok,' - ', master_jenis_tanaman.nama_tanaman,' - ',rkt_bibit.jumlah) as rencana,
                master_bulan.bulan,
                
                realisasi_rkt_bibit.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_bibit.tahun) as periode,
                realisasi_rkt_bibit.realisasi,
                realisasi_rkt_bibit.persentase
            FROM
                realisasi_rkt_bibit
                INNER JOIN rkt_bibit ON realisasi_rkt_bibit.id_rkt_bibit = rkt_bibit.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_bibit.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_jenis_tanaman ON rkt_bibit.id_jenis_tanaman = master_jenis_tanaman.id
                INNER JOIN rku_blok ON rku_blok.id = rkt_bibit.id_blok
                INNER JOIN rku_sektor ON rku_sektor.id_sektor = rku_blok.id_sektor
                INNER JOIN master_bulan ON realisasi_rkt_bibit.id_bulan = master_bulan.id            
                INNER JOIN rkt ON rkt_bibit.id_rkt = rkt.id
            WHERE 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_bibit.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('pengadaan-bibit', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    
    public function actionPenyiapanLahan() {
        $query = "
            SELECT   
                rkt_siap_lahan.daur,
                rku_sektor.nama_sektor,
                rku_blok.nama_blok,
                master_jenis_produksi_lahan.jenis_produksi,
                master_jenis_lahan.jenis_lahan,
                rkt_siap_lahan.jumlah,
                CONCAT(rku_sektor.nama_sektor,'/',rku_blok.nama_blok, ' - ',master_jenis_lahan.jenis_lahan, ' - ', rkt_siap_lahan.jumlah) as rencana,
                master_bulan.bulan,
                realisasi_rkt_siap_lahan.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_siap_lahan.tahun) as periode,
                realisasi_rkt_siap_lahan.realisasi,
                realisasi_rkt_siap_lahan.persentase
            FROM
                realisasi_rkt_siap_lahan
                INNER JOIN rkt_siap_lahan ON realisasi_rkt_siap_lahan.id_rkt_siap_lahan = rkt_siap_lahan.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_siap_lahan.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_jenis_lahan ON rkt_siap_lahan.id_jenis_lahan = master_jenis_lahan.id
                INNER JOIN rku_blok ON rku_blok.id = rkt_siap_lahan.id_blok
                INNER JOIN rku_sektor ON rku_sektor.id_sektor = rku_blok.id_sektor
                INNER JOIN rkt ON rkt_siap_lahan.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_siap_lahan.id_bulan = master_bulan.id
            WHERE 
                rkt_siap_lahan.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_siap_lahan.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('penyiapan-lahan', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    
    public function actionPenanaman() {
        $query = "
            SELECT
                rkt_tanam.daur,
                rku_blok.nama_blok,
                rku_sektor.nama_sektor,
                master_jenis_produksi_lahan.jenis_produksi,
                master_jenis_lahan.jenis_lahan,
                master_jenis_tanaman.nama_tanaman,
                rkt_tanam.jumlah AS rencana,
                CONCAT(rku_sektor.nama_sektor,'/',rku_blok.nama_blok, ' - ',
                ' - ',master_jenis_tanaman.nama_tanaman,' - ', rkt_tanam.jumlah) as rencana,
                master_bulan.bulan,
                realisasi_rkt_tanam.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_tanam.tahun) as periode,
                realisasi_rkt_tanam.realisasi,
                realisasi_rkt_tanam.persentase
            FROM
                realisasi_rkt_tanam
                INNER JOIN rkt_tanam ON realisasi_rkt_tanam.id_rkt_tanam = rkt_tanam.id
                INNER JOIN rku_blok ON rku_blok.id = rkt_tanam.id_blok
                INNER JOIN rku_sektor ON rku_sektor.id_sektor = rku_blok.id_sektor
                INNER JOIN master_jenis_lahan ON rkt_tanam.id_jenis_lahan = master_jenis_lahan.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_tanam.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_jenis_tanaman ON rkt_tanam.id_jenis_tanaman = master_jenis_tanaman.id
                INNER JOIN master_bulan ON realisasi_rkt_tanam.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_tanam.id_rkt = rkt.id            
            WHERE               
                rkt_tanam.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_tanam.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('penanaman', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    
    public function actionPemeliharaan() {
        $query = "
            SELECT
                rkt_pelihara.daur,
                rku_blok.nama_blok,
                rku_sektor.nama_sektor,
                master_jenis_pemeliharaan.jenis_pemeliharaan,
                master_jenis_produksi_lahan.jenis_produksi,
                master_jenis_lahan.jenis_lahan,
                CONCAT(rku_sektor.nama_sektor,'/',rku_blok.nama_blok, ' - ',master_jenis_pemeliharaan.jenis_pemeliharaan,' - ',rkt_pelihara.jumlah) as jenis_rencana,
                master_bulan.bulan,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_pelihara.tahun) as periode,
                realisasi_rkt_pelihara.realisasi,
                realisasi_rkt_pelihara.persentase
            FROM
                realisasi_rkt_pelihara
                INNER JOIN rkt_pelihara ON realisasi_rkt_pelihara.id_rkt_pelihara = rkt_pelihara.id
                INNER JOIN rku_blok ON rku_blok.id = rkt_pelihara.id_blok
                INNER JOIN rku_sektor ON rku_sektor.id_sektor = rku_blok.id_sektor
                INNER JOIN master_jenis_pemeliharaan ON rkt_pelihara.id_jenis_pemeliharaan = master_jenis_pemeliharaan.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_pelihara.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_jenis_lahan ON rkt_pelihara.id_jenis_lahan = master_jenis_lahan.id
                INNER JOIN rkt ON rkt_pelihara.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_pelihara.id_bulan = master_bulan.id
            WHERE            
                rkt_pelihara.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_pelihara.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('pemeliharaan', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }
    

    public function actionPenjarangan() {
        $query = "
            SELECT
                master_jenis_produksi_lahan.jenis_produksi,
                rkt_jarang.jumlah AS rencana,
                CONCAT(master_jenis_produksi_lahan.jenis_produksi,' - ',rkt_jarang.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_jarang.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_jarang.tahun) as periode,
                realisasi_rkt_jarang.realisasi,
                realisasi_rkt_jarang.persentase
            FROM
                realisasi_rkt_jarang
                INNER JOIN rkt_jarang ON realisasi_rkt_jarang.id_rkt_jarang = rkt_jarang.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_jarang.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_bulan ON realisasi_rkt_jarang.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_jarang.id_rkt = rkt.id
            WHERE            
                rkt_jarang.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_jarang.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('penjarangan', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }    

    public function actionPendangiran() {
        $query = "
            SELECT
                master_jenis_produksi_lahan.jenis_produksi,
                rkt_dangir.jumlah AS rencana,
                CONCAT(master_jenis_produksi_lahan.jenis_produksi,' - ',rkt_dangir.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_dangir.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_dangir.tahun) as periode,
                realisasi_rkt_dangir.realisasi,
                realisasi_rkt_dangir.persentase
            FROM
                realisasi_rkt_dangir
                INNER JOIN rkt_dangir ON realisasi_rkt_dangir.id_rkt_dangir = rkt_dangir.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_dangir.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_bulan ON realisasi_rkt_dangir.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_dangir.id_rkt = rkt.id
            WHERE            
                rkt_dangir.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_dangir.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('pendangiran', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));        
    }    

    public function actionPemanenanRkt() {
        $query = "
            SELECT
                rkt_panen_produksi.daur,
                rku_blok.nama_blok,
                rku_sektor.nama_sektor,
                kabupaten.nama,
                master_jenis_lahan.jenis_lahan,
                master_jenis_produksi_lahan.jenis_produksi,
                rkt_panen_produksi.jumlah_luas AS rencana_luas,
                CONCAT(rku_sektor.nama_sektor,'/',rku_blok.nama_blok, ' - ',rkt_panen_produksi.jumlah_luas, ' - ',rkt_panen_produksi.jumlah_produksi) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_panen_produksi.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_panen_produksi.tahun) as periode,
                realisasi_rkt_panen_produksi.realisasi_luas,
                realisasi_rkt_panen_produksi.persentase_luas,
                realisasi_rkt_panen_produksi.realisasi_produksi,
                realisasi_rkt_panen_produksi.persentase_produksi
            FROM
                realisasi_rkt_panen_produksi
                INNER JOIN rkt_panen_produksi ON realisasi_rkt_panen_produksi.id_rkt_panen_produksi = rkt_panen_produksi.id
                INNER JOIN rku_blok ON rku_blok.id = rkt_panen_produksi.id_blok
                INNER JOIN rku_sektor ON rku_sektor.id_sektor = rku_blok.id_sektor
                INNER JOIN kabupaten ON kabupaten.id_kabupaten = rkt_panen_produksi.id_kabupaten
                INNER JOIN master_jenis_lahan ON rkt_panen_produksi.id_jenis_lahan = master_jenis_lahan.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_panen_produksi.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN rkt ON rkt_panen_produksi.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_panen_produksi.id_bulan = master_bulan.id            
            WHERE            
                rkt_panen_produksi.jumlah_luas > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_panen_produksi.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('pemanenanRkt', array(
            'model' => $this->setPivotData($model, ['realisasi_luas', 'persentase_luas','realisasi_produksi', 'persentase_produksi']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));            
        
    }    
    
    public function actionPanenLahan() {
        $query = "
            SELECT
                rkt_panen_lahan.daur,
                rku_blok.nama_blok,
                rku_sektor.nama_sektor,
                kabupaten.nama,
                master_jenis_lahan.jenis_lahan,
                master_jenis_produksi_lahan.jenis_produksi,
                rkt_panen_lahan.jumlah_luas AS rencana_luas,
                CONCAT(rku_sektor.nama_sektor,'/',rku_blok.nama_blok, ' - ',rkt_panen_lahan.jumlah_luas, 'ha - ',rkt_panen_lahan.jumlah_produksi,'m3') as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_panen_lahan.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_panen_lahan.tahun) as periode,
                realisasi_rkt_panen_lahan.realisasi_luas,
                realisasi_rkt_panen_lahan.persentase_luas,
                realisasi_rkt_panen_lahan.realisasi_produksi,
                realisasi_rkt_panen_lahan.persentase_produksi
            FROM
                realisasi_rkt_panen_lahan
                INNER JOIN rkt_panen_lahan ON realisasi_rkt_panen_lahan.id_rkt_panen_lahan = rkt_panen_lahan.id
                INNER JOIN rku_blok ON rku_blok.id = rkt_panen_lahan.id_blok
                INNER JOIN rku_sektor ON rku_sektor.id_sektor = rku_blok.id_sektor
                INNER JOIN kabupaten ON kabupaten.id_kabupaten = rkt_panen_lahan.id_kabupaten
                INNER JOIN master_jenis_lahan ON rkt_panen_lahan.id_jenis_lahan = master_jenis_lahan.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_panen_lahan.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN rkt ON rkt_panen_lahan.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_panen_lahan.id_bulan = master_bulan.id            
            WHERE            
                rkt_panen_lahan.jumlah_luas > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_panen_lahan.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('panenLahan', array(
            'model' => $this->setPivotData($model, ['realisasi_luas', 'persentase_luas','realisasi_produksi', 'persentase_produksi']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));            
        
    }  
 
    public function actionPanenHhbk() {
        $query = "
            SELECT
                master_hasil_hutan_nonkayu.nama_hhbk,
                master_jenis_produksi_lahan.jenis_produksi AS tata_ruang,
                master_bulan.bulan,
                realisasi_rkt_panen_hhbk.tahun,
                satuan_volume_nonkayu.satuan,
                CONCAT(master_hasil_hutan_nonkayu.nama_hhbk, ' - ',rkt_panen_hhbk.luas, 'ha - ',rkt_panen_hhbk.jumlah, satuan_volume_nonkayu.satuan ) as jenis_rencana,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_panen_hhbk.tahun) as periode,
                realisasi_rkt_panen_hhbk.realisasi_luas,
                realisasi_rkt_panen_hhbk.persentase_luas,
                realisasi_rkt_panen_hhbk.realisasi_produksi,
                realisasi_rkt_panen_hhbk.persentase_produksi
            FROM
                realisasi_rkt_panen_hhbk
                INNER JOIN rkt_panen_hhbk ON realisasi_rkt_panen_hhbk.id_rkt_panen_hhbk = rkt_panen_hhbk.id
                INNER JOIN rku_hasil_hutan_nonkayu_silvikultur ON rkt_panen_hhbk.id_hasil_hutan_nonkayu_silvikultur = rku_hasil_hutan_nonkayu_silvikultur.id
                INNER JOIN master_jenis_produksi_lahan ON rku_hasil_hutan_nonkayu_silvikultur.id_jenis_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_hasil_hutan_nonkayu ON rku_hasil_hutan_nonkayu_silvikultur.id_hasil_hutan_nonkayu = master_hasil_hutan_nonkayu.id
                INNER JOIN satuan_volume_nonkayu ON rku_hasil_hutan_nonkayu_silvikultur.id_satuan_volume_nonkayu = satuan_volume_nonkayu.id
                INNER JOIN rkt ON rkt_panen_hhbk.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_panen_hhbk.id_bulan = master_bulan.id                     
            WHERE            
                rkt_panen_hhbk.luas > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_panen_hhbk.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
//        debug($model);
//        die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('panenHhbk', array(
            'model' => $this->setPivotData($model, ['realisasi_luas', 'persentase_luas','realisasi_produksi', 'persentase_produksi']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));            
        
    }      
    
    public function actionVolumeHasilTanaman() {
        $query = "
            SELECT
                master_jenis_lahan.jenis_lahan,
                master_jenis_produksi_lahan.jenis_produksi,
                master_blok.nama_blok,
                master_jenis_tanaman.nama_tanaman,
                rkt_panen_volume_tanaman.jumlah AS rencana,
                CONCAT(master_jenis_tanaman.nama_tanaman,' - ', rkt_panen_volume_tanaman.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_panen_volume_tanaman.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_panen_volume_tanaman.tahun) as periode,
                realisasi_rkt_panen_volume_tanaman.realisasi,
                realisasi_rkt_panen_volume_tanaman.persentase
            FROM
                realisasi_rkt_panen_volume_tanaman
                INNER JOIN rkt_panen_volume_tanaman ON realisasi_rkt_panen_volume_tanaman.id_rkt_panen_volume_tanaman = rkt_panen_volume_tanaman.id
                INNER JOIN master_jenis_lahan ON rkt_panen_volume_tanaman.id_jenis_lahan = master_jenis_lahan.id
                INNER JOIN master_jenis_produksi_lahan ON rkt_panen_volume_tanaman.id_produksi_lahan = master_jenis_produksi_lahan.id
                INNER JOIN master_jenis_tanaman ON rkt_panen_volume_tanaman.id_jenis_tanaman = master_jenis_tanaman.id
                INNER JOIN master_blok ON rkt_panen_volume_tanaman.id_blok = master_blok.id
                INNER JOIN rkt ON rkt_panen_volume_tanaman.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_panen_volume_tanaman.id_bulan = master_bulan.id
            WHERE            
                rkt_panen_volume_tanaman.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_panen_volume_tanaman.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('volume-hasil-tanam', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));                    
    }        
    
    public function actionVolumePenyiapanLahan() {
        $query = "
            SELECT
                master_jenis_kayu.nama_kayu,
                master_jenis_kelompok_kayu.nama_kelompok,
                rkt_panen_volume_siap_lahan.jumlah AS rencana,
                CONCAT(master_jenis_kelompok_kayu.nama_kelompok,' - ',rkt_panen_volume_siap_lahan.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_panen_volume_siap_lahan.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_panen_volume_siap_lahan.tahun) as periode,
                realisasi_rkt_panen_volume_siap_lahan.realisasi,
                realisasi_rkt_panen_volume_siap_lahan.persentase
            FROM
                realisasi_rkt_panen_volume_siap_lahan
                INNER JOIN rkt_panen_volume_siap_lahan ON realisasi_rkt_panen_volume_siap_lahan.id_rkt_panen_volume_siap_lahan = rkt_panen_volume_siap_lahan.id
                INNER JOIN master_jenis_kayu ON rkt_panen_volume_siap_lahan.id_jenis_kayu = master_jenis_kayu.id
                INNER JOIN master_jenis_kelompok_kayu ON rkt_panen_volume_siap_lahan.id_jenis_kelompok_kayu = master_jenis_kelompok_kayu.id
                INNER JOIN master_bulan ON realisasi_rkt_panen_volume_siap_lahan.id_bulan = master_bulan.id
                INNER JOIN rkt ON rkt_panen_volume_siap_lahan.id_rkt = rkt.id            
            WHERE            
                rkt_panen_volume_siap_lahan.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_panen_volume_siap_lahan.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('volume-penyiapan-lahan', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));             
    }            
    
    public function actionPemasaran() {
        $query = "
            SELECT
                master_jenis_pemasaran.nama_pemasaran,
                rkt_pasar.jumlah AS renncana,
                CONCAT(master_jenis_pemasaran.nama_pemasaran,' - ',rkt_pasar.jumlah, ' m3') as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_pasar.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_pasar.tahun) as periode,
                realisasi_rkt_pasar.realisasi,
                realisasi_rkt_pasar.persentase
            FROM
                realisasi_rkt_pasar
                INNER JOIN rkt_pasar ON realisasi_rkt_pasar.id_rkt_pasar = rkt_pasar.id
                INNER JOIN master_jenis_pemasaran ON rkt_pasar.id_pemasaran = master_jenis_pemasaran.id
                INNER JOIN rkt ON rkt_pasar.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_pasar.id_bulan = master_bulan.id
            WHERE            
                rkt_pasar.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_pasar.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('pemasaran', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));             
    }
    
        public function actionPemasaranHhbk() {
        $query = "
            SELECT
                master_hasil_hutan_nonkayu.nama_hhbk,
                satuan_volume_nonkayu.satuan,
                master_jenis_pemasaran.nama_pemasaran,
                rkt_pasar_hhbk.jumlah AS rencana,
                CONCAT(master_jenis_pemasaran.nama_pemasaran,' - ',master_hasil_hutan_nonkayu.nama_hhbk,' - ',rkt_pasar_hhbk.jumlah, satuan_volume_nonkayu.satuan ) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_pasar_hhbk.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_pasar_hhbk.tahun) as periode,
                realisasi_rkt_pasar_hhbk.realisasi,
                realisasi_rkt_pasar_hhbk.persentase
            FROM
                realisasi_rkt_pasar_hhbk
                INNER JOIN rkt_pasar_hhbk ON realisasi_rkt_pasar_hhbk.id_rkt_pasar_hhbk = rkt_pasar_hhbk.id
                INNER JOIN rku_hasil_hutan_nonkayu_silvikultur ON rkt_pasar_hhbk.id_hasil_hutan_nonkayu_silvikultur = rku_hasil_hutan_nonkayu_silvikultur.id
                INNER JOIN master_hasil_hutan_nonkayu ON rku_hasil_hutan_nonkayu_silvikultur.id_hasil_hutan_nonkayu = master_hasil_hutan_nonkayu.id
                INNER JOIN satuan_volume_nonkayu ON rku_hasil_hutan_nonkayu_silvikultur.id_satuan_volume_nonkayu = satuan_volume_nonkayu.id
                INNER JOIN master_jenis_pemasaran ON rkt_pasar_hhbk.id_jenis_pasar = master_jenis_pemasaran.id
                INNER JOIN rkt ON rkt_pasar_hhbk.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_pasar_hhbk.id_bulan = master_bulan.id
            WHERE            
                rkt_pasar_hhbk.jumlah > 0 AND 
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND 
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'                
            ORDER BY realisasi_rkt_pasar_hhbk.tahun, master_bulan.id
        ";        
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;        
        $this->render('pemasaranHhbk', array(
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