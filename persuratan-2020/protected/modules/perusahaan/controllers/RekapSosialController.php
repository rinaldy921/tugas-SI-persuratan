<?php

class RekapSosialController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';


    public function actionIndex(){
        $periodeModel = new FormPeriodeRekapPrasyarat();
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

    public function actionPembangunanInfrastruktur(){
        $query = "
            SELECT
                master_jenis_infra_mukim.nama_sarana,
                rkt_infra_mukim.jumlah AS rencana,
                CONCAT(master_jenis_infra_mukim.nama_sarana,': ',rkt_infra_mukim.jumlah) as jenis_rencana,
                master_bulan.bulan,
                realisasi_rkt_infra_mukim.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_infra_mukim.tahun) as periode,
                realisasi_rkt_infra_mukim.realisasi,
                realisasi_rkt_infra_mukim.persentase
            FROM
                realisasi_rkt_infra_mukim
                INNER JOIN rkt_infra_mukim ON realisasi_rkt_infra_mukim.id_rkt_infra_mukim = rkt_infra_mukim.id
                INNER JOIN master_jenis_infra_mukim ON rkt_infra_mukim.id_infra_mukim = master_jenis_infra_mukim.id
                INNER JOIN rkt ON rkt_infra_mukim.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_infra_mukim.id_bulan = master_bulan.id
            WHERE
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'
            ORDER BY realisasi_rkt_infra_mukim.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;
        $this->render('pembangunan-infrastruktur', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));
    }

    public function actionPemberdayaan() {
        $this->layout = false;
        $this->render('pemberdayaan', array());
    }

    public function actionPembinaan() {
        $this->layout = false;
        $this->render('pembinaan', array());
    }


    public function actionKonflik() {
        $this->layout = false;
        $model = new RealisasiRktKonflikSosial;
        $model->id_perusahaan = Yii::app()->user->idPerusahaan();
        $model->tahun_mulai = $_POST['FormPeriodeRekapPrasyarat']['rkt'];
        $this->render('konflik', array(
            'model' => $model,
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));
    }

    public function actionPeningkatanSDM(){
        $query = "
            SELECT
                master_jenis_peningkatan_sdm.nama_program,
                rkt_peningkatan_sdm.jumlah,
                CONCAT(master_jenis_peningkatan_sdm.nama_program,': ',rkt_peningkatan_sdm.jumlah) as program_rencana,
                master_bulan.bulan,
                realisasi_rkt_peningkatan_sdm.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_peningkatan_sdm.tahun) as periode,
                realisasi_rkt_peningkatan_sdm.realisasi,
                realisasi_rkt_peningkatan_sdm.persentase
            FROM
                realisasi_rkt_peningkatan_sdm
                INNER JOIN rkt_peningkatan_sdm ON realisasi_rkt_peningkatan_sdm.id_rkt_peningkatan_sdm = rkt_peningkatan_sdm.id
                INNER JOIN master_jenis_peningkatan_sdm ON rkt_peningkatan_sdm.id_peningkatan_sdm = master_jenis_peningkatan_sdm.id
                INNER JOIN rkt ON rkt_peningkatan_sdm.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_peningkatan_sdm.id_bulan = master_bulan.id
            WHERE
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'
            ORDER BY realisasi_rkt_peningkatan_sdm.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;
        $this->render('peningkatan-sdm', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));
    }

    public function actionKerjasamaKoperasi(){
        $query = "
            SELECT
                CONCAT('Rencana: ',rkt_kerjasama_koperasi.jumlah) AS rencana,
                master_bulan.bulan,
                realisasi_rkt_kerjasama_koperasi.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_kerjasama_koperasi.tahun) as periode,
                realisasi_rkt_kerjasama_koperasi.realisasi,
                realisasi_rkt_kerjasama_koperasi.persentase
            FROM
                realisasi_rkt_kerjasama_koperasi
                INNER JOIN rkt_kerjasama_koperasi ON realisasi_rkt_kerjasama_koperasi.id_rkt_kerjasama_koperasi = rkt_kerjasama_koperasi.id
                INNER JOIN rkt ON rkt_kerjasama_koperasi.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_kerjasama_koperasi.id_bulan = master_bulan.id
            WHERE
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'
            ORDER BY realisasi_rkt_kerjasama_koperasi.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;
        $this->render('kerjasama-koperasi', array(
            'model' => $this->setPivotData($model, ['realisasi', 'persentase']),
            'tahun' => $_POST['FormPeriodeRekapPrasyarat']['rkt']
        ));
    }

    public function actionMitraUsaha(){
        $query = "
            SELECT
                CONCAT('Rencana: ',rkt_bangun_mitra.jumlah) AS rencana,
                master_bulan.bulan,
                realisasi_rkt_bangun_mitra.tahun,
                CONCAT(master_bulan.bulan,' ',realisasi_rkt_bangun_mitra.tahun) as periode,
                realisasi_rkt_bangun_mitra.realisasi,
                realisasi_rkt_bangun_mitra.persentase
            FROM
                realisasi_rkt_bangun_mitra
                INNER JOIN rkt_bangun_mitra ON realisasi_rkt_bangun_mitra.id_rkt_bangun_mitra = rkt_bangun_mitra.id
                INNER JOIN rkt ON rkt_bangun_mitra.id_rkt = rkt.id
                INNER JOIN master_bulan ON realisasi_rkt_bangun_mitra.id_bulan = master_bulan.id
            WHERE
                rkt.id_perusahaan = '".Yii::app()->user->idPerusahaan()."' AND
                rkt.tahun_mulai = '".$_POST['FormPeriodeRekapPrasyarat']['rkt']."'
            ORDER BY realisasi_rkt_bangun_mitra.tahun, master_bulan.id
        ";
        //die($query);
        $model = Yii::app()->db->createCommand($query)->queryAll();
        //debug($model);
        //die( __FUNCTION__ );
        $this->layout = false;
        $this->render('bangun-mitra', array(
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